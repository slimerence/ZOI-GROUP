<?php
/**
 * Template for displaying buttons of a quiz
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.1.6
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

if ( $user->has( 'finished-course', $course->id ) ) {
	//learning_online_display_message( __( 'You have already finished course but have not started this quiz.', 'learningonline' ) );
	return;
}

if ( !$quiz->has( 'questions' ) ) {
	return;
}

$status   = $user->get_quiz_status( $quiz->id, $course->id );
$question = $quiz->get_current_question();

?>
<form class="quiz-buttons" method="post">

	<?php if ( $user->has( 'quiz-status', array( 'started' ), $quiz->id ) ): ?>
		<button class="button-prev-question"><?php esc_html_e( 'Previous', 'learningonline' ); ?></button>
		<button class="button-next-question"><?php esc_html_e( 'Next', 'learningonline' ); ?></button>
		<?php if ( !$user->has_checked_answer( $question->id, $quiz->id, $course->id ) ): ?>
			<button
				class="button-check-answer"
				data-id="<?php esc_attr_e( $quiz->id ); ?>"
				data-action="check-answer"
				data-security="<?php esc_attr_e( wp_create_nonce( 'check-question-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
				<?php esc_html_e( 'Check', 'learningonline' ); ?>
			</button>
			<button class="button-hint" data-security="<?php esc_attr_e( wp_create_nonce( 'get-question-hint-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>"><?php esc_html_e( 'Hint', 'learningonline' ); ?></button>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( $user->has( 'quiz-status', 'completed', $quiz->id ) ): ?>

		<?php if ( $remain = $user->can( 'retake-quiz', $quiz->id ) ): ?>
			<button
				class="button-retake-quiz"
				data-action="retake-quiz"
				data-id="<?php esc_attr_e( $quiz->id ); ?>"
				data-security="<?php esc_attr_e( wp_create_nonce( 'retake-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
				<?php echo esc_html( sprintf( '%s (+%d)', __( 'Retake', 'learningonline' ), $remain ) ); ?>
			</button>
		<?php endif; ?>

	<?php elseif ( $user->can_do_quiz( $quiz->id, $course->id ) ): ?>
		<button
			class="button-start-quiz"
			data-action="start-quiz"
			data-id="<?php esc_attr_e( $quiz->id ); ?>"
			data-security="<?php esc_attr_e( wp_create_nonce( 'start-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
			<?php esc_html_e( 'Start Quiz', 'learningonline' ); ?>
		</button>
	<?php endif; ?>

	<?php if ( in_array( $status, array( 'started' ) ) ): ?>
		<button
			class="button-finish-quiz"
			data-action="finish-quiz"
			data-id="<?php esc_attr_e( $quiz->id ); ?>"
			data-security="<?php esc_attr_e( wp_create_nonce( 'finish-quiz-' . $user->id . '-' . $course->id . '-' . $quiz->id ) ); ?>">
			<?php esc_html_e( 'Finish Quiz', 'learningonline' ); ?>
		</button>
	<?php endif; ?>
	<input type="hidden" name="quiz_id" value="<?php echo esc_attr( $quiz->id ); ?>" />
	<input type="hidden" name="course_id" value="<?php echo esc_attr( $course->id ); ?>" />
	<input type="hidden" name="security" value="" />
	<input type="hidden" name="lp-ajax" value="" />
	<input type="hidden" name="noajax" value="yes" />
</form>