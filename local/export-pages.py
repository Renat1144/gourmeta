"""Export the public Gourmeta WordPress pages as a GitHub Pages snapshot."""

import argparse
from concurrent.futures import ThreadPoolExecutor
from io import BytesIO
from pathlib import Path
import re
from urllib.error import HTTPError
from urllib.parse import parse_qs, quote, unquote, urljoin, urlsplit
from urllib.request import HTTPRedirectHandler, build_opener
from xml.etree import ElementTree

from lxml import etree, html
from PIL import Image, ImageOps


SOURCE = "http://127.0.0.1:8187"
LIVE_SITE = "http://gourmeta.ru"
PUBLIC = "https://renat1144.github.io/gourmeta"
SITE_HOSTS = {urlsplit(SOURCE).netloc, "gourmeta.ru", "www.gourmeta.ru"}
SITEMAPS = ("page-sitemap.xml", "coffee-dispensers-sitemap.xml", "category-sitemap.xml")
PAGE_PATH = re.compile(r"/(?:(?:ru|en|category)(?:/[\w%-]+)*/?|(?:vakansii|otzyivyi|privacy-policy|personal-data-consent)/?)?$")
ASSET_SUFFIXES = {
    ".css", ".js", ".png", ".jpg", ".jpeg", ".webp", ".gif", ".svg", ".ico",
    ".woff", ".woff2", ".ttf", ".otf", ".eot", ".mp4",
}
ASSET_PREFIXES = ("/wp-content/themes/", "/wp-content/uploads/", "/wp-content/plugins/", "/wp-includes/")
CSS_URL = re.compile(r"""url\(\s*(?:(["'])(.*?)\1|([^\s)]+))\s*\)""", re.I)
TRACKING = re.compile(r"google-analytics|googletagmanager|mc\.yandex\.ru|yandex_metrika|addthis", re.I)
DYNAMIC_SCRIPT = re.compile(r"wpcf7|wp-emoji|wp_json|wp-json", re.I)
UNAVAILABLE_EXTERNAL_IMAGE = "https://www.lorcoffee.ru/siteassets/homepage/caps_380w.png"
ROUTE_ALIASES = {
    "/ru/equipment/cafitesse/cafitesse-quantum-120/": "/ru/equipment/cafitesse/",
    "/ru/kofe/chay/": "/ru/chay/",
    "/ru/kofe/ingredientyi/": "/ru/ingredientyi/",
    "/ru/kofe/komponentyi/": "/ru/komponentyi/",
    "/ru/kofe/rastvorimyiy-kofe/": "/ru/rastvorimyiy-kofe/",
    "/ru/kofe/zamorozhennaya-vyipechka/zamorozhennaya-vyipechka/": "/ru/zamorozhennaya-vyipechka/",
}


class LocalRedirects(HTTPRedirectHandler):
    def redirect_request(self, req, fp, code, msg, headers, newurl):
        if urlsplit(newurl).netloc != urlsplit(SOURCE).netloc:
            raise HTTPError(newurl, code, "Redirect left the local WordPress site", headers, fp)
        return super().redirect_request(req, fp, code, msg, headers, newurl)


def download(path):
    url = SOURCE + quote(path, safe="/%")
    for attempt in range(2):
        try:
            with build_opener(LocalRedirects()).open(url, timeout=25) as response:
                return unquote(urlsplit(response.url).path), response.headers.get_content_type(), response.read()
        except HTTPError as error:
            if error.code < 500 or attempt:
                return path, "", b""
        except OSError:
            if attempt:
                raise
    raise RuntimeError("Download interrupted")


def site_url(value, base):
    parts = urlsplit(urljoin(SOURCE + quote(base, safe="/%"), value))
    if parts.scheme not in ("http", "https") or parts.netloc not in SITE_HOSTS:
        return None
    path = unquote(parts.path) or "/"
    if "\\" in path or ".." in path.split("/") or ":" in path:
        return None
    return path, parts.query, parts.fragment


def page_link(value, base):
    if not value or value.startswith("#"):
        return None
    target = site_url(value, base)
    if target and PAGE_PATH.fullmatch(target[0]):
        return target[0]
    return None


def parse_document(data):
    return html.document_fromstring(data, parser=html.HTMLParser(encoding="utf-8", remove_comments=True))


def sitemap_pages():
    pages = {"/"}
    for name in SITEMAPS:
        _, _, data = download("/" + name)
        if not data:
            raise RuntimeError(f"Missing WordPress sitemap {name}")
        tree = ElementTree.fromstring(data)
        for entry in tree:
            name = entry.findtext("{*}loc", "")
            path = page_link(name, "/")
            if path:
                pages.add(path)
    return pages


