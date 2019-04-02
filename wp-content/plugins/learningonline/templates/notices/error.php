<?php
/**
 * Template for displaying all error messages from queue
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! $messages ){
	return;
}

?>

<ul class="learning-online-message error">
	<?php foreach ( $messages as $message ) : ?>
		<li><?php echo /*wp_kses_post*/( $message ); ?></li>
	<?php endforeach; ?>
</ul>