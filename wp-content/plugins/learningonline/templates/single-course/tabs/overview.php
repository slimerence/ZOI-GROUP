<?php
/**
 * Displaying the description of single course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

if ( !$course ) {
	return;
}

$description_heading = apply_filters( 'learning_online_single_course_description_heading', '', $course );
?>

<?php if ( $description_heading ) { ?>

	<h2 class="course-description-heading" id="learning-online-course-description-heading"><?php echo $description_heading; ?></h2>

<?php } ?>

<div class="course-description" id="learning-online-course-description">

	<?php do_action( 'learning_online_begin_single_course_description' ); ?>

	<?php echo $course->get_description(); ?>

	<?php do_action( 'learning_online_end_single_course_description' ); ?>

</div>