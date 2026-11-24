<!DOCTYPE html>
<!--[if IE 8]>    <html class="ie8 ie9" <?= language_attributes() ?>> <![endif]-->
<!--[if IE 9]>    <html class="ie9" <?= language_attributes() ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html <?= language_attributes() ?>> <!--<![endif]-->
	<head>
        <link rel="icon" href="/favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
        
		<meta charset="<?= bloginfo('charset') ?>" />
		<title>
			<?
				if (is_404()) echo langS('Ничего не найдено', 'Nothing found').' | ';
				else if (is_search()) echo the_search_query().' | '.langS('Результаты поиска', 'Search results').' |';
				else wp_title('|', true, 'right') ;
			?>
		</title>
		
        <?= wp_head() ?>
        
        <link href="<?= bloginfo('template_url') ?>/css/default.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/layout.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/components.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/animations.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/forms.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/pushbox.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/content.css" rel="stylesheet" />
        <link href="<?= bloginfo('template_url') ?>/css/print.css" rel="stylesheet" media="print"/>
        <link href="<?= bloginfo('template_url') ?>/js/shadowbox/shadowbox.css" rel="stylesheet" />
        <!--[if lte IE 9]><link href="<?= bloginfo('template_url') ?>/css/ie.css" rel="stylesheet" /><![endif]-->
        
        <link rel="stylesheet" type="text/css" media="all" href="<?php echo esc_url( add_query_arg( 'ver', filemtime( get_stylesheet_directory() . '/style.css' ), get_stylesheet_uri() ) ); ?>" />
		
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php foreach ( gourmeta_design_styles( ! ( is_front_page() && gourmeta_is_hero_home() ) ) as $stylesheet ) : ?>
            <link rel="stylesheet" href="<?php echo esc_url( $stylesheet ); ?>">
        <?php endforeach; ?>

	</head>
    <body <?php body_class(); ?>>

		
        <?php require get_template_directory() . "/visual/header.php"; ?>
