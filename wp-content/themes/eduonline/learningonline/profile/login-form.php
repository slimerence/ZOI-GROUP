<?php
/**
 * Template for displaying template of login form
 *
 * @author  JWSThemes
 * @package Templates
 * @version 2.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Overwrite template in your theme at [YOUR_THEME]/learningonline/profile/login-form.php.
 * By default, it load default login form of WP core.
 */
if ( !isset( $redirect ) ) {
	$redirect = false;
}
$login_args = array(
	'form_id' => 'learning-online-form-login',
	'context' => 'learning-online-login'
);
if ( $redirect ) {
	$login_args['redirect'] = $redirect;
}
echo '<div class="container">';
wp_login_form( $login_args );
echo '</div>';