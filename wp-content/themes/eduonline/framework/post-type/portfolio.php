<?php
	// Register Custom Post Type
	function jws_theme_add_post_type_portfolio() {
		// Register taxonomy
		$labels = array(
		'name'              => _x( 'Portfolio Category', 'taxonomy general name', 'eduonline' ),
		'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name', 'eduonline' ),
		'search_items'      => __( 'Search Portfolio Category', 'eduonline' ),
		'all_items'         => __( 'All Portfolio Category', 'eduonline' ),
		'parent_item'       => __( 'Parent Portfolio Category', 'eduonline' ),
		'parent_item_colon' => __( 'Parent Portfolio Category:', 'eduonline' ),
		'edit_item'         => __( 'Edit Portfolio Category', 'eduonline' ),
		'update_item'       => __( 'Update Portfolio Category', 'eduonline' ),
		'add_new_item'      => __( 'Add New Portfolio Category', 'eduonline' ),
		'new_item_name'     => __( 'New Portfolio Category Name', 'eduonline' ),
		'menu_name'         => __( 'Portfolio Category', 'eduonline' ),
		);
		$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'portfolio_category' ),
		);
		if(function_exists('custom_reg_taxonomy')) {
			custom_reg_taxonomy( 'portfolio_category', array( 'portfolio' ), $args );
		}
		//Register post type Portfolio
		$labels = array(
		'name'                => _x( 'Portfolio', 'Post Type General Name', 'eduonline' ),
		'singular_name'       => _x( 'Portfolio Item', 'Post Type Singular Name', 'eduonline' ),
		'menu_name'           => __( 'Portfolio', 'eduonline' ),
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
		'label'               => __( 'Portfolio', 'eduonline' ),
		'description'         => __( 'Portfolio Description', 'eduonline' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', ),
		'taxonomies'          => array( 'portfolio_category', 'portfolio_tag' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-id-alt',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
		);
		if(function_exists('custom_reg_post_type')) {
			custom_reg_post_type( 'portfolio', $args );
		}
	}
	// Hook into the 'init' action
add_action( 'init', 'jws_theme_add_post_type_portfolio', 10 );