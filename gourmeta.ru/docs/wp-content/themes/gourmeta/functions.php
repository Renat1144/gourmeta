<?
	require_once 'includes/nav-menu-template.php';
	
	require_once 'includes/coffee-dispensers-post-type.php';
	require_once 'includes/posts-post-type.php';
	
	// обновлять пути
	$flush_rewrite_rules = false;
	
	// новые размеры изображений
	add_image_size( 'dispenser-preview', 108, 150 );
	
	// новые типы постов
	$gourmeta_coffee_dispensers = new CoffeeDispensersPostType($flush_rewrite_rules);
	new PostsPostType($flush_rewrite_rules);
	
	function rge_geo_setup()
	{
		// Определяем главное меню
		register_nav_menus(array(
			'top' => 'Верхнее меню',
			'primary' => 'Главное меню',
			//'footer' => 'Меню в подвале',
			'bottom' => 'Нижнее меню'
		));
		add_theme_support('post-thumbnails');
        add_post_type_support( 'page', 'excerpt' );
	}
	add_action('after_setup_theme', 'rge_geo_setup');
	
	function gourmeta_admin_menu()
	{
		require_once('includes/wp-admin-menu-classes.php');
		
		remove_admin_menu_section('edit-comments.php');
		
		rename_admin_menu_section('Записи', 'Публикации');
		rename_admin_menu_item('Публикации', 'Все записи', 'Все публикации');
		
		swap_admin_menu_sections('Публикации', 'Страницы');
		swap_admin_menu_sections('Кофе диспенсеры', 'Медиафайлы');
	}
	add_action('admin_menu', 'gourmeta_admin_menu');
	
	function gourmeta_customize_register($wp_customize)
	{
		$wp_customize->add_section(
            'phone_section',
            array(
                'title' => 'Телефон',
                'capability' => 'edit_theme_options',
                'description' => 'Чистый телефон - только "+" и цифры. Форматированный - как красивее :).'
            )
        );
        $wp_customize->add_section(
            'others_section',
            array(
                'title' => 'Прочее',
                'capability' => 'edit_theme_options',
                'description' => ''
            )
        );
        
        $wp_customize->add_setting('phone[clear]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'    => ''
        ));
        $wp_customize->add_control('phone[clear]', array(
            'label' => 'Чистый',
            'section' => 'phone_section',
            'type' => 'text'
        ));
        
        $wp_customize->add_setting('phone[formated]', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'    => ''
        ));
        $wp_customize->add_control('phone[formated]', array(
            'label' => 'Форматированный',
            'section' => 'phone_section',
            'type' => 'text'
        ));
        
        $wp_customize->add_setting('copyright', array(
            'capability' => 'edit_theme_options',
            'type'       => 'option',
            'default'    => ''
        ));
        $wp_customize->add_control('copyright', array(
            'label' => 'Копирайт',
            'section' => 'others_section',
            'type' => 'text'
        ));
	}
	add_action('customize_register', 'gourmeta_customize_register');
	
	function gourmeta_breadcrumbs($customTitle = null)
	{
		$crumbs = array();
		
		$url = '';
		$parts = explode('/', get_permalink());
		array_splice($parts, 0, 3);
		array_splice($parts, count($parts) - 2);
		foreach($parts as $part)
		{
			$url .= $part.'/';
			$page = get_page_by_path($url);
			if ( ! $page || 'publish' !== $page->post_status ) {
				continue;
			}
			$crumbs[] = array(
				'title' => $page->post_title,
				'url' => get_permalink($page->ID)
			);
		}
		
		echo '<ul class="breadcrumb">';
		if (!empty($crumbs))
		{
			foreach($crumbs as $crumb)
				echo '<li><a href="'.$crumb['url'].'">'.$crumb['title'].'</a></li>';
			
			echo '<li>';
			if ($customTitle)
				echo $customTitle;
			else
				echo get_the_title();
			echo '</li>';
		}
		echo '</ul>';
	}
	
	function rge_geo_the_tags($class=null)
	{
		$result = '';
		
		$terms = get_the_terms($post->ID, 'post_tag');
		if ($terms && !is_wp_error($terms))
			foreach ($terms as $term)
			{
				$result .= '<a class="tag'.(!empty($class) ? ' '.$class : '').'" href="/en/publications/?t='.urlencode($term->name).'">';
				$result .= '<div class="head"></div>';
				$result .= '<div class="body">'.$term->name.'</div>';
				$result .= '</a>';
			}
		
		echo $result;
	}
	
	function rge_geo_the_date($format)
	{
		if ($format == 'Y F')
		{
			$result = get_the_date('Y.n');
			$result = explode('.', $result);
			$result[1] = date('F',mktime(0,0,0,intval($result[1])));
			
			echo implode(' ', $result);
		}
		else
			the_date('Y F');
	}
	
	include_once 'includes/wp-lang.php';
	include_once 'includes/wp-clear.php';
?>
<?php require_once __DIR__ . '/visual/blocks.php'; ?>
