<?php
/**
 * Output login form
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

$heading    = apply_filters( 'learning_online_checkout_login_heading', __( 'Returning customer', 'learningonline' ) );
$subheading = apply_filters( 'learning_online_checkout_login_subheading', __( 'I am a returning customer', 'learningonline' ) );

?>

<div id="learning-online-checkout-user-login" class="learning-online-user-form">

	<?php do_action( 'learning_online_checkout_before_user_login_form' ); ?>

	<?php if ( $heading ) { ?>
		<h3 class="form-heading"><?php echo $heading; ?></h3>
	<?php } ?>

	<?php if ( $subheading ) { ?>
		<p class="form-subheading"><?php echo $subheading; ?></p>
	<?php } ?>

	<ul class="form-fields">

		<?php do_action( 'learning_online_checkout_user_login_before_form_fields' ); ?>

		<li>
			<label><?php _e( 'Username' ); ?></label>
			<input type="text" name="user_login" />
		</li>
		<li>
			<label><?php _e( 'Password' ); ?></label>
			<input type="password" name="user_password" />
		</li>
		<li>
			<button type="button" id="learning-online-checkout-login-button"><?php _e( 'Login', 'learningonline' ); ?></button>
		</li>

		<?php do_action( 'learning_online_checkout_user_login_after_form_fields' ); ?>

	</ul>

	<?php do_action( 'learning_online_checkout_after_user_login_form' ); ?>

</div>