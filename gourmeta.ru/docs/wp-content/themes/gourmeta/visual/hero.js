'use strict';

document.querySelectorAll('.gourmeta-masthead').forEach((header) => {
	const toggle = header.querySelector('.gourmeta-masthead-toggle');
	const menu = header.querySelector('.gourmeta-masthead-nav');
	if (!toggle || !menu) return;

	function setOpen(open) {
		header.dataset.expanded = String(open);
		toggle.setAttribute('aria-expanded', String(open));
	}

	header.classList.add('gourmeta-masthead-enhanced');
	toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
	header.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
			setOpen(false);
			toggle.focus();
		}
	});
	document.addEventListener('pointerdown', (event) => {
		if (!header.contains(event.target) && toggle.getAttribute('aria-expanded') === 'true') setOpen(false);
	});
});

const motionPreference = window.matchMedia('(prefers-reduced-motion: reduce)');
const backToTop = document.querySelector('.gh-back-to-top');
if (backToTop) {
	const homeLink = document.querySelector('.gourmeta-masthead-logo');
	const updateVisibility = () => {
		const hide = window.scrollY <= 64;
		if (backToTop.hidden !== hide) backToTop.hidden = hide;
	};

	backToTop.addEventListener('click', () => {
		homeLink?.focus({ preventScroll: true });
		window.scrollTo({ top: 0, behavior: motionPreference.matches ? 'auto' : 'smooth' });
	});
	window.addEventListener('scroll', updateVisibility, { passive: true });
	window.addEventListener('pageshow', updateVisibility);
	updateVisibility();
}

const homeLayout = document.querySelector('.gourmeta-home-layout');
const photoLayout = homeLayout || document.querySelector('body.gourmeta-inner-page');
if (photoLayout && !motionPreference.matches && 'IntersectionObserver' in window && Element.prototype.animate) {
	const pendingClass = 'gh-photo-pending';
	const animations = new Map();
	const observer = new IntersectionObserver((entries) => {
		entries.forEach(async ({ target: frame, isIntersecting }) => {
			if (!isIntersecting || !frame.classList.contains(pendingClass)) return;

			observer.unobserve(frame);
			try {
				await Promise.all([...frame.querySelectorAll('img')].map((image) => {
					image.loading = 'eager';
					return image.decode();
				}));
			} catch {
				frame.classList.remove(pendingClass);
				return;
			}

			if (!frame.classList.contains(pendingClass)) return;
			frame.classList.remove(pendingClass);
			const bounds = frame.getBoundingClientRect();
			if (bounds.bottom <= 0 || bounds.top >= window.innerHeight) return;

			const viewportWidth = document.documentElement.clientWidth;
			const centerOffset = bounds.left + bounds.width / 2 - viewportWidth / 2;
			const fromLeft = Math.abs(centerOffset) < 12
				? frame.matches('.gh-support-image, .gh-card:nth-child(odd)')
				: centerOffset < 0;
			const start = fromLeft ? -Math.ceil(bounds.right) - 32 : Math.ceil(viewportWidth - bounds.left) + 32;

			const animation = frame.animate(
				[
					{ transform: `translateX(${start}px)`, opacity: .65 },
					{ transform: 'translateX(0)', opacity: 1 },
				],
				{ duration: 660, easing: 'cubic-bezier(.22, .72, .25, 1)' }
			);
			animations.set(frame, animation);
			animation.onfinish = animation.oncancel = () => animations.delete(frame);
		});
	});

	const frames = photoLayout.querySelectorAll(homeLayout
		? '.gourmeta-hero-art, .gh-card, .gh-support-image'
		: '.col-wrapper .row > .col-3of6:has(+ .col-2of6), .col-wrapper .row > .col-3of6 + .col-2of6');
	photoLayout.classList.add('gh-photos-animated');
	for (const frame of frames) {
		if (!frame.querySelector('img') || frame.getBoundingClientRect().top < window.innerHeight) continue;

		frame.classList.add(pendingClass);
		observer.observe(frame);
		frame.addEventListener('focusin', () => {
			observer.unobserve(frame);
			frame.classList.remove(pendingClass);
			animations.get(frame)?.cancel();
		}, { once: true });
	}

	motionPreference.addEventListener('change', ({ matches }) => {
		if (!matches) return;
		observer.disconnect();
		photoLayout.querySelectorAll('.gh-photo-pending').forEach((frame) => frame.classList.remove(pendingClass));
		animations.forEach((animation) => animation.cancel());
	});
}

document.querySelectorAll('a[data-gourmeta-lightbox]').forEach((trigger) => {
	if (typeof HTMLDialogElement === 'undefined' || !HTMLDialogElement.prototype.showModal) return;

	trigger.setAttribute('aria-haspopup', 'dialog');
	trigger.addEventListener('click', (event) => {
		if (event.defaultPrevented || event.button !== 0 || event.ctrlKey || event.metaKey || event.altKey || event.shiftKey) return;
		const thumbnail = trigger.querySelector('img');
		if (!thumbnail) return;

		event.preventDefault();
		const dialog = document.createElement('dialog');
		dialog.className = 'gourmeta-image-dialog';
		dialog.setAttribute('aria-label', thumbnail.alt || trigger.getAttribute('aria-label'));
		const close = document.createElement('button');
		close.type = 'button';
		close.className = 'gourmeta-image-dialog-close';
		close.setAttribute('aria-label', 'Закрыть изображение');
		close.autofocus = true;
		const image = new Image();
		image.alt = thumbnail.alt;
		image.src = trigger.href;
		const width = thumbnail.naturalWidth || thumbnail.width;
		const height = thumbnail.naturalHeight || thumbnail.height;
		if (width && height) image.style.setProperty('--gh-image-ratio', width / height);

		close.addEventListener('click', () => dialog.close());
		dialog.addEventListener('click', (event) => {
			if (event.target === dialog) dialog.close();
		});
		dialog.addEventListener('close', () => {
			dialog.remove();
			trigger.focus({ preventScroll: true });
		}, { once: true });
		dialog.append(close, image);
		document.body.append(dialog);
		dialog.showModal();
	});
});
