<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

learning_online_display_message( __( 'Your cart is currently empty.', 'learningonline' ), 'error' );

$courses_link = learning_online_get_page_link( 'courses' );
if( !$courses_link ){
	return;
}
?>
<a href="<?php echo learning_online_get_page_link( 'courses' ); ?>"><?php _e( 'Back to class', 'learningonline' ); ?></a>