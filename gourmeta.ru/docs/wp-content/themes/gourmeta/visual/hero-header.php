<?php
$brand = gourmeta_visual_site_settings();
?>
<header class="gourmeta-masthead">
	<div class="gourmeta-masthead-inner">
		<a class="gourmeta-masthead-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
			<img src="<?php echo esc_url( $brand['homeLogo'] ?: $brand['logo'] ); ?>" alt="Gourmeta Beverage Systems" width="190" height="40">
		</a>
		<button class="gourmeta-masthead-toggle" type="button" aria-expanded="false" aria-controls="gourmeta-primary-navigation">
			<span aria-hidden="true"></span> Меню
		</button>
		<nav class="gourmeta-masthead-nav" id="gourmeta-primary-navigation" aria-label="Основное меню">
			<?php
			wp_nav_menu( [
				'menu' => getLangMainMenuName(),
				'container' => false,
				'menu_class' => 'gourmeta-masthead-menu',
				'menu_id' => 'gourmeta-home-menu',
				'fallback_cb' => false,
				'depth' => 3,
			] );
			?>
		</nav>
		<?php if ( $brand['partners'] ) : ?>
			<img class="gourmeta-masthead-partner" src="<?php echo esc_url( $brand['partners'] ); ?>" alt="Партнёр JDE Professional">
		<?php endif; ?>
	</div>
</header>
