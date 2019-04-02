<?php
/**
 * Common functions to process the webhooks
 *
 * @author  JwsTheme
 * @package LearningOnline/Functions
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();

/**
 * Register a webhook
 *
 * @param $key
 * @param $param
 */
function learning_online_register_web_hook( $key, $param ) {
	if ( !$key ) {
		return;
	}
	if ( empty ( $GLOBALS['learning_online']['web_hooks'] ) ) {
		$GLOBALS['learning_online']['web_hooks'] = array();
	}
	$GLOBALS['learning_online']['web_hooks'][$key] = $param;
	do_action( 'learning_online_register_web_hook', $key, $param );
}

/**
 * Return all registered webhooks
 *
 * @return mixed|void
 */
function learning_online_get_web_hooks() {
	$web_hooks = empty( $GLOBALS['learning_online']['web_hooks'] ) ? array() : (array) $GLOBALS['learning_online']['web_hooks'];
	return apply_filters( 'learning_online_web_hooks', $web_hooks );
}

/**
 * Return a registered webhook by it's name
 *
 * @param $key
 *
 * @return mixed|void
 */
function learning_online_get_web_hook( $key ) {
	$web_hooks = learning_online_get_web_hooks();
	$web_hook  = empty( $web_hooks[$key] ) ? false : $web_hooks[$key];
	return apply_filters( 'learning_online_web_hook', $web_hook, $key );
}

/**
 * Process all registered webhooks
 */
function learning_online_process_web_hooks() {
	$web_hooks           = learning_online_get_web_hooks();
	$web_hooks_processed = array();
	foreach ( $web_hooks as $key => $param ) {
		if ( !empty( $_REQUEST[$param] ) ) {
			//$web_hooks_processed           = true;
			$request_scheme                = is_ssl() ? 'https://' : 'http://';
			$requested_web_hook_url        = untrailingslashit( $request_scheme . $_SERVER['HTTP_HOST'] ) . $_SERVER['REQUEST_URI'];
			$parsed_requested_web_hook_url = parse_url( $requested_web_hook_url );
			$required_web_hook_url         = add_query_arg( $param, '1', trailingslashit( get_site_url() ) );
			$parsed_required_web_hook_url  = parse_url( $required_web_hook_url );
			$web_hook_diff                 = array_diff_assoc( $parsed_requested_web_hook_url, $parsed_required_web_hook_url );

			if ( empty( $web_hook_diff ) ) {
				do_action( 'learning_online_web_hook_' . $param, $_REQUEST );
			} else {

			}
			$web_hooks_processed[$param] = $_REQUEST;
			break;
		}
	}
	if ( $web_hooks_processed ) {
		do_action( 'learning_online_web_hooks_processed' );
		ob_start();
		foreach ( $web_hooks_processed as $k => $v ) {
			echo "\n===============================================================\n<br />";
			printf( __( 'LearningOnline webhook %s process completed', 'learningonline' ), $k );
			echo "\n<pre>";
			print_r( $v );
			echo "</pre>\n===============================================================\n";
		}
		$output = ob_get_clean();
		wp_die( $output, __( 'LearningOnline webhook process Complete', 'learningonline' ), array( 'response' => 200 ) );
	}
}

add_action( 'wp_loaded', 'learning_online_process_web_hooks', 999 );

/**
 * Update status of lesson when view at first time
 */
function learning_online_header_item_only_view_first() {
	if ( is_admin() || !learning_online_is_course() ) {
		return;
	}
	global $wpdb;

	$table  = $wpdb->prefix . 'learningonline_user_items';
	$user   = learning_online_get_current_user();
	$course = learning_online_get_the_course();
	$item   = LP()->global['course-item'];
	$status = $user->get_course_status( $course->id );
	// may be need add condition is not is_admin()
	if ( $status === 'enrolled' && $item ) {

		// If status is not null that means user has viewed this item
		$item_status = $user->get_item_status( $item->ID, $course->id );
		if ( !( '' == $item_status || false == $item_status ) ) {
			return;
		}
		$item_status = 'viewed';
		if ( $parent_id = learning_online_get_user_item_id( $user->id, $course->id ) ) {
			learning_online_update_user_item_field(
				array(
					'user_id'    => $user->id,
					'item_id'    => $item->ID,
					'start_time' => current_time( 'mysql' ),
					'end_time'   => '0000-00-00 00:00:00',
					'item_type'  => $item->post->item_type,
					'status'     => $item_status,
					'ref_id'     => $course->id,
					'ref_type'   => $course->post->post_type,
					'parent_id'  => $parent_id
				)
			);
		}
		// Update cache
		$item_statuses                                                  = LP_Cache::get_item_statuses( false, array() );
		$item_statuses[$user->id . '-' . $course->id . '-' . $item->ID] = $item_status;
		LP_Cache::set_item_statuses( $item_statuses );


		/* Insert status for lesson */
		// Consume many queries :(
		/**if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) === $table ) {
		 *
		 * $result = $wpdb->query( "SELECT * FROM `$wpdb->learningonline_user_items` WHERE `item_id`= $item->ID" );
		 * if ( $result === 0 ) {
		 * $query = $wpdb->prepare( "
		 * INSERT INTO {$wpdb->learningonline_user_items} (`user_id`, `item_id`, `start_time`, `end_time`, `item_type`, `status`, `ref_id`, `ref_type`, `parent_id`)
		 * VALUES ( $user->ID, $item->ID, %s, %s, %s, %s, $course->ID, %s, $user->ID )
		 * ", current_time( 'mysql' ), current_time( 'mysql' ), $item->_item->item_type, 'view', $course->post->post_type );
		 * $wpdb->query( $query );
		 * }
		 * }*/
	}

	// should not flush if we did not do anything
	// LP_Cache::flush();
}

add_action( 'learning_online_print_assets', 'learning_online_header_item_only_view_first' );
