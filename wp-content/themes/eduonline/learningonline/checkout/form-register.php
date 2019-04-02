<?php
/**
 * Output register form
 *
 * @author  JwsThemes
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( is_user_logged_in() ) {
	return;
}

$heading              = apply_filters( 'learning_online_checkout_register_heading', __( 'New Customer', 'learningonline' ) );
$subheading           = apply_filters( 'learning_online_checkout_register_subheading', __( 'Register Account', 'learningonline' ) );
$register_url         = learning_online_get_register_url();
$register_button_text = apply_filters( 'learning_online_checkout_register_button_text', __( 'Continue', 'learningonline' ) );
$content              = sprintf( __( 'By creating an account you will be able to keep track of the course\'s progress you have previously enrolled.<a href="%s">%s</a>', 'learningonline' ), $register_url, $register_button_text );
$content              = apply_filters( 'learning_online_checkout_register_content', $content );

?>
<div class="container">
	<div id="learning-online-checkout-user-register" class="learning-online-user-form">

		<?php do_action( 'learning_online_checkout_before_user_register_form' ); ?>

		<?php if ( $heading ) { ?>
			<h3 class="form-heading"><?php echo $heading; ?></h3>
		<?php } ?>

		<?php if ( $subheading ) { ?>
			<p class="form-subheading"><?php echo $subheading; ?></p>
		<?php } ?>

		<?php if ( $content ) { ?>
			<div class="form-content">
				<?php echo $content; ?>
			</div>
		<?php } ?>

		<?php do_action( 'learning_online_checkout_after_user_register_form' ); ?>

	</div>
</div>