def collect_pages(pool):
    pending = sitemap_pages()
    documents, redirects, unavailable = {}, {}, set()
    while pending:
        if len(documents) + len(pending) > 160:
            raise RuntimeError("Public page crawl exceeded the expected Gourmeta size")
        paths = sorted(pending)
        pending.clear()
        for requested, (path, content_type, data) in zip(paths, pool.map(download, paths), strict=True):
            if not PAGE_PATH.fullmatch(path) or content_type != "text/html" or not data:
                unavailable.add(requested)
                continue
            redirects[requested] = path
            if path in documents:
                continue
            document = parse_document(data)
            if document.xpath('//form[contains(@class, "post-password-form") or contains(@action, "action=postpass")]'):
                unavailable.update((requested, path))
                continue
            documents[path] = document
            for value in document.xpath("//a/@href"):
                linked = page_link(value, path)
                if linked and linked not in ROUTE_ALIASES:
                    pending.add(linked)
        pending.difference_update(redirects, documents, unavailable)
    if "/" not in documents:
        raise RuntimeError("The public home page did not export")
    return documents, redirects, unavailable


def add_note(container, label, target, message):
    note = html.Element("p", {"class": "gourmeta-preview-note"})
    note.text = message + " "
    link = html.Element("a", href=target, rel="external")
    link.text = label
    note.append(link)
    container.append(note)


def disable_forms(document, path):
    english = path.startswith("/en/")
    for form in document.xpath('//form|//div[contains(concat(" ",normalize-space(@class)," ")," wpcf7-form ")]'):
        notice = html.Element("div")
        add_note(
            notice,
            "Open the live form" if english else "Открыть форму на сайте Gourmeta",
            LIVE_SITE + quote(path, safe="/"),
            "To send a message, use the form on the Gourmeta website." if english
            else "Заявку можно отправить через форму на сайте Gourmeta.",
        )
        notice.tail = form.tail
        form.getparent().replace(form, notice)


def rewrite_document(document, path, rewrite):
    disable_forms(document, path)
    if path.endswith("/compare/"):
        headings = document.xpath("//h1")
        if headings:
            notice = html.Element("div")
            english = path.startswith("/en/")
            add_note(notice, "Open the live comparison" if english else "Открыть сравнение на сайте Gourmeta",
                     LIVE_SITE + path, "Comparison is available on the original site." if english
                     else "Сравнение оборудования работает на основном сайте.")
            headings[0].addnext(notice)

    for element in document.xpath("//script|//noscript|//link|//meta"):
        src = element.get("src", "")
        ident = element.get("id", "")
        related = element.get("href", "")
        text = element.text or ""
        if element.tag == "script":
            if (element.get("type") == "application/ld+json" or TRACKING.search(src + text)
                    or DYNAMIC_SCRIPT.search(ident + text) or "contact-form-7/" in src):
                element.drop_tree()
                continue
            if src and site_url(src, path) is None and urlsplit(src).hostname != "api-maps.yandex.ru":
                element.drop_tree()
                continue
            if text:
                element.text = text.replace(SOURCE, PUBLIC).replace(LIVE_SITE + "/", PUBLIC + "/")
        elif element.tag == "noscript":
            for pixel in element.xpath(".//img"):
                if TRACKING.search(pixel.get("src", "")):
                    element.drop_tree()
                    break
        elif element.tag == "link":
            relations = set(element.get("rel", "").lower().split())
            if "wp-json" in related or relations.intersection({"pingback", "shortlink", "https://api.w.org/"}):
                element.drop_tree()
                continue
        elif element.get("name", "").lower() == "robots":
            element.set("content", "noindex, follow")

    if not document.xpath('//meta[translate(@name,"ROBOTS","robots")="robots"]'):
        document.find("head").append(html.Element("meta", name="robots", content="noindex, follow"))
    for element in document.iter():
        if not isinstance(element.tag, str):
            continue
        for attribute in ("href", "src", "poster", "data-src", "data-large_image"):
            if attribute == "href" and "external" in element.get("rel", "").split():
                continue
            if attribute in element.attrib:
                element.set(attribute, rewrite(element.get(attribute), path))
        if "srcset" in element.attrib:
            candidates = [entry.strip().split() for entry in element.get("srcset").split(",")]
            element.set("srcset", ", ".join(" ".join([rewrite(c[0], path), *c[1:]]) for c in candidates if c))
        if element.tag == "meta" and element.get("property", "").startswith("og:"):
            if element.get("property") in ("og:image", "og:url") and "content" in element.attrib:
                element.set("content", rewrite(element.get("content"), path, absolute=True))
        if element.tag == "a" and (element.text or "").startswith(SOURCE + "/"):
            element.text = rewrite(element.text, path, absolute=True)
        if "style" in element.attrib:
            element.set("style", rewrite_css(element.get("style"), path, rewrite))
        if element.tag == "style" and element.text:
            element.text = rewrite_css(element.text, path, rewrite)


