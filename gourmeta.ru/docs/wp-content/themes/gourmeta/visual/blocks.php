<?php
/**
 * Shared page components and the Gutenberg interface for the Gourmeta theme.
 */

const GOURMETA_VISUAL_BLOCKS = [
	'hero' => [ 'Главный экран Gourmeta', 'cover-image', [] ],
	'home-layout' => [ 'Главная Gourmeta', 'admin-home', [] ],
	'section' => [ 'Секция', 'layout', [ 'tag' => 'string', 'html' => 'object' ] ],
	'text' => [ 'Текст Gourmeta', 'editor-paragraph', [ 'tag' => 'string', 'html' => 'object', 'value' => 'string' ] ],
	'image' => [ 'Изображение Gourmeta', 'format-image', [ 'html' => 'object' ] ],
	'link' => [ 'Ссылка Gourmeta', 'admin-links', [ 'html' => 'object' ] ],
	'title' => [ 'Заголовок страницы', 'heading', [] ],
	'slideshow' => [ 'Слайдер Gourmeta', 'images-alt2', [ 'pause' => 'number' ] ],
	'slide' => [ 'Слайд Gourmeta', 'format-image', [ 'value' => 'string', 'html' => 'object' ] ],
	'contact' => [ 'Связаться с нами', 'phone', [ 'value' => 'string', 'label' => 'string', 'href' => 'string', 'join' => 'string' ] ],
	'component' => [ 'Компонент Gourmeta', 'screenoptions', [ 'kind' => 'string', 'shortcode' => 'string' ] ],
];

function gourmeta_visual_definitions() {
	$definitions = [];
	foreach ( GOURMETA_VISUAL_BLOCKS as $name => [ $title, $icon, $types ] ) {
		$attributes = [];
		foreach ( $types as $key => $type ) {
			$attributes[$key] = [ 'type' => $type ];
		}
		$definitions["gourmeta/$name"] = [
			'api_version' => 3,
			'title' => $title,
			'icon' => $icon,
			'category' => 'gourmeta',
			'attributes' => $attributes,
			'supports' => [ 'className' => false, 'customClassName' => false, 'html' => false ],
			'uses_context' => [ 'postId' ],
		];
	}
	$definitions['gourmeta/slide']['parent'] = [ 'gourmeta/slideshow' ];
	return $definitions;
}

add_action( 'init', function () {
	foreach ( gourmeta_visual_definitions() as $name => $settings ) {
		$settings['render_callback'] = static function ( $attributes, $content, $block ) use ( $name ) {
			return gourmeta_render_block( substr( $name, 9 ), $attributes, $content, $block );
		};
		register_block_type( $name, $settings );
	}
	register_post_meta( 'page', '_gourmeta_visual_layout', [ 'type' => 'boolean', 'single' => true ] );
} );

add_filter( 'block_categories_all', static function ( $categories ) {
	$categories[] = [ 'slug' => 'gourmeta', 'title' => 'Gourmeta' ];
	return $categories;
} );

function gourmeta_is_designed_home( $post = null ) {
	$post = get_post( $post );
	return $post && (int) $post->ID === (int) get_option( 'page_on_front' ) && has_block( 'gourmeta/home-layout', $post );
}

function gourmeta_is_hero_home( $post = null ) {
	$post = get_post( $post );
	return $post && (int) $post->ID === (int) get_option( 'page_on_front' ) &&
		( has_block( 'gourmeta/hero', $post ) || has_block( 'gourmeta/home-layout', $post ) );
}

add_filter( 'body_class', static function ( $classes ) {
	if ( is_front_page() && gourmeta_is_hero_home() ) {
		$classes[] = 'gourmeta-hero-home';
	}
	return $classes;
} );

add_action( 'wp_enqueue_scripts', static function () {
	if ( is_front_page() && gourmeta_is_hero_home() ) {
		wp_enqueue_script( 'gourmeta-hero-navigation', get_template_directory_uri() . '/visual/hero.js',
			[], filemtime( __DIR__ . '/hero.js' ), true );
	}
} );

