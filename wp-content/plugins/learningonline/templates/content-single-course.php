<?php
/**
 * The template for display the content of single course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = learning_online_get_the_course();
$user   = learning_online_get_current_user();
if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}

?>
<?php do_action( 'learning_online_before_main_content' ); ?>

<?php do_action( 'learning_online_before_single_course' ); ?>

<?php do_action( 'learning_online_before_single_course_summary' ); ?>

<div class="course-summary">

	<?php if ( $user->has_course_status( $course->id, array( 'enrolled', 'finished' ) ) || !$course->is_require_enrollment() ) { ?>
		<?php learning_online_get_template( 'single-course/content-learning.php' ); ?>
	<?php } else { ?>
		<?php learning_online_get_template( 'single-course/content-landing.php' ); ?>
	<?php } ?>

</div>

<?php do_action( 'learning_online_after_single_course_summary' ); ?>

<?php do_action( 'learning_online_after_single_course' ); ?>

<?php do_action( 'learning_online_after_main_content' ); ?>
