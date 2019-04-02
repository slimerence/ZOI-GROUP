<?php
/**
 * Checkout Payment Section
 *
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       2.0.4
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$payment_heading              = apply_filters( 'learning_online_checkout_payment_heading', __( 'Payment Method', 'learningonline' ) );
$order_button_text            = apply_filters( 'learning_online_order_button_text', __( 'Place order', 'learningonline' ) );
$order_button_text_processing = apply_filters( 'learning_online_order_button_text_processing', __( 'Processing', 'learningonline' ) );
$show_button                  = true;
$count_gateways               = !empty( $available_gateways ) ? sizeof( $available_gateways ) : 0;
?>

<div id="learning-online-payment" class="learning-online-checkout-payment">
	<?php if ( LP()->get_checkout_cart()->needs_payment() ): ?>

		<?php if ( !$count_gateways ): $show_button = false; ?>

			<?php if ( $message = apply_filters( 'learning_online_no_available_payment_methods_message', __( 'No payment methods is available.', 'learningonline' ) ) ) { ?>
				<?php learning_online_display_message( $message, 'error' ); ?>
			<?php } ?>

		<?php else: ?>
			<?php if ( $payment_heading ) { ?>
				<h3><?php echo $payment_heading; ?></h3>
			<?php } ?>
			<ul class="payment-methods">

				<?php do_action( 'learning_online_before_payments' ); ?>

				<?php $order = 1; ?>
				<?php foreach ( $available_gateways as $gateway ) {

					if ( $order == 1 ) {
						learning_online_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway, 'selected' => $gateway->id ) );
					} else {
						learning_online_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway, 'selected' => '' ) );
					}

					$order ++;

					?>

				<?php } ?>

				<?php do_action( 'learning_online_after_payments' ); ?>

			</ul>

		<?php endif; ?>

	<?php endif; ?>
	<?php if ( $show_button ): ?>

		<div class="place-order-action">

			<?php do_action( 'learning_online_order_before_submit' ); ?>

			<?php echo apply_filters( 'learning_online_order_button_html', '<input type="submit" class="button alt" name="learning_online_checkout_place_order" id="learning-online-checkout-place-order" data-processing-text="' . esc_attr( $order_button_text_processing ) . '" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '" disabled="disabled" />' ); ?>

			<?php do_action( 'learning_online_order_after_submit' ); ?>

		</div>

	<?php endif; ?>

</div>