add_filter( 'template_include', static function ( $template ) {
	if ( is_page() && get_post_meta( get_queried_object_id(), '_gourmeta_visual_layout', true ) && ! isset( $_GET['demo'] ) ) {
		return __DIR__ . '/page.php';
	}
	return $template;
} );

add_filter( 'use_block_editor_for_post', static function ( $use, $post ) {
	return 'page' === $post->post_type ? true : $use;
}, 100, 2 );

add_action( 'enqueue_block_editor_assets', static function () {
	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	$post = isset( $_GET['post'] ) ? get_post( absint( $_GET['post'] ) ) : null;
	$uri = get_template_directory_uri();
	wp_enqueue_script( 'gourmeta-visual-editor', $uri . '/visual/editor.js',
		[ 'wp-api-fetch', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-core-data',
			'wp-data', 'wp-element', 'wp-plugins', 'wp-url' ],
		filemtime( __DIR__ . '/editor.js' ), true
	);

	$definitions = [];
	foreach ( gourmeta_visual_definitions() as $name => $definition ) {
		$definition['apiVersion'] = $definition['api_version'];
		$definition['usesContext'] = $definition['uses_context'];
		$definitions[$name] = $definition;
	}
	wp_add_inline_script( 'gourmeta-visual-editor', 'window.gourmetaEditor = ' . wp_json_encode( [
		'blocks' => $definitions,
		'visual' => $post && (bool) get_post_meta( $post->ID, '_gourmeta_visual_layout', true ),
		'home' => $post && ( 'page-templates/main-page.php' === get_page_template_slug( $post ) ),
		'homeHero' => $post && gourmeta_is_hero_home( $post ),
		'homeLayout' => $post && gourmeta_is_designed_home( $post ),
		'siteUrl' => home_url( '/' ),
		'productsUrl' => admin_url( 'edit.php?post_type=coffee-dispensers' ),
		'formsUrl' => admin_url( 'admin.php?page=wpcf7' ),
		'css' => array_merge(
			array_map( static function ( $file ) use ( $uri ) {
				return add_query_arg( 'ver', filemtime( dirname( __DIR__ ) . '/' . $file ), $uri . '/' . $file );
			}, [
				'css/default.css', 'css/layout.css', 'css/components.css', 'css/animations.css',
				'css/forms.css', 'css/pushbox.css', 'css/content.css', 'style.css', 'visual/editor.css', 'visual/hero.css', 'visual/home.css',
			] ),
			[ plugins_url( 'contact-form-7/includes/css/styles.css' ), plugins_url( 'sitemap/css/page-list.css' ) ]
		),
	] ) . ';', 'before' );
} );

function gourmeta_visual_tags() {
	return [ 'div', 'section', 'article', 'aside', 'figure', 'figcaption', 'address', 'span', 'em',
		'strong', 'b', 'i', 'small', 'mark', 'sub', 'sup', 'caption', 'h1', 'h2', 'h3', 'h4', 'h5',
		'h6', 'p', 'ol', 'ul', 'li', 'dl', 'dt', 'dd', 'table', 'thead', 'tbody', 'tfoot', 'tr',
		'td', 'th', 'colgroup', 'col', 'blockquote', 'pre', 'a', 'img', 'hr', 'br' ];
}

