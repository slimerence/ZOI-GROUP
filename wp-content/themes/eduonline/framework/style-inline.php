<?php
/*Header*/
if (!function_exists('jws_theme_header_transparent_style_inline')) {
function jws_theme_header_transparent_style_inline() {
	global $post, $jws_theme_options;
	$postid = isset($post->ID)?$post->ID:0;
		
	/* Start Get value post meta */
		/* 1. Header menu v1 */
		$jws_theme_header_menu_bg_color = get_post_meta($postid, 'jws_theme_header_menu_bg_color', true);
		$jws_theme_header_menu_color = get_post_meta($postid, 'jws_theme_header_menu_color', true);
		$jws_theme_header_menu_hover_color = get_post_meta($postid, 'jws_theme_header_menu_hover_color', true);
		$jws_theme_header_menu_bg_color_li_hover = get_post_meta($postid, 'jws_theme_header_menu_bg_color_li_hover', true);
		$jws_theme_logo_url = isset( $jws_theme_options['jws_theme_logo_image']['url'] ) ? esc_url($jws_theme_options['jws_theme_logo_image']['url']) : '';
	/* End Get value post meta */
	

	
	/* Set value post meta on style inline */
	wp_enqueue_style('wp_custom_style', JWS_THEME_URI_PATH . '/assets/css/wp_custom_style.css',array('style'));
	$custom_style = "
		.header-menu {
			background: {$jws_theme_header_menu_bg_color};
		}
		.header-menu #nav > li > a, .header-menu .col-search-cart a.icon_search_wrap, .header-menu .col-search-cart a.icon_cart_wrap, .header-menu .col-search-cart .header-menu-item-icon a, .header-menu .col-search-cart  .tb-menu-control-mobi a{
			color: {$jws_theme_header_menu_color};
		}
		.header-menu #nav > li:hover{
			background: {$jws_theme_header_menu_bg_color_li_hover};
		}
		.header-menu #nav > li:hover a, .header-menu #nav li.current-menu-ancestor a, .header-menu #nav li.current-menu-parent a, .header-menu #nav li.current-menu-item a, .header-menu a.icon_search_wrap:hover, .header-menu a.icon_cart_wrap:hover, .header-menu .tb-menu-control-mobi a:hover {
			color: {$jws_theme_header_menu_hover_color};
		}
		.tb-menu-list .menu-bg-logo{ background-image:url({$jws_theme_logo_url});}
	";
	wp_add_inline_style( 'wp_custom_style', $custom_style );
	
	
}
add_action( 'wp_enqueue_scripts', 'jws_theme_header_transparent_style_inline' );
}

/* Fonts */
if (!function_exists('jws_theme_add_style_inline')) {
	function jws_theme_add_style_inline() {
		global $jws_theme_options;
		$custom_style = null;
		if (isset($jws_theme_options['custom_css_code']) && $jws_theme_options['custom_css_code'])  {
			$jws_theme_options['custom_css_code'] = wp_filter_nohtml_kses(esc_attr($jws_theme_options['custom_css_code'])); 
			$custom_style .= "{$jws_theme_options['custom_css_code']}";
		}
		wp_enqueue_style('wp_custom_style', JWS_THEME_URI_PATH . '/assets/css/wp_custom_style.css',array('style'));
		wp_add_inline_style( 'wp_custom_style', $custom_style );
		/*End Font*/
	}
	add_action( 'wp_enqueue_scripts', 'jws_theme_add_style_inline' );
}