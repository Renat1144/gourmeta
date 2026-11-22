<?php
$brand = gourmeta_visual_site_settings();
$phone = (array) get_option( 'phone' );
$contact_url = home_url( '/ru/contacts/' );
$logo = $brand['homeLogo'] ?: $brand['logo'];

$footer_group_links = static function ( $attributes, $item, $args ) {
	if ( ( $args->menu_id ?? '' ) !== 'gourmeta-footer-navigation' || ( $attributes['href'] ?? '' ) !== '#' ) {
		return $attributes;
	}

	$paths = [
		'оборудование' => 'ru/equipment',
		'продукты' => 'ru/kofe',
	];
	$path = $paths[ mb_strtolower( trim( $item->title ) ) ] ?? '';
	$page = $path ? get_page_by_path( $path ) : null;
	if ( $page && 'publish' === $page->post_status ) {
		$attributes['href'] = get_permalink( $page );
	}

	return $attributes;
};
?>
<footer class="gh-footer">
	<div class="gh-shell">
		<div class="gh-footer-main">
			<div class="gh-footer-brand">
				<a class="gh-footer-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<img src="<?php echo esc_url( $logo ); ?>" alt="Gourmeta Beverage Systems" width="210" height="44">
				</a>
				<?php if ( $brand['homeFooterSummary'] ) : ?>
					<p><?php echo esc_html( $brand['homeFooterSummary'] ); ?></p>
				<?php endif; ?>
			</div>
			<nav class="gh-footer-nav" aria-label="Разделы сайта">
				<p class="gh-footer-label">Разделы сайта</p>
				<?php
				add_filter( 'nav_menu_link_attributes', $footer_group_links, 10, 3 );
				try {
					wp_nav_menu( [
						'menu' => getLangMainMenuName(),
						'container' => false,
						'menu_class' => 'gh-footer-menu',
						'menu_id' => 'gourmeta-footer-navigation',
						'fallback_cb' => false,
						'depth' => 1,
					] );
				} finally {
					remove_filter( 'nav_menu_link_attributes', $footer_group_links, 10 );
				}
				?>
			</nav>
			<div class="gh-footer-contact">
				<a class="gh-footer-label" href="<?php echo esc_url( $contact_url ); ?>"><?php echo esc_html( $brand['contactHeading'] ); ?></a>
				<?php if ( ! empty( $phone['clear'] ) && ! empty( $phone['formated'] ) ) : ?>
					<a class="gh-footer-phone" href="<?php echo esc_url( 'tel:' . $phone['clear'] ); ?>"><?php echo esc_html( $phone['formated'] ); ?></a>
				<?php endif; ?>
				<?php if ( $brand['homeFooterEmail'] ) : ?>
					<a class="gh-footer-email" href="<?php echo esc_url( 'mailto:' . $brand['homeFooterEmail'] ); ?>"><?php echo esc_html( $brand['homeFooterEmail'] ); ?></a>
				<?php endif; ?>
				<?php if ( $brand['homeFooterButton'] && $brand['homeFooterHref'] ) : ?>
					<a class="gh-action gh-action-amber" href="<?php echo esc_url( $brand['homeFooterHref'] ); ?>"><?php echo esc_html( $brand['homeFooterButton'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="gh-footer-bottom">
			<p><?php echo wp_kses_post( (string) get_option( 'copyright' ) ); ?></p>
			<nav aria-label="Дополнительные ссылки">
				<?php
				wp_nav_menu( [
					'menu' => getLangBottomMenuName(),
					'container' => false,
					'menu_class' => 'gh-footer-meta',
					'menu_id' => 'gourmeta-footer-meta',
					'fallback_cb' => false,
					'depth' => 1,
				] );
				?>
			</nav>
		</div>
	</div>
</footer>
<?php if ( '' !== $brand['homeBackToTopLabel'] ) : ?>
	<button type="button" class="gh-back-to-top"
		aria-label="<?php echo esc_attr( $brand['homeBackToTopLabel'] ); ?>"
		title="<?php echo esc_attr( $brand['homeBackToTopLabel'] ); ?>"
		<?php if ( empty( $gourmeta_editor_preview ) ) : ?>hidden<?php endif; ?>>
		<span aria-hidden="true"></span>
	</button>
<?php endif; ?>
