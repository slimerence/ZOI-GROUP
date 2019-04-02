<?php
/**
 * Template for displaying the quizzes in profile
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();
global $post;
$args = array();
$quizzes = learning_online_get_quizzes( $user->id, $args );
?>

<?php if ( $quizzes ) : ?>
	<ul>
		<?php foreach ( $quizzes as $post ) {
			setup_postdata( $post ); ?>

			<?php learning_online_get_template( 'profile/quiz-content.php', array( 'user' => $user ) ); ?>

		<?php } ?>
	</ul>
<?php else : ?>

	<?php learning_online_display_message( __( 'You haven\'t started any quiz!', 'learningonline' ) );?>

<?php endif; ?>

<?php wp_reset_postdata();?>