function gourmeta_visual_attributes( $tag, $attributes ) {
	$result = '';
	$allowed = wp_kses_allowed_html( 'post' )[$tag] ?? [];
	foreach ( $attributes as $key => $value ) {
		if ( ! is_scalar( $value ) || ! preg_match( '/^[a-z][a-z0-9-]*$/D', $key ) ) {
			continue;
		}
		if ( ! isset( $allowed[$key] ) && ! ( 'img' === $tag && in_array( $key, [ 'decoding', 'fetchpriority' ], true ) ) && ! preg_match( '/^(aria|data)-[a-z0-9-]+$/D', $key ) ) {
			continue;
		}
		$value = (string) $value;
		switch ( $key ) {
			case 'href':
			case 'src':
				$encoded = ( 'src' === $key && 'img' === $tag && gourmeta_visual_data_image( $value ) )
					? esc_attr( $value ) : esc_url( $value );
				break;
			case 'style':
				$encoded = esc_attr( safecss_filter_attr( $value ) );
				break;
			default:
				$encoded = esc_attr( $value );
		}
		$result .= ' ' . $key . '="' . $encoded . '"';
	}
	return $result;
}

function gourmeta_visual_data_image( $source ) {
	return 1 === preg_match( '~^data:image/(?:jpeg|png|gif|webp|tiff);base64,[a-zA-Z0-9+/=\r\n]+$~D', $source );
}

function gourmeta_render_block( $name, $attributes, $content, $block ) {
	$html = $attributes['html'] ?? [];
	$value = $attributes['value'] ?? '';
	switch ( $name ) {
		case 'hero':
			return '<section class="gourmeta-first-screen" aria-label="Кофейные решения Gourmeta">' . $content . '</section>';
		case 'home-layout':
			return '<main class="gourmeta-home-layout" id="gourmeta-home-content">' . $content . '</main>';
		case 'section':
		case 'text':
		case 'link':
		case 'image':
			$tag = [ 'link' => 'a', 'image' => 'img' ][$name] ?? ( $attributes['tag'] ?? ( 'text' === $name ? 'p' : 'div' ) );
			if ( ! in_array( $tag, gourmeta_visual_tags(), true ) ) {
				$tag = 'div';
			}
			$opening = '<' . $tag . gourmeta_visual_attributes( $tag, $html ) . '>';
			if ( in_array( $tag, [ 'img', 'hr', 'br', 'col' ], true ) ) {
				return $opening;
			}
			return $opening . ( 'text' === $name ? wp_kses_post( $value ) : $content ) . '</' . $tag . '>';
		case 'title':
			return '<h1>' . esc_html( get_the_title( $block->context['postId'] ?? get_the_ID() ) ) . '</h1>';
		case 'slideshow':
			$count = count( $block->inner_blocks );
			if ( ! $count ) {
				return '';
			}
			$dots = '';
			for ( $number = 1; $number <= $count; $number++ ) {
				$dots .= '<li>' . $number . '</li>';
			}
			return '<div class="branding-wrapper"><div class="pushbox" data-decs-pushbox-pause="' .
				max( 1, min( 30, absint( $attributes['pause'] ?? 5 ) ) ) .
				'"><div class="pushbox-viewport"><ul class="pushbox-slides">' . $content .
				'</ul></div><div class="pushbox-nav"><ul>' . $dots . '</ul></div><div class="pushbox-teasers-shadow"></div></div></div>';
		case 'slide':
			return '<li><div class="text-box"><h3>' . wp_kses_post( $value ) . '</h3></div><img' .
				gourmeta_visual_attributes( 'img', $html ) . '></li>';
		case 'contact':
			$phone = (array) get_option( 'phone' );
			return '<div class="col-wrapper col-box call-to-action"><em>' . wp_kses_post( $value ) .
				'</em><div class="call-button-holder"><a class="call-link" href="' .
				esc_url( 'tel:' . ( $phone['clear'] ?? '' ) ) . '">' . esc_html( $phone['formated'] ?? '' ) .
				'<span></span></a> <span>' . esc_html( $attributes['join'] ?? '' ) .
				'</span> <a class="button button-yellow" href="' . esc_url( $attributes['href'] ?? '' ) .
				'">' . esc_html( $attributes['label'] ?? '' ) . ' <span><span></span></span></a></div></div>';
		case 'component':
			return gourmeta_visual_component( $attributes['kind'] ?? '', $attributes['shortcode'] ?? '' );
	}
	return $content;
}

