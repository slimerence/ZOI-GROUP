<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       1.0
 */

defined( 'ABSPATH' ) || exit();

if ( !isset( $question_id ) ) {
	return;
}

if ( !learning_online_is_yes( LP()->global['course-item']->show_result ) || !LP()->user->has( 'completed-quiz', LP()->global['course-item']->id ) ) {
	return;
}

if ( !has_action( 'learning_online_quiz_question_display_hint_' . $question_id ) ) {
	return;
}
?>
<div class="learning-online-question-answer">

	<?php do_action( 'learning_online_quiz_question_display_hint_' . $question_id, get_the_ID(), get_current_user_id() ); ?>

</div>