def rewrite_css(text, path, rewrite):
    return CSS_URL.sub(lambda match: 'url("' + rewrite(match[2] or match[3], path) + '")', text)


def remove_private_image_metadata(data, suffix):
    if suffix not in {".jpg", ".jpeg", ".png", ".webp"}:
        return data
    with Image.open(BytesIO(data)) as picture:
        exif = picture.getexif()
        private_fields = {270, 315, 34853, 37510, 40092, 40093, 42032, 42033}
        if not (private_fields.intersection(exif) or any("xmp" in key.lower() for key in picture.info)):
            return data
        output = BytesIO()
        clean = ImageOps.exif_transpose(picture)
        for key in tuple(clean.info):
            if key == "exif" or "xmp" in key.lower():
                clean.info.pop(key, None)
        options = {"icc_profile": picture.info.get("icc_profile")}
        if picture.format == "JPEG":
            options.update(quality=95, subsampling=0)
        clean.save(output, format=picture.format, **options)
        return output.getvalue()


def remove_missing_images(document, missing, prefix):
    def is_missing(value):
        if value == UNAVAILABLE_EXTERNAL_IMAGE:
            return True
        path = unquote(urlsplit(value).path)
        return path.startswith(prefix + "/") and path.removeprefix(prefix) in missing

    for image in document.xpath("//img[@src]"):
        if is_missing(image.get("src")):
            parent = image.getparent()
            if parent.tag == "a" and len(parent) == 1 and is_missing(parent.get("href", "")):
                parent.drop_tree()
            else:
                image.drop_tree()
    for meta in document.xpath('//meta[@property="og:image" and @content]'):
        if is_missing(meta.get("content")):
            meta.drop_tree()


def export(output):
    if output.exists() and any(output.iterdir()):
        raise ValueError("Use an empty output folder for the static site")
    output.mkdir(parents=True, exist_ok=True)
    assets = set()
    prefix = urlsplit(PUBLIC).path.rstrip("/")
    with ThreadPoolExecutor(max_workers=9) as pool:
        documents, redirects, unavailable = collect_pages(pool)

        def rewrite(value, base, absolute=False):
            if not value or value.startswith("#"):
                return value
            target = site_url(value, base)
            if target is None:
                return value
            path, query, fragment = target
            tail = ("?" + query if query else "") + ("#" + fragment if fragment else "")
            path = ROUTE_ALIASES.get(path, path)
            suffix = Path(path).suffix.lower()
            if path == "/favicon.ico" or (path.startswith(ASSET_PREFIXES) and suffix in ASSET_SUFFIXES):
                assets.add(path)
            elif path in redirects and redirects[path] in documents:
                path = redirects[path]
            elif path not in documents:
                return LIVE_SITE + quote(path, safe="/%") + tail
            destination = prefix + quote(path, safe="/%") + tail
            if absolute:
                return PUBLIC.removesuffix(prefix) + destination
            return destination

        for path, document in documents.items():
            rewrite_document(document, path, rewrite)

        processed, missing_assets = set(), set()
        while assets - processed:
            paths = sorted(assets - processed)
            processed.update(paths)
            for requested, (_, mime, data) in zip(paths, pool.map(download, paths), strict=True):
                if not data or mime == "text/html":
                    missing_assets.add(requested)
                    continue
                file = output / requested.lstrip("/")
                suffix = file.suffix.lower()
                if suffix == ".css":
                    data = rewrite_css(data.decode("utf-8-sig"), requested, rewrite).encode("utf-8")
                else:
                    data = remove_private_image_metadata(data, suffix)
                file.parent.mkdir(parents=True, exist_ok=True)
                file.write_bytes(data)

    for path, document in sorted(documents.items()):
        remove_missing_images(document, missing_assets, prefix)
        file = output / path.strip("/") / "index.html"
        file.parent.mkdir(parents=True, exist_ok=True)
        markup = etree.tostring(document, method="html", encoding="utf-8", doctype="<!doctype html>")
        file.write_bytes(markup)

    (output / ".nojekyll").touch()
    print(f"Exported {len(documents)} public pages and {len(processed) - len(missing_assets)} assets")
    if unavailable:
        print("Unavailable routes:", ", ".join(sorted(unavailable)))
    if missing_assets:
        print("Unavailable assets:", ", ".join(sorted(missing_assets)))


if __name__ == "__main__":
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument("output", type=Path)
    export(parser.parse_args().output)
