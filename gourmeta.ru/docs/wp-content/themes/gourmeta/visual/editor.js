(function (wp, settings) {
	'use strict';

	const { createElement: el, Fragment, createPortal, useEffect, useState } = wp.element;
	const { InspectorControls, MediaUpload, MediaUploadCheck, RichText, InnerBlocks, useBlockProps, useInnerBlocksProps } = wp.blockEditor;
	const { Button, CheckboxControl, Modal, Notice, PanelBody, SelectControl, Spinner, TextControl, ToggleControl } = wp.components;
	const { useSelect } = wp.data;

	const getPostId = (select) => select('core/editor').getCurrentPostId();
	const componentTitles = {
		cafitesse: 'Каталог Cafitesse',
		espresso: 'Каталог Espresso',
		compare: 'Сравнение оборудования',
		order: 'Выбранное оборудование',
		form: 'Контактная форма',
		sitemap: 'Карта сайта',
		map: 'Карта проезда',
	};

	function usePreview(id, kind, shortcode) {
		const [revision, setRevision] = useState(0);
		useEffect(() => {
			const refresh = () => setRevision((value) => value + 1);
			document.addEventListener('gourmeta-site-updated', refresh);
			return () => document.removeEventListener('gourmeta-site-updated', refresh);
		}, []);
		const [state, setState] = useState({});
		useEffect(() => {
			if (!id) return;
			let active = true;
			const path = wp.url.addQueryArgs('/gourmeta/v1/components/' + id, { kind, shortcode, revision });
			setState({ loading: true });
			wp.apiFetch({ path }).then(
				(result) => { if (active) setState(result); },
				(error) => { if (active) setState({ error: error.message || 'Не удалось загрузить предпросмотр.' }); }
			);
			return () => { active = false; };
		}, [id, kind, shortcode, revision]);
		return state;
	}

	function elementProps(attributes, exclude = []) {
		const props = {};
		for (const [key, value] of Object.entries(attributes || {})) {
			if (exclude.includes(key)) continue;
			if (key === 'style') {
				const declaration = new Option().style;
				declaration.cssText = value;
				const style = {};
				for (const property of declaration) {
					const prop = property.startsWith('--') ? property : property.replace(/^-ms-/, 'ms-').replace(/-([a-z])/g, (_, character) => character.toUpperCase());
					style[prop] = declaration.getPropertyValue(property);
				}
				props.style = style;
			} else if (key === 'class') {
				props.className = value;
			} else if (key === 'colspan' || key === 'rowspan' || key === 'srcset' || key === 'tabindex') {
				const names = { colspan: 'colSpan', rowspan: 'rowSpan', srcset: 'srcSet', tabindex: 'tabIndex' };
				props[names[key]] = value;
			} else if (/^(?:id|title|alt|width|height|scope|align|name|sizes|src|loading|decoding|rel|target|role|type|start|dir|lang|aria-[\w-]+|data-[\w-]+)$/.test(key)) {
				props[key] = value;
			}
		}
		return props;
	}

	function mediaButton(label, onSelect) {
		return el(MediaUploadCheck, {}, el(MediaUpload, {
			allowedTypes: ['image'], onSelect,
			render: ({ open }) => el(Button, { variant: 'secondary', onClick: open }, label),
		}));
	}

	function imageControls(html, update) {
		return el(Fragment, {},
			mediaButton('Выбрать изображение', (image) => {
				const next = { ...html, src: image.url, alt: image.alt || '', width: image.width || '', height: image.height || '' };
				const classes = (html.class || '').split(/\s+/).filter((name) => name && !/^wp-image-\d+$/.test(name));
				if (Number.isInteger(image.id)) classes.push('wp-image-' + image.id);
				next.class = classes.join(' ');
				delete next.srcset;
				delete next.sizes;
				update(next);
			}),
			el(TextControl, { label: 'Адрес изображения', value: html.src?.startsWith('data:') ? '' : html.src || '', onChange: (src) => update({ ...html, src, srcset: '', sizes: '' }) }),
			el(TextControl, { label: 'Альтернативный текст', value: html.alt || '', onChange: (alt) => update({ ...html, alt }) })
		);
	}

	function layoutPanel(html, update, children) {
		return el(InspectorControls, {}, el(PanelBody, { title: 'Настройки элемента' },
			children,
			el(TextControl, { label: 'Класс оформления', value: html.class || '', onChange: (value) => update({ ...html, class: value }) }),
			el(TextControl, { label: 'Стили элемента (CSS)', value: html.style || '', onChange: (style) => update({ ...html, style }) })
		));
	}

	function Section({ attributes, setAttributes, name, isSelected }) {
		const html = attributes.html || {};
		const update = (value) => setAttributes({ html: value });
		const link = name === 'gourmeta/link';
		const tag = link ? 'a' : attributes.tag || 'div';
		const props = useBlockProps({
			...elementProps(html, ['href']),
			...(link ? { href: html.href || '#', onClick: (event) => event.preventDefault() } : {}),
		});
		const inner = useInnerBlocksProps(props, { renderAppender: isSelected && ['div', 'section', 'article'].includes(tag) ? InnerBlocks.ButtonBlockAppender : false });
		const voidTags = ['br', 'hr', 'col'];
		return el(Fragment, {},
			layoutPanel(html, update, link ? el(TextControl, { label: 'Куда ведёт ссылка', value: html.href || '', onChange: (href) => update({ ...html, href }) }) : null),
			voidTags.includes(tag) ? el(tag, props) : el(tag, inner)
		);
	}

	function Text({ attributes, setAttributes }) {
		const html = attributes.html || {};
		const props = useBlockProps(elementProps(html, ['href']));
		return el(Fragment, {},
			layoutPanel(html, (value) => setAttributes({ html: value })),
			el(RichText, { ...props, tagName: attributes.tag || 'p', value: attributes.value || '', placeholder: 'Введите текст', onChange: (value) => setAttributes({ value }) })
		);
	}

	function ImageBlock({ attributes, setAttributes }) {
		const html = attributes.html || {};
		const update = (value) => setAttributes({ html: value });
		const imageProps = { ...elementProps(html, ['src', 'alt']), src: html.src, alt: html.alt || '', draggable: false };
		const zoom = Boolean(attributes.lightbox && html.src);
		const props = useBlockProps(zoom ? { className: 'gourmeta-image-zoom' } : html.src ? imageProps : { className: html.class });
		return el(Fragment, {},
			layoutPanel(html, update, el(Fragment, {},
				imageControls(html, update),
				el(ToggleControl, {
					label: 'Увеличивать по клику',
					checked: Boolean(attributes.lightbox),
					onChange: (lightbox) => setAttributes({ lightbox }),
				})
			)),
			zoom ? el('div', props, el('img', imageProps)) :
				html.src ? el('img', props) : el('div', props, mediaButton('Выбрать изображение', (image) => update({ ...html, src: image.url, alt: image.alt || '' })))
		);
	}

	function Title() {
		const [title, setTitle] = wp.coreData.useEntityProp('postType', 'page', 'title');
		return el(RichText, {
			...useBlockProps(), tagName: 'h1', value: title?.raw ?? title ?? '', placeholder: 'Заголовок страницы',
			onChange: (value) => {
				const text = document.createElement('span');
				text.innerHTML = value;
				setTitle(text.textContent);
			}, allowedFormats: [],
		});
	}

	function Slide({ attributes, setAttributes }) {
		const html = attributes.html || {};
		return el(Fragment, {},
			el(InspectorControls, {}, el(PanelBody, { title: 'Изображение слайда' }, imageControls(html, (value) => setAttributes({ html: value })))),
			el('li', useBlockProps(),
				el('div', { className: 'text-box' }, el(RichText, {
					tagName: 'h3', value: attributes.value || '', placeholder: 'Текст слайда',
					onChange: (value) => setAttributes({ value }),
				})),
				html.src ? el('img', { ...elementProps(html), alt: html.alt || '', draggable: false })
					: el('div', { className: 'gourmeta-add-slide-image' }, mediaButton('Выбрать изображение', (image) => setAttributes({ html: { ...html, src: image.url, alt: image.alt || '' } })))
			)
		);
	}

	function Slideshow({ attributes, setAttributes, clientId }) {
		const children = useSelect((select) => select('core/block-editor').getBlocks(clientId), [clientId]);
		const selected = useSelect((select) => select('core/block-editor').getSelectedBlockClientId(), []);
		const [active, setActive] = useState(0);
		const selectedIndex = children.findIndex((block) => block.clientId === selected);
		const index = selectedIndex >= 0 ? selectedIndex : Math.min(active, Math.max(0, children.length - 1));
		const props = useBlockProps({ className: 'branding-wrapper gourmeta-edit-slider' });
		const inner = useInnerBlocksProps({ className: 'pushbox-slides', 'data-slide': index }, { allowedBlocks: ['gourmeta/slide'], renderAppender: false });
		return el(Fragment, {},
			el(InspectorControls, {}, el(PanelBody, { title: 'Слайдер' },
				el(TextControl, { label: 'Интервал в секундах', type: 'number', min: 1, max: 30, value: attributes.pause || 5, onChange: (pause) => setAttributes({ pause: Math.max(1, Math.min(30, Number(pause))) }) }),
				el(Button, { variant: 'secondary', onClick: () => wp.data.dispatch('core/block-editor').insertBlocks(wp.blocks.createBlock('gourmeta/slide'), children.length, clientId) }, 'Добавить слайд'))),
			el('div', props, el('div', { className: 'pushbox' },
				el('div', { className: 'pushbox-viewport' }, el('ul', inner)),
				el('div', { className: 'pushbox-nav' }, el('ul', {},
					children.map((block, i) => el('li', { key: block.clientId, className: index === i ? 'active' : '' },
						el('button', { type: 'button', 'aria-label': 'Слайд ' + (i + 1), onClick: () => {
							setActive(i);
							wp.data.dispatch('core/block-editor').selectBlock(block.clientId);
						} }))))),
				el('div', { className: 'pushbox-teasers-shadow' })
			))
		);
	}

	function Contact({ attributes, setAttributes }) {
		const id = useSelect(getPostId, []);
		const { phone: sitePhone } = usePreview(id, 'chrome');
		const phone = sitePhone?.formated || '';
		return el(Fragment, {},
			el(InspectorControls, {}, el(PanelBody, { title: 'Кнопка обратной связи' },
				el(TextControl, { label: 'Куда ведёт кнопка', value: attributes.href || '', onChange: (href) => setAttributes({ href }) }))),
			el('div', useBlockProps({ className: 'col-wrapper col-box call-to-action' }),
				el(RichText, { tagName: 'em', value: attributes.value || '', placeholder: 'Приглашение связаться', onChange: (value) => setAttributes({ value }) }),
				el('div', { className: 'call-button-holder' },
					el('a', { className: 'call-link' }, phone, el('span')),
					' ', el(RichText, { tagName: 'span', value: attributes.join || '', onChange: (join) => setAttributes({ join }), allowedFormats: [] }), ' ',
					el('a', { className: 'button button-yellow' }, el(RichText, { tagName: 'strong', className: 'gourmeta-edit-button-label', value: attributes.label || '', onChange: (label) => setAttributes({ label }), allowedFormats: [] }), el('span', {}, el('span')))
				)
			)
		);
	}

	function PreviewMarkup({ markup }) {
		return el('div', {
			className: 'gourmeta-static-preview',
			dangerouslySetInnerHTML: { __html: markup || '' },
			inert: '',
		});
	}

	function Component({ attributes, setAttributes }) {
		const id = useSelect(getPostId, []);
		const kind = attributes.kind || '';
		const state = usePreview(id, kind || 'unknown', attributes.shortcode || '');
		const form = kind === 'form';
		const link = form ? settings.formsUrl : ['cafitesse', 'espresso', 'compare', 'order'].includes(kind) ? settings.productsUrl : null;
		return el(Fragment, {},
			el(InspectorControls, {}, el(PanelBody, { title: 'Источник содержимого' },
				el(SelectControl, {
					label: 'Компонент', value: kind,
					options: [{ value: '', label: 'Выбери компонент' }].concat(Object.entries(componentTitles).map(([value, label]) => ({ value, label }))),
					onChange: (value) => setAttributes({ kind: value }),
				}),
				['form', 'sitemap', 'map'].includes(kind) && el(TextControl, { label: kind === 'map' ? 'Адрес конструктора карты' : 'Шорткод', value: attributes.shortcode || '', onChange: (shortcode) => setAttributes({ shortcode }) }),
				link && el(Button, { href: link, target: '_blank', rel: 'noopener noreferrer', variant: 'secondary' }, form ? 'Открыть настройки формы' : 'Открыть карточки оборудования'))),
			el('div', useBlockProps({ className: 'gourmeta-dynamic-preview' }),
				state.loading ? el(Spinner) : state.error ? el(Notice, { status: 'error', isDismissible: false }, state.error)
					: state.html ? el(PreviewMarkup, { markup: state.html }) : el('p', {}, componentTitles[kind] || 'Выбери компонент в настройках блока'))
		);
	}

	function Hero({ isSelected }) {
		const props = useBlockProps({ className: 'gourmeta-first-screen' });
		const inner = useInnerBlocksProps(props, { renderAppender: isSelected ? InnerBlocks.ButtonBlockAppender : false });
		return el('section', inner);
	}

	function HomeLayout({ isSelected }) {
		const props = useBlockProps({ className: 'gourmeta-home-layout' });
		const inner = useInnerBlocksProps(props, { renderAppender: isSelected ? InnerBlocks.ButtonBlockAppender : false });
		return el('main', inner);
	}

	const edits = { 'home-layout': HomeLayout, hero: Hero, section: Section, text: Text, image: ImageBlock, link: Section, title: Title, slideshow: Slideshow, slide: Slide, contact: Contact, component: Component };
	for (const [name, definition] of Object.entries(settings.blocks)) {
		const type = name.split('/')[1];
		wp.blocks.registerBlockType(name, {
			...definition,
			edit: (props) => el(edits[type], { ...props, name }),
			save: ['home-layout', 'hero', 'section', 'link', 'slideshow'].includes(type) ? () => el(InnerBlocks.Content) : () => null,
		});
	}

	function SharedSettings({ site, part, onClose, onSave }) {
		const [values, setValues] = useState(site);
		const [menuId, setMenuId] = useState(site.menus[0]?.id || 0);
		const [menus, setMenus] = useState({});
		const [busy, setBusy] = useState(false);
		const [error, setError] = useState('');
		const patch = (key, value) => setValues({ ...values, [key]: value });
		const media = (key, title) => el(Fragment, {},
			el(TextControl, { label: title, value: values[key] || '', onChange: (value) => patch(key, value) }),
			mediaButton('Выбрать из медиатеки', (image) => patch(key, image.url))
		);
		const originalMenu = site.menus.find((menu) => menu.id === menuId);
		const menuItems = menus[menuId] || originalMenu?.items || [];
		const updateMenu = (items) => setMenus({ ...menus, [menuId]: items });
		const menuField = (id, field, value) => updateMenu(menuItems.map((item) => item.id === id ? { ...item, [field]: value } : item));
		const move = (index, offset) => {
			const next = [...menuItems];
			[next[index], next[index + offset]] = [next[index + offset], next[index]];
			updateMenu(next);
		};
		const remove = (item) => updateMenu(menuItems.filter((entry) => entry.id !== item.id).map((entry) => entry.parent === item.id ? { ...entry, parent: item.parent } : entry));
		const add = () => updateMenu([...menuItems, { id: Math.min(0, ...menuItems.map((item) => item.id)) - 1, title: '', url: '', type: 'custom', parent: 0 }]);
		return el(Modal, {
			title: { header: 'Общая шапка', footer: 'Общий подвал', menu: 'Общие меню' }[part],
			onRequestClose: busy ? () => {} : onClose,
		},
			el('p', {}, 'Изменения применятся на всех страницах сайта.'),
			part === 'header' && el(Fragment, {}, media('homeLogo', 'Логотип Gourmeta'), media('partners', 'Логотип партнёра')),
			part === 'footer' && el(Fragment, {},
				el(TextControl, { label: 'Заголовок контактов', value: values.contactHeading, onChange: (value) => patch('contactHeading', value) }),
				el(TextControl, { label: 'Телефон для набора', value: values.phone?.clear || '', onChange: (value) => patch('phone', { ...values.phone, clear: value }) }),
				el(TextControl, { label: 'Телефон на странице', value: values.phone?.formated || '', onChange: (value) => patch('phone', { ...values.phone, formated: value }) }),
				el(TextControl, { label: 'Подпись в подвале', value: values.copyright, onChange: (value) => patch('copyright', value) }),
				el(TextControl, { label: 'Текст под логотипом', value: values.homeFooterSummary, onChange: (value) => patch('homeFooterSummary', value) }),
				el(TextControl, { label: 'Электронная почта', type: 'email', value: values.homeFooterEmail, onChange: (value) => patch('homeFooterEmail', value) }),
				el(TextControl, { label: 'Текст кнопки', value: values.homeFooterButton, onChange: (value) => patch('homeFooterButton', value) }),
				el(TextControl, { label: 'Ссылка кнопки', value: values.homeFooterHref, onChange: (value) => patch('homeFooterHref', value) }),
				el(TextControl, {
					label: 'Подсказка к кнопке «В начало»', value: values.homeBackToTopLabel,
					help: 'Очистите поле, чтобы скрыть кнопку.',
					onChange: (value) => patch('homeBackToTopLabel', value)
				})
			),
			part === 'menu' && el(Fragment, {},
				el(SelectControl, {
					label: 'Меню', value: menuId,
					options: site.menus.map((menu) => ({ value: menu.id, label: menu.name })),
					onChange: (value) => setMenuId(Number(value)),
				}),
				menuItems.map((item, index) => el('details', { key: item.id, open: item.id < 0 ? true : undefined, style: { marginBlockEnd: '8px', marginInlineStart: item.parent ? '20px' : '0' } },
					el('summary', {}, item.title || 'Новый пункт'),
					el(TextControl, { label: 'Название пункта', value: item.title, onChange: (value) => menuField(item.id, 'title', value) }),
					item.type === 'custom' && el(TextControl, { label: 'Ссылка', value: item.url, onChange: (value) => menuField(item.id, 'url', value) }),
					el(SelectControl, {
						label: 'Родительский пункт', value: item.parent,
						options: [{ value: 0, label: 'Верхний уровень' }].concat(menuItems.filter((entry) => entry.id !== item.id).map((entry) => ({ value: entry.id, label: entry.title || 'Новый пункт' }))),
						onChange: (value) => menuField(item.id, 'parent', Number(value)),
					}),
					el(Button, { disabled: index === 0, onClick: () => move(index, -1) }, 'Выше'),
					el(Button, { disabled: index === menuItems.length - 1, onClick: () => move(index, 1) }, 'Ниже'),
					el(Button, { isDestructive: true, onClick: () => remove(item) }, 'Удалить пункт')
				)),
				originalMenu && el(Button, { variant: 'secondary', onClick: add }, 'Добавить пункт')
			),
			error && el(Notice, { status: 'error', isDismissible: false }, error),
			el(Button, { variant: 'primary', isBusy: busy, disabled: busy, onClick: async () => {
				const keys = part === 'header' ? [settings.homeHero ? 'homeLogo' : 'logo', 'partners'] : part === 'footer' ? ['contactHeading', 'phone', 'copyright'] : [];
				if (part === 'footer' && settings.homeLayout) keys.push('homeFooterSummary', 'homeFooterEmail', 'homeFooterButton', 'homeFooterHref', 'homeBackToTopLabel');
				const data = Object.fromEntries(keys.map((key) => [key, values[key]]));
				const modifiedMenus = part === 'menu'
					? Object.entries(menus).map(([id, items]) => ({
						id: Number(id), items, previous: site.menus.find((menu) => menu.id === Number(id)).items.map((item) => item.id),
					}))
					: [];
				setBusy(true);
				setError('');
				try {
					if (modifiedMenus.length) {
						for (const menu of modifiedMenus) {
							await wp.apiFetch({ path: '/gourmeta/v1/site', method: 'POST', data: { menu } });
						}
					} else if (part !== 'menu') {
						await wp.apiFetch({ path: '/gourmeta/v1/site', method: 'POST', data });
					}
					onSave();
				} catch (failure) {
					setError(failure.message || 'Не удалось сохранить настройки.');
					setBusy(false);
				}
			} }, 'Сохранить для всего сайта')
		);
	}

	function ProductFields() {
		const [saved, setMeta] = wp.coreData.useEntityProp('postType', 'coffee-dispensers', 'meta');
		if (!saved) return null;
		const change = (key, value) => setMeta({ ...saved, [key]: value });
		return el(wp.editor.PluginDocumentSettingPanel, { name: 'product-specifications', title: 'Характеристики оборудования' },
			Object.entries(settings.productFields).map(([key, field]) => {
				const props = { key, label: field.label, value: saved[key] || '', onChange: (value) => change(key, value) };
				if (field.type === 'checkbox') {
					return el(CheckboxControl, { key, label: field.label, checked: Boolean(saved[key]), onChange: (checked) => change(key, checked ? 'on' : '') });
				}
				if (field.type === 'select') {
					const options = Object.entries(field.options).map(([value, label]) => ({ value, label: String(label) }));
					return el(SelectControl, { ...props, options: [{ value: '', label: '—' }, ...options] });
				}
				return el(TextControl, props);
			})
		);
	}

	function ProductIntro({ markup }) {
		const [container, setContainer] = useState(null);
		const { title, featured } = useSelect((select) => {
			const editor = select('core/editor');
			return {
				title: editor.getEditedPostAttribute('title'),
				featured: editor.getEditedPostAttribute('featured_media'),
			};
		}, []);
		const image = useSelect((select) => featured ? select('core').getMedia(featured) : null, [featured]);
		const update = (attributes) => wp.data.dispatch('core/editor').editPost(attributes);
		const heading = container?.querySelector('h1');
		const photo = container?.querySelector('.image-holder');
		useEffect(() => {
			if (heading) [...heading.childNodes].filter((node) => node.nodeType === 3).forEach((node) => node.remove());
			if (photo && (!featured || image)) photo.querySelector('img:not([data-editor-photo])')?.remove();
		}, [heading, photo, featured, image, markup]);
		return el(Fragment, {},
			el('div', { ref: setContainer, dangerouslySetInnerHTML: { __html: markup } }),
			heading && createPortal(el(RichText, {
				tagName: 'span',
				allowedFormats: [],
				value: String(title || '').replace(/&/g, '&amp;').replace(/</g, '&lt;'),
				placeholder: 'Название оборудования',
				'aria-label': 'Название оборудования',
				onChange: (value) => {
					const text = document.createElement('span');
					text.innerHTML = value;
					update({ title: text.textContent });
				},
			}), heading),
			photo && createPortal(el(Fragment, {},
				image && el('img', { 'data-editor-photo': '', src: image.source_url, alt: image.alt_text || '' }),
				mediaButton(image ? 'Заменить фото' : 'Выбрать фото', (media) => update({ featured_media: media.id }))
			), photo)
		);
	}

	function Chrome() {
		const id = useSelect(getPostId, []);
		const [mounts, setMounts] = useState(null);
		const [part, setPart] = useState(null);
		const [showSpecs, setShowSpecs] = useState(false);
		const savedProduct = useSelect((select) => settings.product ? select('core/editor').getCurrentPost()?.modified : null, []);
		const state = usePreview(id, 'chrome', savedProduct || '');
		const product = state.product?.intro ? state.product : null;
		useEffect(() => {
			if (!mounts) return;
			mounts.canvas.classList.toggle('gourmeta-product-editor', Boolean(product));
			mounts.canvas.classList.toggle('gourmeta-product-editor-big', settings.product && Array.isArray(state.product));
			mounts.canvas.classList.toggle('gourmeta-product-editor-specs', showSpecs);
		}, [mounts, product, state.product, showSpecs]);
		useEffect(() => {
			let canvas;
			let head;
			let foot;
			let details;
			function attach() {
				const frame = document.querySelector('iframe[name="editor-canvas"]');
				const doc = frame?.contentDocument || document;
				const wrapper = doc.querySelector('.editor-styles-wrapper');
				if (!wrapper || canvas === wrapper) return;
				head?.remove(); foot?.remove(); details?.remove();
				canvas = wrapper;
				const make = (className) => {
					const node = doc.createElement('div');
					node.className = className;
					return node;
				};
				head = make('gourmeta-editor-header');
				foot = make('gourmeta-editor-footer');
				details = make('gourmeta-editor-product-details');
				wrapper.prepend(head);
				wrapper.append(details, foot);
				wrapper.classList.toggle('gourmeta-visual-layout', settings.visual);
				wrapper.classList.toggle('gourmeta-editor-home', settings.home);
				wrapper.classList.add('gourmeta-site');
				wrapper.classList.toggle('gourmeta-hero-home', settings.homeHero);
				wrapper.classList.toggle('gourmeta-inner-page', !settings.homeHero);
				for (const url of settings.css) {
					if ((doc === document && !/\/visual\//.test(url)) || doc.querySelector('link[href="' + url + '"]')) continue;
					const link = doc.createElement('link');
					link.rel = 'stylesheet';
					link.href = url;
					doc.head.append(link);
				}
				setMounts({ head, foot, details, canvas: wrapper });
			}
			attach();
			const timer = window.setInterval(attach, 350);
			return () => { window.clearInterval(timer); head?.remove(); foot?.remove(); details?.remove(); };
		}, []);

		if (!mounts || !id) return null;
		const controls = (items) => state.settings && el('div', { className: 'gourmeta-chrome-actions' },
			items.map(([key, label]) => el(Button, { key, variant: 'secondary', size: 'compact', onClick: () => setPart(key) }, label)));
		return el(Fragment, {},
			createPortal(el(Fragment, {},
				el(PreviewMarkup, { markup: state.header }),
				controls([['header', 'Редактировать шапку'], ['menu', 'Редактировать меню']]),
				state.error && el(Notice, { status: 'error', isDismissible: false }, state.error),
				product && el(Fragment, {},
					el(ProductIntro, { markup: product.intro }),
					el('div', {
						className: 'gourmeta-product-description gourmeta-product-editor-tabs',
						onClick: (event) => {
							const tab = event.target.closest('a[href^="#"]');
							if (!tab) return;
							event.preventDefault();
							setShowSpecs(tab.hash === '#specifications');
						},
						dangerouslySetInnerHTML: { __html: product.tabs },
					})
				)
			), mounts.head),
			product && createPortal(el('div', { className: 'col-wrapper gourmeta-product-description' },
				showSpecs && el('div', { className: 'machine-properties-holder' },
					el(PreviewMarkup, { markup: product.specifications })),
				el(PreviewMarkup, { markup: product.actions }),
			), mounts.details),
			createPortal(el(Fragment, {},
				el(PreviewMarkup, { markup: state.footer }),
				controls([['footer', 'Редактировать подвал']])
			), mounts.foot),
			part && state.settings && el(SharedSettings, {
				part, site: state.settings,
				onClose: () => setPart(null),
				onSave: () => { setPart(null); document.dispatchEvent(new Event('gourmeta-site-updated')); },
			})
		);
	}

	wp.plugins.registerPlugin('gourmeta-visual-chrome', { render: Chrome });
	if (settings.product) wp.plugins.registerPlugin('gourmeta-product-fields', { render: ProductFields });
})(window.wp, window.gourmetaEditor);
