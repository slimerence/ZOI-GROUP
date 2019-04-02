<?php
/**
 * Setup menus in WP admin.
 *
 * @author      JwsTheme
 * @package     LearningOnline
 * @version     1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_Admin_Menu
 */
class LP_Admin_Menu {
	protected $_submenu = null;

	/**
	 * LP_Admin_Menu Construct
	 */
	public function __construct() {
		// admin menu
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_menu', array( $this, 'notify_new_course' ) );
		add_action( 'init', array( $this, 'menu_content' ) );
		add_action( 'init', 'learning_online_admin_update_settings', 1000 );
		if ( apply_filters( 'learning_online_show_admin_bar_courses_page', true ) ) {
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_menus' ), 50 );
		}

		// auto include file for admin page
		// example: slug = learning_online_settings -> file = inc/admin/sub-menus/settings.php
		$page = !empty ( $_REQUEST['page'] ) ? $_REQUEST['page'] : null;
		if ( $page ) {
			if ( strpos( $page, 'learning-online-' ) !== false ) {
				$file = preg_replace( '!^learning-online-!', '', $page );
				$file = str_replace( '_', '-', $file );
				if ( file_exists( $file = LP_PLUGIN_PATH . "/inc/admin/sub-menus/{$file}.php" ) ) {
					$this->_submenu = require_once $file;
				}
			}
		}
	}

	public function admin_bar_menus( $wp_admin_bar ) {
		if ( !is_admin() || !is_user_logged_in() ) {
			return;
		}

		if ( !is_user_member_of_blog() && !is_super_admin() ) {
			return;
		}

		if ( get_option( 'page_on_front' ) == learning_online_get_page_id( 'courses' ) ) {
			return;
		}

		$wp_admin_bar->add_node( array(
			'parent' => 'site-name',
			'id'     => 'courses-page',
			'title'  => __( 'View Courses', 'learningonline' ),
			'href'   => learning_online_get_page_link( 'courses' )
		) );
	}

	/**
	 * Register for menu for admin
	 */
	public function admin_menu() {
		$capacity = 'edit_' . LP_COURSE_CPT . 's';
		add_menu_page(
			__( 'Learning Management System', 'learningonline' ),
			'LearningOnline',
			$capacity,
			'learning_online',
			'',
			'dashicons-welcome-learn-more',
			'3.14'
		);

		$menu_items = array(
			'statistics' => array(
				'learning_online',
				__( 'Statistics', 'learningonline' ),
				__( 'Statistics', 'learningonline' ),
				$capacity,
				'learning-online-statistics',
				array( $this, 'menu_page' )
			),
			'settings'   => array(
				'learning_online',
				__( 'Settings', 'learningonline' ),
				__( 'Settings', 'learningonline' ),
				'manage_options',
				'learning-online-settings',
				'learning_online_settings_page'
			)
		);

		// Third-party can be add more items
		$menu_items = apply_filters( 'learning_online_menu_items', $menu_items );

		if ( $menu_items ) foreach ( $menu_items as $item ) {
			call_user_func_array( 'add_submenu_page', $item );
		}
	}

	/*
	 * Notify an administrator with pending courses
	 */
	public function notify_new_course() {
		global $menu;
		$current_user = wp_get_current_user();
		if ( !in_array( 'administrator', $current_user->roles ) ) {
			return;
		}
		$count_courses = wp_count_posts( LP_COURSE_CPT );
		$awaiting_mod  = $count_courses->pending;
		$menu['3.14'][0] .= " <span class='awaiting-mod count-$awaiting_mod'><span class='pending-count'>" . number_format_i18n( $awaiting_mod ) . "</span></span>";
	}

	public function menu_page() {
		if ( $this->_submenu ) {
			$this->_submenu->display();
		}
	}

	public function menu_content() {
		if ( !function_exists( 'learning_online_admin_update_settings' ) ) {
			remove_action( 'init', 'learning_online_admin_update_settings', 1000 );
		}
	}
}

return new LP_Admin_Menu();