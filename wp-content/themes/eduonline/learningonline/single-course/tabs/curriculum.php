<?php
/**
 * Template for displaying the curriculum of a course
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

$curriculum_heading = apply_filters( 'learning_online_curriculum_heading', '' );
?>
<div class="course-curriculum" id="learning-online-course-curriculum">

	<?php if ( $curriculum_heading ) { ?>

		<h2 class="course-curriculum-title"><?php echo $curriculum_heading; ?></h2>

	<?php } ?>

	<?php do_action( 'learning_online_before_single_course_curriculum' ); ?>

	<?php if ( $curriculum = $course->get_curriculum() ): ?>

		<ul class="curriculum-sections">

			<?php foreach ( $curriculum as $section ) : ?>

				<?php learning_online_get_template( 'single-course/loop-section.php', array( 'section' => $section ) ); ?>

			<?php endforeach; ?>

		</ul>

	<?php else: ?>
		<?php echo apply_filters( 'learning_online_course_curriculum_empty', __( 'Curriculum is empty', 'learnpress' ) ); ?>
	<?php endif; ?>

	<?php do_action( 'learning_online_after_single_course_curriculum' ); ?>

</div>