function gourmeta_visual_component( $kind, $shortcode = '', $gourmeta_editor_preview = false ) {
	if ( 'map' === $kind ) {
		$url = wp_parse_url( $shortcode );
		if ( ( $url['scheme'] ?? '' ) !== 'https' || ( $url['host'] ?? '' ) !== 'api-maps.yandex.ru' ||
			( $url['path'] ?? '' ) !== '/services/constructor/1.0/js/' ) {
			return '';
		}
		if ( $gourmeta_editor_preview ) {
			parse_str( $url['query'] ?? '', $parameters );
			$width = min( 1600, max( 100, absint( $parameters['width'] ?? 600 ) ) );
			$height = min( 1600, max( 100, absint( $parameters['height'] ?? 400 ) ) );
			$map_url = 'https://yandex.ru/map-widget/v1/?' . ( $url['query'] ?? '' );
			return '<iframe title="Карта проезда" src="' . esc_url( $map_url ) . '" width="' . $width . '" height="' . $height . '" loading="lazy"></iframe>';
		}
		return '<script charset="utf-8" async src="' . esc_url( $shortcode ) . '"></script>';
	}

	if ( in_array( $kind, [ 'form', 'sitemap' ], true ) ) {
		$tag = 'form' === $kind ? 'contact-form-7' : 'pagelist';
		return preg_match( '/^\[' . $tag . '(?:\s[^\[\]]*)?\]$/D', trim( $shortcode ) )
			? do_shortcode( $shortcode ) : '';
	}

	if ( ! in_array( $kind, [ 'header', 'footer', 'cafitesse', 'espresso', 'compare', 'order' ], true ) ) {
		return '';
	}

	ob_start();
	global $post;
	$page = $post;
	require __DIR__ . '/' . $kind . '.php';
	$markup = ob_get_clean();
	$post = $page;
	if ( $post instanceof WP_Post ) {
		setup_postdata( $post );
	}
	if ( ! $gourmeta_editor_preview && in_array( $kind, [ 'order', 'compare' ], true ) ) {
		add_action( 'wp_footer', 'gourmeta_visual_' . $kind . '_script', 90 );
	}
	return $markup;
}

function gourmeta_visual_order_script() {
	require __DIR__ . '/order-script.php';
}

function gourmeta_visual_compare_script() {
	require __DIR__ . '/compare-script.php';
}

function gourmeta_visual_site_settings() {
	$defaults = [
		'logo' => get_template_directory_uri() . '/img/logo.png',
		'homeLogo' => '',
		'partners' => get_template_directory_uri() . '/img/partners.png',
		'contactHeading' => 'Свяжитесь с нами',
		'homeFooterSummary' => '',
		'homeFooterEmail' => '',
		'homeFooterButton' => '',
		'homeFooterHref' => '',
		'homeBackToTopLabel' => 'В начало',
	];
	return wp_parse_args( (array) get_option( 'gourmeta_visual_site', [] ), $defaults );
}

function gourmeta_visual_menu_items() {
	$menus = [];
	foreach ( [ getLangTopMenuName(), getLangMainMenuName(), getLangBottomMenuName() ] as $name ) {
		$menu = wp_get_nav_menu_object( $name );
		if ( ! $menu ) {
			continue;
		}
		$items = [];
		foreach ( wp_get_nav_menu_items( $menu->term_id ) ?: [] as $item ) {
			$items[] = [
				'id' => (int) $item->ID, 'title' => $item->title, 'url' => $item->url,
				'type' => $item->type, 'parent' => (int) $item->menu_item_parent,
			];
		}
		$menus[] = [ 'name' => $name, 'id' => (int) $menu->term_id, 'items' => $items ];
	}
	return $menus;
}

