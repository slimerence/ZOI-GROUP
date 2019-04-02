<?php
	// Register Custom Post Type
	function jws_theme_add_post_type_gallery() {
		// Register taxonomy
		$labels = array(
		'name'              => _x( 'Gallery Category', 'taxonomy general name', 'eduonline' ),
		'singular_name'     => _x( 'Gallery Category', 'taxonomy singular name', 'eduonline' ),
		'search_items'      => __( 'Search gallery Category', 'eduonline' ),
		'all_items'         => __( 'All Gallery Category', 'eduonline' ),
		'parent_item'       => __( 'Parent Gallery Category', 'eduonline' ),
		'parent_item_colon' => __( 'Parent Gallery Category:', 'eduonline' ),
		'edit_item'         => __( 'Edit Gallery Category', 'eduonline' ),
		'update_item'       => __( 'Update Gallery Category', 'eduonline' ),
		'add_new_item'      => __( 'Add New Gallery Category', 'eduonline' ),
		'new_item_name'     => __( 'New Gallery Category Name', 'eduonline' ),
		'menu_name'         => __( 'Gallery Category', 'eduonline' ),
		);
		$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'gallery_category' ),
		);
		if(function_exists('custom_reg_taxonomy')) {
			custom_reg_taxonomy( 'gallery_category', array( 'gallery' ), $args );
		}
		//Register post type gallery
		$labels = array(
		'name'                => _x( 'Gallery', 'Post Type General Name', 'eduonline' ),
		'singular_name'       => _x( 'Gallery Item', 'Post Type Singular Name', 'eduonline' ),
		'menu_name'           => __( 'Gallery', 'eduonline' ),
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
		'label'               => __( 'Gallery', 'eduonline' ),
		'description'         => __( 'Gallery Description', 'eduonline' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array( 'gallery_category', 'gallery_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-images-alt2',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		);
		if(function_exists('custom_reg_post_type')) {
			custom_reg_post_type( 'gallery', $args );
		}
	}
	// Hook into the 'init' action
add_action( 'init', 'jws_theme_add_post_type_gallery', 10 );