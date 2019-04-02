<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       1.0
 */

defined( 'ABSPATH' ) || exit();
?>
<?php if ( $order ) : ?>

	<?php if ( $order->has_status( 'failed' ) ) : ?>

		<p><?php _e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction.', 'learningonline' ); ?></p>

		<p><?php
			if ( is_user_logged_in() )
				_e( 'Please attempt your purchase again or go to your account page.', 'learningonline' );
			else
				_e( 'Please attempt your purchase again.', 'learningonline' );
			?></p>

		<p>
			<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php _e( 'Pay', 'learningonline' ) ?></a>
			<?php if ( is_user_logged_in() ) : ?>
				<a href="<?php echo esc_url( get__permalink( 'myaccount' ) ); ?>" class="button pay"><?php _e( 'My Account', 'learningonline' ); ?></a>
			<?php endif; ?>
		</p>

	<?php else : ?>

		<p><?php echo apply_filters( 'learning_online_confirm_order_received_text', __( 'Thank you. Your order has been received.', 'learningonline' ), $order ); ?></p>

		<ul class="order_details">
			<li class="order">
				<?php _e( 'Order Number:', 'learningonline' ); ?>
				<strong><?php echo $order->get_order_number(); ?></strong>
			</li>
			<li class="date">
				<?php _e( 'Date:', 'learningonline' ); ?>
				<strong><?php echo date_i18n( get_option( 'date_format' ), strtotime( $order->order_date ) ); ?></strong>
			</li>
			<li class="total">
				<?php _e( 'Total:', 'learningonline' ); ?>
				<strong><?php echo $order->get_formatted_order_total(); ?></strong>
			</li>
			<?php if ( $payment_method_title = $order->get_payment_method_title() ) : ?>
				<li class="method">
					<?php _e( 'Payment Method:', 'learningonline' ); ?>
					<strong><?php echo $payment_method_title; ?></strong>
				</li>
			<?php endif; ?>
			<li class="status">
				<?php _e( 'Status:', 'learningonline' ); ?>
				<strong><?php echo $order->get_status(); ?></strong>
			</li>
		</ul>
		<div class="clear"></div>

	<?php endif; ?>

	<?php do_action( 'learning_online_confirm_order' . $order->transaction_method, $order->id ); ?>
	<?php do_action( 'learning_online_confirm_order', $order->id ); ?>

<?php else : ?>

	<p><?php echo apply_filters( 'learning_online_confirm_order_received_text', __( 'Thank you. Your order has been received.', 'learningonline' ), null ); ?></p>

<?php endif; ?>