add_action( 'rest_api_init', static function () {
	register_rest_route( 'gourmeta/v1', '/components/(?P<id>\d+)', [
		'methods' => WP_REST_Server::READABLE,
		'permission_callback' => static function ( $request ) {
			$page = get_post( (int) $request['id'] );
			return $page && 'page' === $page->post_type && current_user_can( 'edit_post', $page->ID );
		},
		'callback' => 'gourmeta_visual_preview',
	] );
	register_rest_route( 'gourmeta/v1', '/site', [
		'methods' => WP_REST_Server::EDITABLE,
		'permission_callback' => static function () { return current_user_can( 'edit_theme_options' ); },
		'callback' => 'gourmeta_visual_save_site',
	] );
} );

function gourmeta_visual_preview( $request ) {
	global $post, $wp_query, $gourmeta_preview_language;
	$previous_post = $post;
	$previous_query = $wp_query;
	$post = get_post( (int) $request['id'] );
	$id = $post->ID;
	$wp_query = new WP_Query( [ 'page_id' => $id, 'post_status' => $post->post_status ] );
	setup_postdata( $post );
	$path = wp_parse_url( get_permalink( $id ), PHP_URL_PATH );
	$gourmeta_preview_language = str_starts_with( (string) $path, '/en/' ) ? 'en' : 'ru';

	try {
		$kind = sanitize_key( $request['kind'] ?? 'chrome' );
		if ( 'chrome' !== $kind ) {
			return rest_ensure_response( [
				'html' => gourmeta_visual_component( $kind, (string) $request['shortcode'], true ),
			] );
		}
		return rest_ensure_response( [
			'phone' => (array) get_option( 'phone' ),
			'header' => gourmeta_visual_component( 'header', '', true ),
			'footer' => gourmeta_visual_component( 'footer', '', true ),
			'settings' => current_user_can( 'edit_theme_options' ) ? array_merge( gourmeta_visual_site_settings(), [
				'phone' => (array) get_option( 'phone' ),
				'copyright' => (string) get_option( 'copyright' ),
				'menus' => gourmeta_visual_menu_items(),
			] ) : null,
		] );
	} finally {
		$gourmeta_preview_language = null;
		$wp_query = $previous_query;
		$post = $previous_post;
		if ( $post instanceof WP_Post ) {
			setup_postdata( $post );
		}
	}
}

function gourmeta_visual_save_site( $request ) {
	$data = $request->get_json_params();
	$current = gourmeta_visual_site_settings();
	foreach ( [ 'logo', 'homeLogo', 'partners', 'homeFooterHref' ] as $key ) {
		if ( isset( $data[$key] ) && is_string( $data[$key] ) ) {
			$current[$key] = esc_url_raw( $data[$key] );
		}
	}
	foreach ( [ 'contactHeading', 'homeFooterSummary', 'homeFooterButton', 'homeBackToTopLabel' ] as $key ) {
		if ( isset( $data[$key] ) && is_string( $data[$key] ) ) {
			$current[$key] = sanitize_text_field( $data[$key] );
		}
	}
	if ( isset( $data['homeFooterEmail'] ) && is_string( $data['homeFooterEmail'] ) ) {
		$current['homeFooterEmail'] = sanitize_email( $data['homeFooterEmail'] );
	}
	update_option( 'gourmeta_visual_site', $current );
	if ( isset( $data['phone'] ) && is_array( $data['phone'] ) ) {
		update_option( 'phone', [
			'clear' => preg_replace( '/[^0-9+]/', '', (string) ( $data['phone']['clear'] ?? '' ) ),
			'formated' => sanitize_text_field( $data['phone']['formated'] ?? '' ),
		] );
	}
	if ( isset( $data['copyright'] ) ) {
		update_option( 'copyright', wp_kses_post( $data['copyright'] ) );
	}

	if ( isset( $data['menu'] ) ) {
		$result = gourmeta_visual_update_menu( $data['menu'] );
		if ( is_wp_error( $result ) ) {
			return $result;
		}
	}
	return rest_ensure_response( [ 'saved' => true ] );
}

