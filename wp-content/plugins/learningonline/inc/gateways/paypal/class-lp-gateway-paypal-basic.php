<?php
class LP_Gateway_Paypal_Basic extends LP_Gateway_Paypal{
	public function get_request_url( $order_id ) {

		$user = learning_online_get_current_user();

		$nonce = wp_create_nonce( 'learning-online-paypal-nonce' );
		$order = LP_Order::instance( $order_id );
		$custom = array( 'order_id' => $order_id, 'order_key' => $order->order_key );

		$query = array(
			'cmd'      => '_xclick',
			'amount'   => learning_online_get_cart_total(),
			'quantity' => '1',
			'business'      => $this->paypal_email,
			'item_name'     => learning_online_get_cart_description(),
			'return'        => add_query_arg( array( 'learning-online-transaction-method' => 'paypal-standard', 'paypal-nonce' => $nonce ), learning_online_get_cart_course_url() ),
			'currency_code' => learning_online_get_currency(),
			'notify_url'    => get_site_url() . '/?' . learning_online_get_web_hook( 'paypal-standard' ) . '=1',
			'no_note'       => '1',
			'shipping'      => '0',
			'email'         => $user->user_email,
			'rm'            => '2',
			'cancel_return' => learning_online_get_cart_course_url(),
			'custom'        => json_encode( $custom ),
			'no_shipping'   => '1'
		);

		$query = apply_filters( 'learning_online_paypal_standard_query', $query );

		$paypal_payment_url = $this->paypal_url . '?' . http_build_query( $query );

		return $paypal_payment_url;
	}
}