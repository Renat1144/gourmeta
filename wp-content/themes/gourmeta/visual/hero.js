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
if (homeLayout && !motionPreference.matches && 'IntersectionObserver' in window && Element.prototype.animate) {
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

	homeLayout.classList.add('gh-photos-animated');
	for (const frame of homeLayout.querySelectorAll('.gourmeta-hero-art, .gh-card, .gh-support-image')) {
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
		homeLayout.querySelectorAll('.gh-photo-pending').forEach((frame) => frame.classList.remove(pendingClass));
		animations.forEach((animation) => animation.cancel());
	});
}
