<?php
/**
 * Displaying the description of single course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
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

	<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>

</div>