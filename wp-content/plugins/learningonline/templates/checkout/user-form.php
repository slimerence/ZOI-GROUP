<?php
/**
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
?>

<div id="learning-online-checkout-user-form">

	<?php do_action( 'learning_online_checkout_user_form' ); ?>

	<div class="clearfix"></div>
</div>
