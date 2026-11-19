<?
    // Вычищаем лишнее от WP
	// remove version info from head and feeds
	function complete_version_removal()
	{
		return '';
	}
	add_filter('the_generator', 'complete_version_removal');
	
	// remove junk from head
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'feed_links', 2);
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'feed_links_extra', 3);
	remove_action('wp_head', 'start_post_rel_link', 10, 0);
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
	
	function fb_disable_feed() {
		wp_die( __('No feed available,please visit our <a href="'. get_bloginfo('url') .'">homepage</a>!') );
	}
	
	add_action('do_feed', 'fb_disable_feed', 1);
	add_action('do_feed_rdf', 'fb_disable_feed', 1);
	add_action('do_feed_rss', 'fb_disable_feed', 1);
	add_action('do_feed_rss2', 'fb_disable_feed', 1);
	add_action('do_feed_atom', 'fb_disable_feed', 1);
?>