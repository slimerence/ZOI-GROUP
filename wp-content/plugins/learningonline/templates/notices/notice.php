<?php
/**
 * Template for displaying all notice messages from queue
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
if ( !$messages ) {
	return;
}

?>

<?php foreach ( $messages as $message ) : ?>
	<div class="learning-online-message notice">
		<?php echo /*wp_kses_post*/( $message ); ?>
	</div>
<?php endforeach; ?>
