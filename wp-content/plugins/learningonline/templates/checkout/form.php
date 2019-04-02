<?php
/**
 * Template for displaying checkout form
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

learning_online_print_notices();

do_action( 'learning_online_before_checkout_form', $checkout );

$checkout_url = apply_filters( 'learning_online_get_checkout_url', LP()->get_checkout_cart()->get_checkout_url() );
?>

<form method="post" id="learning-online-checkout" name="lp-checkout" class="lp-checkout" action="<?php echo esc_url( $checkout_url ); ?>" enctype="multipart/form-data">

	<?php do_action( 'learning_online_checkout_before_order_review' ); ?>

	<div id="order_review" class="learning-online-checkout-review-order">
		<?php do_action( 'learning_online_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'learning_online_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'learning_online_after_checkout_form', $checkout ); ?>