<?php
/*
 * Template for displaying the status of course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

$user = learning_online_get_current_user();

if ( !$user->has( 'purchased-course', $course->id ) ) {
	return;
}

$status = $user->get_course_status( $course->id );
?>
<span class="learning-online-course-status <?php echo sanitize_title( $status ); ?>"><?php echo ucfirst( $status ); ?></span>
