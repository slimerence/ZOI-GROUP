<?php
/**
 * Template for displaying the tags of a course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

$tags = apply_filters( 'learning_online_course_tags', get_the_term_list( $course->id, 'course_tag', __( 'Tags: ', 'learningonline' ), ', ', '' ) );
if ( !$tags ) {
	return;
}
?>

<span class="course-tags"><?php echo $tags; ?></span>