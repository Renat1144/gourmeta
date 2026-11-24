<?php
/**
 * Shared page components and the Gutenberg interface for the Gourmeta theme.
 */

require_once __DIR__ . '/product.php';
require_once __DIR__ . '/privacy.php';

const GOURMETA_VISUAL_BLOCKS = [
	'hero' => [ 'Главный экран Gourmeta', 'cover-image', [] ],
	'home-layout' => [ 'Главная Gourmeta', 'admin-home', [] ],
	'section' => [ 'Секция', 'layout', [ 'tag' => 'string', 'html' => 'object' ] ],
	'text' => [ 'Текст Gourmeta', 'editor-paragraph', [ 'tag' => 'string', 'html' => 'object', 'value' => 'string' ] ],
	'image' => [ 'Изображение Gourmeta', 'format-image', [ 'html' => 'object', 'lightbox' => 'boolean' ] ],
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

function gourmeta_is_hero_home( $post = null ) {
	$post = get_post( $post );
	return $post && (int) $post->ID === (int) get_option( 'page_on_front' ) &&
		( has_block( 'gourmeta/hero', $post ) || has_block( 'gourmeta/home-layout', $post ) );
}

function gourmeta_design_styles( $include_inner = true ) {
	$files = [ 'hero.css', 'home.css', 'privacy.css' ];
	if ( $include_inner ) {
		$files[] = 'inner.css';
	}
	return array_map( static function ( $file ) {
		return add_query_arg( 'ver', filemtime( __DIR__ . '/' . $file ), get_template_directory_uri() . '/visual/' . $file );
	}, $files );
}

add_filter( 'body_class', static function ( $classes ) {
	$classes[] = 'gourmeta-site';
	$classes[] = is_front_page() && gourmeta_is_hero_home() ? 'gourmeta-hero-home' : 'gourmeta-inner-page';
	return $classes;
} );

add_filter( 'wp_nav_menu_objects', static function ( $items ) {
	$hidden = [];
	foreach ( $items as $item ) {
		if ( in_array( 'gh-temporarily-hidden', (array) $item->classes, true ) ) {
			$hidden[ $item->ID ] = true;
		}
	}
	if ( ! $hidden ) {
		return $items;
	}
	do {
		$count = count( $hidden );
		foreach ( $items as $item ) {
			if ( isset( $hidden[ $item->menu_item_parent ] ) ) {
				$hidden[ $item->ID ] = true;
			}
		}
	} while ( count( $hidden ) !== $count );

	return array_values( array_filter( $items, static fn( $item ) => ! isset( $hidden[ $item->ID ] ) ) );
} );

add_action( 'template_redirect', static function () {
	$equipment_archive = is_category( [ 'ru-cafitesse', 'ru-espresso', 'ru-termo', 'en-cafitesse' ] );
	$path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
	$equipment_404 = is_404() && preg_match( '~^/(?:ru|en)/equipment(?:/|$)~', (string) $path );
	if ( ! $equipment_archive && ! $equipment_404 ) {
		return;
	}
	$equipment = get_page_by_path( 'ru/equipment' );
	if ( ! $equipment || 'draft' !== $equipment->post_status ) {
		return;
	}

	// Keep old equipment URLs from redirecting to similar coffee product URLs.
	remove_action( 'template_redirect', 'redirect_canonical' );
	if ( $equipment_archive ) {
		$GLOBALS['wp_query']->set_404();
		status_header( 404 );
		nocache_headers();
	}
}, 9 );

add_action( 'wp_enqueue_scripts', static function () {
	wp_enqueue_script( 'gourmeta-hero-navigation', get_template_directory_uri() . '/visual/hero.js',
		[], filemtime( __DIR__ . '/hero.js' ), true );
	wp_enqueue_script( 'gourmeta-privacy', get_template_directory_uri() . '/visual/privacy.js',
		[], filemtime( __DIR__ . '/privacy.js' ), true );
} );

add_filter( 'wp_video_shortcode_library', static function ( $library ) {
	return is_singular( 'coffee-dispensers' ) ? '' : $library;
} );

add_filter( 'template_include', static function ( $template ) {
	if ( is_page() && get_post_meta( get_queried_object_id(), '_gourmeta_visual_layout', true ) && ! isset( $_GET['demo'] ) ) {
		return __DIR__ . '/page.php';
	}
	return $template;
} );

add_filter( 'use_block_editor_for_post', static function ( $use, $post ) {
	return in_array( $post->post_type, [ 'page', 'coffee-dispensers' ], true ) ? true : $use;
}, 101, 2 );

add_action( 'enqueue_block_editor_assets', static function () {
	global $gourmeta_coffee_dispensers;
	$screen = get_current_screen();
	if ( ! $screen || ! in_array( $screen->post_type, [ 'page', 'coffee-dispensers' ], true ) ) {
		return;
	}

	$post = get_post();
	$product = 'coffee-dispensers' === $screen->post_type;
	$uri = get_template_directory_uri();
	wp_enqueue_script( 'gourmeta-visual-editor', $uri . '/visual/editor.js',
		[ 'wp-api-fetch', 'wp-blocks', 'wp-block-editor', 'wp-components', 'wp-core-data',
			'wp-data', 'wp-editor', 'wp-element', 'wp-plugins', 'wp-url' ],
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
		'product' => $product,
		'productFields' => $product ? $gourmeta_coffee_dispensers->editor_fields() : [],
		'siteUrl' => home_url( '/' ),
		'productsUrl' => admin_url( 'edit.php?post_type=coffee-dispensers' ),
		'formsUrl' => admin_url( 'admin.php?page=wpcf7' ),
		'css' => array_merge(
			array_map( static function ( $file ) use ( $uri ) {
				return add_query_arg( 'ver', filemtime( dirname( __DIR__ ) . '/' . $file ), $uri . '/' . $file );
			}, [
				'css/default.css', 'css/layout.css', 'css/components.css', 'css/animations.css',
				'css/forms.css', 'css/pushbox.css', 'css/content.css', 'style.css', 'visual/editor.css',
			] ),
			gourmeta_design_styles(),
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
	if ( in_array( 'gh-temporarily-hidden', preg_split( '/\s+/', (string) ( $html['class'] ?? '' ) ), true ) ) {
		return '';
	}
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
			if ( 'image' === $name && ! empty( $attributes['lightbox'] ) && ! empty( $html['src'] ) && esc_url( $html['src'] ) ) {
				return '<a class="gourmeta-image-zoom" data-gourmeta-lightbox href="' . esc_url( $html['src'] ) .
					'" aria-label="Увеличить изображение">' . $opening . '</a>';
			}
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
		return gourmeta_privacy_map( $shortcode );
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
			return $page && in_array( $page->post_type, [ 'page', 'coffee-dispensers' ], true ) && current_user_can( 'edit_post', $page->ID );
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
	$query = 'page' === $post->post_type ? [ 'page_id' => $id ] : [ 'p' => $id, 'post_type' => $post->post_type ];
	$wp_query = new WP_Query( $query + [ 'post_status' => $post->post_status ] );
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
		$product = [];
		if ( 'coffee-dispensers' === $post->post_type && 'single-coffee-dispensers2.php' !== get_page_template_slug( $post ) ) {
			foreach ( [ 'intro', 'tabs', 'specifications', 'actions' ] as $part ) {
				ob_start();
				gourmeta_render_product_part( $part, true );
				$product[ $part ] = ob_get_clean();
			}
		}
		return rest_ensure_response( [
			'product' => $product,
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
