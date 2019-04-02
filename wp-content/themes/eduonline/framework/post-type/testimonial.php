<?php
	// Register Custom Post Type
	function jws_theme_add_post_type_testimonial() {
		// Register taxonomy
		$labels = array(
		'name'              => _x( 'Testimonial Category', 'taxonomy general name', 'eduonline' ),
		'singular_name'     => _x( 'Testimonial Category', 'taxonomy singular name', 'eduonline' ),
		'search_items'      => __( 'Search Testimonial Category', 'eduonline' ),
		'all_items'         => __( 'All Testimonial Category', 'eduonline' ),
		'parent_item'       => __( 'Parent Testimonial Category', 'eduonline' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:', 'eduonline' ),
		'edit_item'         => __( 'Edit Testimonial Category', 'eduonline' ),
		'update_item'       => __( 'Update Testimonial Category', 'eduonline' ),
		'add_new_item'      => __( 'Add New Testimonial Category', 'eduonline' ),
		'new_item_name'     => __( 'New Testimonial Category Name', 'eduonline' ),
		'menu_name'         => __( 'Testimonial Category', 'eduonline' ),
		);
		$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testimonial_category' ),
		);
		if(function_exists('custom_reg_taxonomy')) {
			custom_reg_taxonomy( 'testimonial_category', array( 'testimonial' ), $args );
		}
		//Register tags
		$labels = array(
		'name'              => _x( 'Testimonial Tag', 'taxonomy general name', 'eduonline' ),
		'singular_name'     => _x( 'Testimonial Tag', 'taxonomy singular name', 'eduonline' ),
		'search_items'      => __( 'Search Testimonial Tag', 'eduonline' ),
		'all_items'         => __( 'All Testimonial Tag', 'eduonline' ),
		'parent_item'       => __( 'Parent Testimonial Tag', 'eduonline' ),
		'parent_item_colon' => __( 'Parent Testimonial Tag:', 'eduonline' ),
		'edit_item'         => __( 'Edit Testimonial Tag', 'eduonline' ),
		'update_item'       => __( 'Update Testimonial Tag', 'eduonline' ),
		'add_new_item'      => __( 'Add New Testimonial Tag', 'eduonline' ),
		'new_item_name'     => __( 'New Testimonial Tag Name', 'eduonline' ),
		'menu_name'         => __( 'Testimonial Tag', 'eduonline' ),
		);
		$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testimonial_tag' ),
		);
		if(function_exists('custom_reg_taxonomy')) {
			custom_reg_taxonomy( 'testimonial_tag', array( 'testimonial' ), $args );
		}
		//Register post type Testimonial
		$labels = array(
		'name'                => _x( 'Testimonial', 'Post Type General Name', 'eduonline' ),
		'singular_name'       => _x( 'Testimonial Item', 'Post Type Singular Name', 'eduonline' ),
		'menu_name'           => __( 'Testimonial', 'eduonline' ),
		'parent_item_colon'   => __( 'Parent Item:', 'eduonline' ),
		'all_items'           => __( 'All Items', 'eduonline' ),
		'view_item'           => __( 'View Item', 'eduonline' ),
		'add_new_item'        => __( 'Add New Item', 'eduonline' ),
		'add_new'             => __( 'Add New', 'eduonline' ),
		'edit_item'           => __( 'Edit Item', 'eduonline' ),
		'update_item'         => __( 'Update Item', 'eduonline' ),
		'search_items'        => __( 'Search Item', 'eduonline' ),
		'not_found'           => __( 'Not found', 'eduonline' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'eduonline' ),
		);
		$args = array(
		'label'               => __( 'Testimonial', 'eduonline' ),
		'description'         => __( 'Testimonial Description', 'eduonline' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array( 'testimonial_category', 'testimonial_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-format-status',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		);
		if(function_exists('custom_reg_post_type')) {
			custom_reg_post_type( 'testimonial', $args );
		}
	}
	// Hook into the 'init' action
add_action( 'init', 'jws_theme_add_post_type_testimonial', 0 );