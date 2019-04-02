<?php
/**
 * Defines the functions which called by hooks
 */

/**
 * Filter post types the user can access in admin
 *
 * @param $query
 */
function _learning_online_set_user_items( $query ) {
	global $post_type, $pagenow, $wpdb;

	if ( current_user_can( 'manage_options' ) || ! current_user_can( LP_TEACHER_ROLE ) || ! is_admin() || ( $pagenow != 'edit.php' ) ) {
		return $query;
	}
	if ( ! in_array( $post_type, array( 'lp_course', LP_LESSON_CPT, LP_QUIZ_CPT, LP_QUESTION_CPT ) ) ) {
		return;
	}
	$items = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts
					WHERE post_type = %s
					AND post_author = %d",
			$post_type,
			get_current_user_id()
		)
	);

	if ( count( $items ) == 0 ) {
		$query->set( 'post_type', 'no-item-access' );
	} else {
		$query->set( 'post__in', $items );
	}
	add_filter( 'views_edit-' . $post_type . '', '_learning_online_restrict_view_items', 10 );
}

add_action( 'pre_get_posts', '_learning_online_set_user_items', 10 );

/**
 * Restrict user views
 *
 * @param $views
 *
 * @return mixed
 */
function _learning_online_restrict_view_items( $views ) {
	$post_type = get_query_var( 'post_type' );
	$new_views = array(
		'all'     => __( 'All', 'learningonline' ),
		'publish' => __( 'Published', 'learningonline' ),
		'private' => __( 'Private', 'learningonline' ),
		'pending' => __( 'Pending Review', 'learningonline' ),
		'future'  => __( 'Scheduled', 'learningonline' ),
		'draft'   => __( 'Draft', 'learningonline' ),
		'trash'   => __( 'Trash', 'learningonline' ),
	);
	$url       = 'edit.php';
	foreach ( $new_views as $view => $name ) {
		$query = array(
			'post_type' => $post_type
		);
		if ( $view == 'all' ) {
			$query['all_posts'] = 1;
			$class              = ( get_query_var( 'all_posts' ) == 1 || ( get_query_var( 'post_status' ) == '' && get_query_var( 'author' ) == '' ) ) ? ' class="current"' : '';
		} else {
			$query['post_status'] = $view;
			$class                = ( get_query_var( 'post_status' ) == $view ) ? ' class="current"' : '';
		}
		$result = new WP_Query( $query );
		if ( $result->found_posts > 0 ) {
			$views[ $view ] = sprintf(
				'<a href="%s"' . $class . '>' . __( $name, 'learningonline' ) . ' <span class="count">(%d)</span></a>',
				esc_url( add_query_arg( $query, $url ) ),
				$result->found_posts
			);
		} else {
			unset( $views[ $view ] );
		}
	}
	// remove view 'mine'
	unset( $views['mine'] );

	return $views;
}

/**
 * Update permalink structure for course
 */
function learning_online_update_permalink_structure() {
	global $pagenow;
	if ( $pagenow != 'options-permalink.php' ) {
		return;
	}
	if ( strtolower( $_SERVER['REQUEST_METHOD'] ) != 'post' ) {
		return;
	}
	$rewrite_prefix      = '';
	$permalink_structure = ! empty( $_REQUEST['permalink_structure'] ) ? $_REQUEST['permalink_structure'] : '';
	if ( $permalink_structure ) {
		$rewrite_prefix = array();
		$segs           = explode( '/', $permalink_structure );
		if ( sizeof( $segs ) ) {
			foreach ( $segs as $seg ) {
				if ( strpos( $seg, '%' ) !== false || $seg == 'archives' ) {
					break;
				}
				$rewrite_prefix[] = $seg;
			}
		}
		$rewrite_prefix = array_filter( $rewrite_prefix );
		if ( sizeof( $rewrite_prefix ) ) {
			$rewrite_prefix = join( '/', $rewrite_prefix ) . '/';
		} else {
			$rewrite_prefix = '';
		}
	}
	update_option( 'learning_online_permalink_structure', $rewrite_prefix );
}

add_action( 'init', 'learning_online_update_permalink_structure' );

//add_action( 'wp_dashboard_setup', 'learningonline_dashboard_widgets' );

if ( ! function_exists( 'learningonline_dashboard_widgets' ) ) {
	/**
	 * Register dashboard widgets
	 *
	 * LearningOnline statistic
	 * Eduma statistic
	 * @since 2.0
	 */
	function learningonline_dashboard_widgets() {
		wp_add_dashboard_widget( 'learning_online_dashboard_widget', __( 'LearningOnline Plugin', 'learningonline' ), array(
			'LP_Statistic_Plugin',
			'render'
		) );
		wp_add_dashboard_widget( 'learning_online_dashboard_widget_status', __( 'LearningOnline Status', 'learningonline' ), array(
			'LP_Statistic_Status',
			'render'
		) );
	}
}