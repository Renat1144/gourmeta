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
        
        <link rel="stylesheet" type="text/css" media="all" href="<?= bloginfo('stylesheet_url') ?>" />
		
        <?php if ( is_page() && ( has_block( 'gourmeta/hero' ) || has_block( 'gourmeta/home-layout' ) ) ) : ?>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="<?php echo esc_url( add_query_arg( 'ver', filemtime( __DIR__ . '/visual/hero.css' ), get_template_directory_uri() . '/visual/hero.css' ) ); ?>">
        <?php endif; ?>
        <?php if ( is_page() && has_block( 'gourmeta/home-layout' ) ) : ?>
            <link rel="stylesheet" href="<?php echo esc_url( add_query_arg( 'ver', filemtime( __DIR__ . '/visual/home.css' ), get_template_directory_uri() . '/visual/home.css' ) ); ?>">
        <?php endif; ?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
		  
			ga('create', 'UA-88927931-1', 'auto');
			ga('send', 'pageview');
		</script>
	</head>
    <body <?php body_class(); ?>>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript">
			(function (d, w, c) {
				(w[c] = w[c] || []).push(function() {
					try {
						w.yaCounter41570309 = new Ya.Metrika({
							id:41570309,
							clickmap:true,
							trackLinks:true,
							accurateTrackBounce:true,
							webvisor:true
						});
					} catch(e) { }
				});
		
				var n = d.getElementsByTagName("script")[0],
					s = d.createElement("script"),
					f = function () { n.parentNode.insertBefore(s, n); };
				s.type = "text/javascript";
				s.async = true;
				s.src = "https://mc.yandex.ru/metrika/watch.js";
		
				if (w.opera == "[object Opera]") {
					d.addEventListener("DOMContentLoaded", f, false);
				} else { f(); }
			})(document, window, "yandex_metrika_callbacks");
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/41570309" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->

		
        <?php require get_template_directory() . "/visual/header.php"; ?>
