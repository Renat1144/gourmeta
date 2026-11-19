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

		
        <!-- header: logo, meta navigation and search -->
        <div class="header-wrapper">
            <div class="header-shadow"></div>
            <div class="header">
                <a href="<?= getHomeLink() ?>" title="<?= esc_attr(get_bloginfo('name', 'display')) ?>" rel="home" class="logo">
                    <img src="<?= bloginfo('template_directory') ?>/img/logo.png" alt="Gourmeta.ru - официальный сайт в России компании Jacobs Douwe Egberts." />
                </a>
                
                <?
                    wp_nav_menu(array(
                        'menu'            => getLangTopMenuName(), 
                        'container'       => '',
                        'container_class' => '',
                        'echo'            => true,
                        'items_wrap'      => '
                            <ul id="%1$s" class="nav nav-meta %2$s">
                                %3$s
                                <!--li>'.str_replace('%', '%%', getLangA()).'</li-->
                            </ul>
                        ',
                        'depth'           => 1
                    ));
                ?>
                
                <!--form method="get" action="<?= esc_url(home_url('/')) ?>">
                    <fieldset class="search">
						<input type="hidden" name="lang" value="<?= getLangID() ?>" />
                        <input type="text" name="s" placeholder="<?= langS('Поиск', 'Search') ?>..." />
                        <input type="submit" class="search-submit" value="<?= langS('Поиск', 'Search') ?>">
                    </fieldset>
                </form-->
				
				<img src="<?= bloginfo('template_directory') ?>/img/partners.png" style="position: absolute; right: 10px; top: 20px;" />
                                
                           

            </div>
        </div>
    
        <!-- main navigation with flyout, white overlay -->
        <div class="nav-main-wrapper">
            <div class="nav-main-overlay"></div>
            <div class="nav-main-holder">
                <?
                    wp_nav_menu(array(
                        'menu'            => getLangMainMenuName(), 
                        'container'       => '', 
                        'container_class' => '',
                        'echo'            => true,
                        'items_wrap'      => '<ul id="%1$s" class="nav nav-main %2$s">%3$s</ul>',
                        'depth'           => 3,
                        'walker'          => new Mainmenu_Walker_Nav_Menu()
                    ));
                ?>
            </div>
        </div>
    
        <!-- breadcrumb and styled addthis -->
        <div class="breadcrumb-wrapper">
            <div class="breadcrumb-container">
                
                <? gourmeta_breadcrumbs() ?>
                
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style">
                    <a class="print-btn" data-tiptext="<?= langS('Распечатать страницу', 'Print page') ?>"></a>
					    <a class="facebook" style="text-decoration:none;" data-tiptext="<?= langS('Facebook', 'Facebook') ?>" href="https://www.facebook.com/gourmeta.ru/"><img  style="width: 16px; border-radius: 7px;     padding-bottom: 1px;" src="http://gourmeta.ru/wp-content/uploads/2017/09/facebook-256.png"> </a>
                                <a  class="insta" data-tiptext="<?= langS('Instagram', 'Instagram') ?>" href="https://www.instagram.com/gourmeta.ru/?hl=ru"><img style="width: 16px; border-radius: 7px;     padding-bottom: 1px;" src="http://gourmeta.ru/wp-content/uploads/2017/09/app-icon2.png"> </a>
							
					<!--<a href="#" class="addthis_button_facebook" data-tiptext="<?= langS('Поделиться в Facebook', 'Share on Facebook') ?>"></a>
					<a href="#" class="addthis_button_instagram_follow" data-tiptext="<?= langS('Поделиться в Instagram', '') ?>"></a>
					<a class="addthis_button_twitter" data-tiptext="<?= langS('Поделиться в Twitter', 'Share on Twitter') ?>"></a>
                    
                    <a class="addthis_button_linkedin" data-tiptext="<?= langS('Поделиться в linkedIn', 'Share on linkedIn') ?>"></a>
                    <a class="addthis_button_email" data-tiptext="<?= langS('Отправить другу', 'Send a friend') ?>"></a>
                    <a class="addthis_button_compact" data-tiptext="<?= langS('Другие возможности поделиться', 'Other sharing options') ?>"></a> -->
                </div>
                <!-- AddThis Button END -->
            </div>
        </div>