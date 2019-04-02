<?php
/**
 * Template for displaying message in preview
 *
 * @package LearningOnline/Templates
 * @author  JwsTheme
 * @version 1.0
 */

!defined( ABSPATH ) || exit();

if ( !is_preview() ) {
	return;
}
learning_online_display_message( __( 'You are currently viewing quiz in preview mode.', 'learningonline' ), 'error' );