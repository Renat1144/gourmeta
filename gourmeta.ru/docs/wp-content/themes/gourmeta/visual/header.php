<?php
require __DIR__ . '/hero-header.php';

if ( is_front_page() && gourmeta_is_hero_home() ) {
	return;
}

$is_about_page = is_page() && 'ru/about' === get_page_uri();
$page_content = is_page() ? get_post_field( 'post_content', get_queried_object_id(), 'raw' ) : '';
$social_links_in_page = str_contains( $page_content, 'gh-about-social' ) || str_contains( $page_content, 'gh-social-section' );
$show_social_buttons = ! get_option( 'gourmeta_hide_social_links' ) && ! $social_links_in_page;
?>
<div class="breadcrumb-wrapper<?php echo $is_about_page ? ' gh-about-tools' : ''; ?>">
	<div class="breadcrumb-container">
		<nav aria-label="<?php echo esc_attr( langS( 'Путь к странице', 'Breadcrumb' ) ); ?>">
			<?php gourmeta_breadcrumbs(); ?>
		</nav>
		<?php wp_nav_menu( [
			'menu' => getLangTopMenuName(),
			'container' => false,
			'menu_class' => 'gourmeta-utility-menu',
			'fallback_cb' => false,
			'depth' => 1,
		] ); ?>
		<?php if ( $is_about_page ) : ?>
			<button class="print-btn gh-about-print" type="button">
				<span class="gh-about-print-icon" aria-hidden="true"></span>
				<?php echo esc_html( langS( 'Распечатать страницу', 'Print page' ) ); ?>
			</button>
		<?php endif; ?>
		<?php if ( ! $is_about_page || $show_social_buttons ) : ?>
			<div class="addthis_toolbox addthis_default_style">
				<?php if ( ! $is_about_page ) : ?>
					<a class="print-btn" href="#" aria-label="<?php echo esc_attr( langS( 'Распечатать страницу', 'Print page' ) ); ?>"
						data-tiptext="<?php echo esc_attr( langS( 'Распечатать страницу', 'Print page' ) ); ?>"></a>
				<?php endif; ?>
				<?php if ( $show_social_buttons ) : ?>
					<a class="facebook" href="https://www.facebook.com/gourmeta.ru/" aria-label="Facebook" data-tiptext="Facebook">
						<img width="16" height="16" src="<?php echo esc_url( content_url( 'uploads/2017/09/facebook-256.png' ) ); ?>" alt="">
					</a>
					<a class="insta" href="https://www.instagram.com/gourmeta.ru/?hl=ru" aria-label="Instagram" data-tiptext="Instagram">
						<img width="16" height="16" src="<?php echo esc_url( content_url( 'uploads/2017/09/app-icon2.png' ) ); ?>" alt="">
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</div>
