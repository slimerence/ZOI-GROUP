<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

$course = LP()->global['course'];
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$item = LP()->global['course-item'];
if ( !$item ) {
	return;
}
?>
<div class="course-lesson-description">

	<?php if ( $the_content = apply_filters( 'learning_online_course_lesson_content', $item->get_content() ) ): ?>

		<?php echo $the_content; ?>

	<?php else: ?>

		<?php learning_online_display_message( __( 'This lesson has no content', 'learningonline' ) ); ?>

	<?php endif; ?>

</div>
