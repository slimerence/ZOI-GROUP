<?php
/**
 * Template for displaying quiz's introduction
 *
 * @package LearningOnline/Templates
 * @author JwsTheme
 * @version 1.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];
$quiz   = LP()->global['course-item'];
$user   = learning_online_get_current_user();
if ( !$quiz ) {
	return;
}
if ( $user->has( 'quiz-status', array( 'started', 'completed' ), $quiz->id, $course->id ) ) {
	return;
}
?>

<ul class="quiz-intro">
	<li>
		<label><?php _e( 'Attempts allowed:', 'learningonline' ); ?></label>
		<?php echo $quiz->retake_count; ?>
	</li>
	<li>
		<label><?php _e( 'Duration:', 'learningonline' ); ?></label>
		<?php echo $quiz->get_duration_html(); ?>
	</li>
	<li>
		<label><?php _e( 'Passing grade:', 'learningonline' ); ?></label>
		<?php echo sprintf( '%d%%', $quiz->passing_grade ); ?>
	</li>
	<li>
		<label><?php _e( 'Questions:', 'learningonline' ); ?></label>
		<?php echo $quiz->get_total_questions(); ?>
	</li>
</ul>
