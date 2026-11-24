(() => {
	const panel = document.querySelector('[data-gh-cookie-panel]');
	if (!panel) return;

	const cookieName = 'gourmeta_cookie_choice_v1';
	const homeLink = document.querySelector('.gh-footer-logo');
	const cookiePath = homeLink ? new URL(homeLink.href).pathname : '/';
	const choices = ['necessary', 'maps'];
	const maps = [...document.querySelectorAll('[data-gh-map]')];
	let choice = readChoice();
	let opener;

	function readChoice() {
		const saved = document.cookie.split('; ').find((entry) => entry.startsWith(cookieName + '='));
		return saved?.slice(cookieName.length + 1);
	}

	function reflectChoice() {
		for (const button of panel.querySelectorAll('[data-gh-cookie-choice]')) {
			button.setAttribute('aria-pressed', String(button.dataset.ghCookieChoice === choice));
		}
	}

	function showMaps() {
		for (const map of maps) {
			const placeholder = map.querySelector('[data-gh-map-placeholder]');
			const iframe = map.querySelector('iframe');
			placeholder.hidden = choice === 'maps';
			if (choice === 'maps' && !iframe) {
				map.append(map.querySelector('template').content.cloneNode(true));
			} else if (choice !== 'maps' && iframe) {
				iframe.remove();
			}
		}
	}

	function closePanel() {
		panel.hidden = true;
		opener?.focus();
		opener = undefined;
	}

	function openPanel(link) {
		opener = link;
		reflectChoice();
		panel.hidden = false;
		panel.querySelector('h2').focus();
	}

	function saveChoice(value) {
		if (!choices.includes(value)) return;
		choice = value;
		const secure = location.protocol === 'https:' ? '; Secure' : '';
		document.cookie = cookieName + '=' + choice + '; Max-Age=15552000; Path=' + cookiePath + '; SameSite=Lax' + secure;
		showMaps();
		closePanel();
	}

	document.addEventListener('click', (event) => {
		const settings = event.target.closest('[data-gh-cookie-settings]');
		const button = event.target.closest('[data-gh-cookie-choice]');
		const allowMap = event.target.closest('[data-gh-map-allow]');
		if (settings) {
			event.preventDefault();
			openPanel(settings);
		} else if (button) {
			saveChoice(button.dataset.ghCookieChoice);
		} else if (allowMap) {
			saveChoice('maps');
			allowMap.closest('[data-gh-map]').querySelector('iframe')?.focus();
		}
	});

	panel.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && opener) closePanel();
	});
	window.addEventListener('hashchange', () => {
		if (location.hash === '#cookie-settings') openPanel();
	});

	function refreshChoice() {
		const saved = readChoice();
		if (saved === choice) return;
		choice = saved;
		showMaps();
		reflectChoice();
		if (!opener) panel.hidden = choices.includes(choice);
	}

	window.addEventListener('pageshow', refreshChoice);
	document.addEventListener('visibilitychange', () => {
		if (document.visibilityState === 'visible') refreshChoice();
	});

	showMaps();
	reflectChoice();
	panel.hidden = choices.includes(choice);
	if (location.hash === '#cookie-settings') openPanel();
})();
