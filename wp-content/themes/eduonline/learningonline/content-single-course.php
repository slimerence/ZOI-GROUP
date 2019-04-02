<?php
/**
 * The template for display the content of single course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c66589c6acc5e3"></script>
<div class="container">
	<?php
		
		$course = learning_online_get_the_course();
		$user   = learning_online_get_current_user();
		if ( post_password_required() ) {
			echo get_the_password_form();
			return;
		}
	
	?>


	<div class="course-summary">

		<?php if ( $user->has_course_status( $course->id, array( 'enrolled', 'finished' ) ) || !$course->is_require_enrollment() ) { ?>
			<?php learning_online_get_template( 'single-course/content-learning.php' ); ?>
		<?php } else { ?>
			<?php learning_online_get_template( 'single-course/content-landing.php' ); ?>
		<?php } ?>

	</div>

</div>