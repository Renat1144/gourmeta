<?php
/**
 * Site privacy controls and evidence of consent in the existing form emails.
 */

function gourmeta_privacy_consent_page() {
	$page = get_page_by_path( 'personal-data-consent' );
	return $page && 'publish' === $page->post_status ? $page : null;
}

function gourmeta_privacy_consent_version() {
	static $version;
	if ( ! isset( $version ) ) {
		$page = gourmeta_privacy_consent_page();
		$version = $page ? hash( 'sha256', $page->post_title . "\n" . $page->post_content ) : '';
	}
	return $version;
}

add_filter( 'wpcf7_form_hidden_fields', static function ( $fields ) {
	$form = wpcf7_get_current_contact_form();
	if ( $form && $form->scan_form_tags( [ 'name' => 'gourmeta-data-consent' ] ) ) {
		$fields['gourmeta-consent-version'] = gourmeta_privacy_consent_version();
	}
	return $fields;
} );

add_filter( 'wpcf7_validate_acceptance', static function ( $result, $tag ) {
	if ( 'gourmeta-data-consent' !== $tag->name ) {
		return $result;
	}
	$submitted = wpcf7_superglobal_post( $tag->name );
	$version = gourmeta_privacy_consent_version();
	$posted_version = wpcf7_superglobal_post( 'gourmeta-consent-version' );
	if ( '1' !== $submitted ) {
		$result->invalidate( $tag, 'Отметьте согласие на обработку персональных данных.' );
	} elseif ( ! $version || ! is_string( $posted_version ) || ! hash_equals( $version, $posted_version ) ) {
		$result->invalidate( $tag, 'Обновите страницу, прочитайте действующее согласие и отметьте его заново.' );
	}
	return $result;
}, 9, 2 );

add_filter( 'wpcf7_special_mail_tags', static function ( $output, $name ) {
	if ( '_gourmeta_consent_receipt' !== $name ) {
		return $output;
	}
	$submission = WPCF7_Submission::get_instance();
	$version = gourmeta_privacy_consent_version();
	if ( ! $submission || ! $version || '1' !== wpcf7_superglobal_post( 'gourmeta-data-consent' ) ) {
		return $output;
	}
	return sprintf(
		"Согласие получено: %s UTC\nВерсия текста (SHA-256): %s",
		gmdate( 'Y-m-d H:i:s', (int) $submission->get_meta( 'timestamp' ) ),
		$version
	);
}, 10, 2 );

function gourmeta_privacy_footer_links() {
	$policy = get_privacy_policy_url();
	$consent = gourmeta_privacy_consent_page();
	?>
	<nav class="gh-privacy-links" aria-label="Персональные данные и cookie">
		<p class="gh-footer-label">Документы и cookie</p>
		<?php if ( $policy ) : ?>
			<a href="<?php echo esc_url( $policy ); ?>">Политика конфиденциальности</a>
		<?php endif; ?>
		<?php if ( $consent ) : ?>
			<a href="<?php echo esc_url( get_permalink( $consent ) ); ?>">Согласие на обработку данных</a>
		<?php endif; ?>
		<a href="<?php echo esc_url( $policy . '#cookie-settings' ); ?>" data-gh-cookie-settings>Настройки cookie</a>
	</nav>
	<?php
}

function gourmeta_privacy_cookie_controls() {
	$policy = get_privacy_policy_url();
	?>
	<aside class="gh-cookie-panel" data-gh-cookie-panel aria-labelledby="gh-cookie-heading" hidden>
		<div class="gh-cookie-copy">
			<h2 id="gh-cookie-heading" tabindex="-1">Настройки cookie</h2>
			<p>Необходимые cookie сохраняют ваш выбор. Чтобы показать карту проезда, сайт может подключить Яндекс Карты.</p>
			<?php if ( $policy ) : ?>
				<a href="<?php echo esc_url( $policy . '#cookie' ); ?>">Подробнее в политике конфиденциальности</a>
			<?php endif; ?>
		</div>
		<div class="gh-cookie-actions">
			<button type="button" data-gh-cookie-choice="necessary">Только необходимые</button>
			<button type="button" data-gh-cookie-choice="maps">Разрешить карту</button>
		</div>
	</aside>
	<?php
}

function gourmeta_privacy_map( $constructor_url ) {
	$url = wp_parse_url( $constructor_url );
	if ( ( $url['scheme'] ?? '' ) !== 'https' || ( $url['host'] ?? '' ) !== 'api-maps.yandex.ru' ||
		( $url['path'] ?? '' ) !== '/services/constructor/1.0/js/' ) {
		return '';
	}

	parse_str( $url['query'] ?? '', $params );
	$constructor = $params['um'] ?? '';
	if ( ! is_string( $constructor ) || ! preg_match( '/^constructor:[a-z0-9_-]+$/iD', $constructor ) ) {
		return '';
	}
	$width = min( 1600, max( 100, absint( $params['width'] ?? 600 ) ) );
	$height = min( 1600, max( 100, absint( $params['height'] ?? 400 ) ) );
	$map_url = add_query_arg( [ 'um' => $constructor, 'source' => 'constructor' ], 'https://yandex.ru/map-widget/v1/' );
	ob_start();
	?>
	<div class="gh-privacy-map" data-gh-map style="--gh-map-width: <?php echo (int) $width; ?>px; --gh-map-height: <?php echo (int) $height; ?>px">
		<div class="gh-map-placeholder" data-gh-map-placeholder>
			<p>Для показа карты проезда подключается сервис Яндекс Карты.</p>
			<button type="button" data-gh-map-allow>Разрешить и показать карту</button>
			<noscript><a href="<?php echo esc_url( $map_url ); ?>">Открыть карту проезда</a></noscript>
		</div>
		<template data-gh-map-template>
			<iframe title="Карта проезда" src="<?php echo esc_url( $map_url ); ?>"
				width="<?php echo (int) $width; ?>" height="<?php echo (int) $height; ?>"
				loading="lazy" referrerpolicy="no-referrer"></iframe>
		</template>
	</div>
	<?php
	return ob_get_clean();
}
