<?php
	// Register Custom Post Type
	function jws_theme_add_post_type_classes() {
		// Register taxonomy
		$labels = array(
		'name'              => _x( 'Classes Category', 'taxonomy general name', 'eduonline' ),
		'singular_name'     => _x( 'Classes Category', 'taxonomy singular name', 'eduonline' ),
		'search_items'      => __( 'Search Classes Category', 'eduonline' ),
		'all_items'         => __( 'All Classes Category', 'eduonline' ),
		'parent_item'       => __( 'Parent Classes Category', 'eduonline' ),
		'parent_item_colon' => __( 'Parent Classes Category:', 'eduonline' ),
		'edit_item'         => __( 'Edit Classes Category', 'eduonline' ),
		'update_item'       => __( 'Update Classes Category', 'eduonline' ),
		'add_new_item'      => __( 'Add New Classes Category', 'eduonline' ),
		'new_item_name'     => __( 'New Classes Category Name', 'eduonline' ),
		'menu_name'         => __( 'Classes Category', 'eduonline' ),
		);
		$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'classes_category' ),
		);
		if(function_exists('custom_reg_taxonomy')) {
			custom_reg_taxonomy( 'classes_category', array( 'classes' ), $args );
		}
		//Register post type classes
		$labels = array(
		'name'                => _x( 'Classes', 'Post Type General Name', 'eduonline' ),
		'singular_name'       => _x( 'Classes Item', 'Post Type Singular Name', 'eduonline' ),
		'menu_name'           => __( 'Classes', 'eduonline' ),
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
		'label'               => __( 'Classes', 'eduonline' ),
		'description'         => __( 'Classes Description', 'eduonline' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'page-attributes', 'post-formats', ),
		'taxonomies'          => array( 'classes_category', 'classes_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		);
		if(function_exists('custom_reg_post_type')) {
			custom_reg_post_type( 'classes', $args );
		}
	}
	// Hook into the 'init' action
add_action( 'init', 'jws_theme_add_post_type_classes', 10 );