<?php
/**
 * Plugin Name: JWS Plugins
 * Plugin URI: jwsthemes.com
 * Description: JWS Plugins.
 * Version: 1.0.0
 * Author: jwsthemes
 * Author URI: jwsthemes.com
 * License: GPL2
 */
if(!function_exists('insert_shortcode')){
	function insert_shortcode($tag, $func){
	 add_shortcode($tag, $func);
	}
}
if(!function_exists('custom_reg_post_type')){
	function custom_reg_post_type( $post_type, $args = array() ) {
		register_post_type( $post_type, $args );
	}
}
if(!function_exists('custom_reg_taxonomy')){
	function custom_reg_taxonomy( $taxonomy, $object_type, $args = array() ) {
		register_taxonomy( $taxonomy, $object_type, $args );
	}
}
