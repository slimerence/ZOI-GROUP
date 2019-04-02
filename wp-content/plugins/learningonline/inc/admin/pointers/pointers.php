<?php


/**
 * Load pointer
 */
function learning_online_pointer_load() {

	// Don't run on WP < 3.3
	if ( get_bloginfo( 'version' ) < '3.3' )
		return;

	$screen    = get_current_screen();
	$screen_id = $screen->id;

	// Get pointers for this screen
	$pointers = apply_filters( 'learning_online_admin_pointers-' . $screen_id, array() );

	if ( !$pointers || !is_array( $pointers ) )
		return;

	// Get dismissed pointers
	$dismissed      = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );
	$valid_pointers = array();

	// Check pointers and remove dismissed ones.
	foreach ( $pointers as $pointer_id => $pointer ) {

		// Sanity check
		if ( in_array( $pointer_id, $dismissed ) || empty( $pointer ) || empty( $pointer_id ) || empty( $pointer['target'] ) || empty( $pointer['options'] ) )
			continue;

		$pointer['pointer_id'] = $pointer_id;

		// Add the pointer to $valid_pointers array
		$valid_pointers['pointers'][] = $pointer;
	}

	// No valid pointers? Stop here.
	if ( empty( $valid_pointers ) )
		return;

	// Add pointers style to queue.
	wp_enqueue_style( 'wp-pointer' );

	// Add pointers script to queue. Add custom script.
	//wp_enqueue_script( 'learning_online-pointer', LP_JS_URL . 'pointer.js', array( 'wp-pointer' ) );

	// Add pointer options to script.
	wp_localize_script( 'learning-online-admin', 'lpPointer', $valid_pointers );
}
add_action( 'admin_enqueue_scripts', 'learning_online_pointer_load', 1000 );

/**
 * Register pointer
 *
 * @param $pointer
 *
 * @return mixed
 */
function learning_online_register_pointer_in_edit_course( $pointer ) {
	$pointer['lp_course_guide'] = array(
		'target'  => '#course_curriculum',
		'options' => array(
			'content'  => sprintf( '<h3> %s </h3> <p> %s </p>',
				__( 'Course Curriculum', 'learningonline' ),
				__( 'Build a course by selecting created lessons and quizzes or adding new ones. Sorting, editing, shortcuts (l and q), it never gets easier with LP.', 'learningonline' )
			),
			'position' => array( 'edge' => 'top', 'align' => 'middle' )
		)
	);
	return $pointer;
}
add_filter( 'learning_online_admin_pointers-lpr_course', 'learning_online_register_pointer_in_edit_course' );
