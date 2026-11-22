<?php
if ( gourmeta_is_hero_home() ) {
	require __DIR__ . '/hero-header.php';
	return;
}
?>
        <!-- header: logo, meta navigation and search -->
        <div class="header-wrapper">
            <div class="header-shadow"></div>
            <div class="header">
                <a href="<?= getHomeLink() ?>" title="<?= esc_attr(get_bloginfo('name', 'display')) ?>" rel="home" class="logo">
                    <img src="<?= esc_url( gourmeta_visual_site_settings()['logo'] ) ?>" alt="Gourmeta.ru - официальный сайт в России компании Jacobs Douwe Egberts." />
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

				<img src="<?= esc_url( gourmeta_visual_site_settings()['partners'] ) ?>" style="position: absolute; right: 10px; top: 20px;" />



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