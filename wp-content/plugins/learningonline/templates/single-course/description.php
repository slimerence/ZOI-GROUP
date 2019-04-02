<?php
/**
 * Displaying the description of single course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.0.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

if ( $course->is( 'viewing-item' ) ) {
	if ( false === apply_filters( 'learning_online_display_course_description_on_viewing_item', false ) ) {
		return;
	}
}

$description_heading = apply_filters( 'learning_online_single_course_description_heading', __( 'Course Description', 'learningonline' ), $course );
?>

<?php if ( $description_heading ) { ?>

	<h3 class="course-description-heading" id="learning-online-course-description-heading"><?php echo $description_heading; ?></h3>

<?php } ?>

<div class="course-description" id="learning-online-course-description">

	<?php do_action( 'learning_online_begin_single_course_description' ); ?>

	<?php the_content(); ?>

	<?php do_action( 'learning_online_end_single_course_description' ); ?>

</div>