function gourmeta_visual_update_menu( $data ) {
	$id = (int) ( $data['id'] ?? 0 );
	$menu = wp_get_nav_menu_object( $id );
	if ( ! $menu || ! isset( $data['items'], $data['previous'] ) || ! is_array( $data['items'] ) ) {
		return new WP_Error( 'gourmeta_menu', 'Выбери существующее меню.', [ 'status' => 400 ] );
	}
	$existing = [];
	foreach ( wp_get_nav_menu_items( $id ) ?: [] as $item ) {
		$existing[(int) $item->ID] = $item;
	}
	$original = array_map( 'intval', (array) $data['previous'] );
	if ( $original !== array_keys( $existing ) ) {
		return new WP_Error( 'gourmeta_menu_conflict', 'Меню изменилось. Открой настройки повторно.', [ 'status' => 409 ] );
	}

	$items = [];
	foreach ( $data['items'] as $entry ) {
		$item_id = (int) ( $entry['id'] ?? 0 );
		$parent = (int) ( $entry['parent'] ?? 0 );
		$title = sanitize_text_field( $entry['title'] ?? '' );
		$url = esc_url_raw( $entry['url'] ?? '' );
		if ( ! $item_id || isset( $items[$item_id] ) || ( $item_id > 0 && ! isset( $existing[$item_id] ) ) ||
			'' === $title || ( $item_id < 0 && '' === $url ) ) {
			return new WP_Error( 'gourmeta_menu_item', 'Проверь названия и ссылки пунктов меню.', [ 'status' => 400 ] );
		}
		$items[$item_id] = compact( 'parent', 'title', 'url' );
	}
	foreach ( $items as $item_id => $item ) {
		$parent = $item['parent'];
		$seen = [ $item_id => true ];
		while ( $parent ) {
			if ( ! isset( $items[$parent] ) || isset( $seen[$parent] ) ) {
				return new WP_Error( 'gourmeta_menu_parent', 'Проверь вложенность пунктов меню.', [ 'status' => 400 ] );
			}
			$seen[$parent] = true;
			$parent = $items[$parent]['parent'];
		}
	}

	$created = [];
	$position = 0;
	foreach ( $items as $item_id => $item ) {
		++$position;
		if ( $item_id < 0 ) {
			$result = wp_update_nav_menu_item( $id, 0, wp_slash( [
				'menu-item-title' => $item['title'],
				'menu-item-url' => $item['url'],
				'menu-item-position' => $position,
				'menu-item-status' => 'publish',
			] ) );
			if ( is_wp_error( $result ) || ! $result ) {
				foreach ( $created as $created_id ) {
					wp_delete_post( $created_id, true );
				}
				return is_wp_error( $result ) ? $result : new WP_Error( 'gourmeta_menu_insert', 'Не удалось добавить пункт.' );
			}
			$created[$item_id] = $result;
		}
	}

	$position = 0;
	foreach ( $items as $item_id => $item ) {
		++$position;
		$database_id = $created[$item_id] ?? $item_id;
		$old = $existing[$item_id] ?? null;
		if ( $old && ( $item['title'] !== $old->title || $position !== (int) $old->menu_order ) ) {
			$result = wp_update_post( wp_slash( [
				'ID' => $database_id,
				'post_title' => $item['title'] === $old->title ? $old->post_title : $item['title'],
				'menu_order' => $position,
			] ), true );
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}
		$parent = $created[$item['parent']] ?? $item['parent'];
		update_post_meta( $database_id, '_menu_item_menu_item_parent', $parent );
		if ( $old && 'custom' === $old->type && $item['url'] !== $old->url ) {
			update_post_meta( $database_id, '_menu_item_url', $item['url'] );
		}
	}
	foreach ( array_diff_key( $existing, $items ) as $deleted ) {
		if ( ! wp_delete_post( $deleted->ID, true ) ) {
			return new WP_Error( 'gourmeta_menu_delete', 'Не удалось удалить пункт меню.', [ 'status' => 500 ] );
		}
	}
	return true;
}
