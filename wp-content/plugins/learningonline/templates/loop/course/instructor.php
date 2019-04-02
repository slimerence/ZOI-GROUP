<?php
/**
 * Template for displaying course content within the loop
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];
?>

<span class="course-instructor">
	<?php echo sprintf( __( 'By %s', 'learningonline' ), $course->get_instructor_html() ); ?>
</span>
