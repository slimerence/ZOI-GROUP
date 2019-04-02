<?php
if ( isset( $order_items ) ) {
	$currency_symbol = learning_online_get_currency_symbol( $order_items->currency );
} else {
	$currency_symbol = learning_online_get_currency_symbol();
}
global $post;
?>
<div id="learning-online-order" class="order-details">
	<div class="order-data">
		<h3 class="order-data-number"><?php echo sprintf( __( 'Order %s', 'learningonline' ), $order->get_order_number() ); ?></h3>

		<div
			class="order-data-date"><?php echo sprintf( __( 'Date %s', 'learningonline' ), $order->order_date ); ?></div>
		<div class="order-data-status <?php echo sanitize_title( $order->post_status ); ?>"><?php echo sprintf( __( 'Status %s', 'learningonline' ), $order->get_order_status() ); ?></div>
		<div
			class="order-data-payment-method"><?php echo learning_online_payment_method_from_slug( $post->ID ); ?></div>
	</div>
	<div class="order-user-data clearfix">
		<div class="order-user-avatar">
			<?php if ( $order->is_multi_users() ) { ?>
				<div class="avatar-multiple-users">
					<span></span>
				</div>
			<?php } else { ?>
				<?php echo get_avatar( $order->get_user( 'ID' ), 120 ); ?>
			<?php } ?>
		</div>
		<div class="order-user-meta">
			<?php if ( $order->is_multi_users() ) { ?>
				<div class="order-users">
					<strong><?php _e( 'Customers', 'learningonline' ); ?></strong>
					<p><?php $order->print_users(); ?></p>
				</div>
			<?php } else { ?>
				<div class="user-display-name">
					<?php echo $order->get_customer_name(); ?>
				</div>
				<div class="user-email">
					<?php $user_email = $order->get_user( 'user_email' );
					echo empty( $user_email ) ? '' : $user_email; ?>
				</div>
				<div class="user-ip-address">
					<?php echo $order->user_ip_address; ?>
				</div>
			<?php } ?>
			<?php if ( $title = $order->get_payment_method_title() ) { ?>
				<div class="payment-method-title">
					<?php echo $order->order_total == 0 ? $title : sprintf( __( 'Pay via <strong>%s</strong>', 'learningonline' ), $title ); ?>
				</div>
			<?php } ?>
		</div>
	</div>
	<br />

	<h3><?php _e( 'Order Items', 'learningonline' ); ?></h3>
	<div class="order-items">
		<table>
			<thead>
			<tr>
				<th><?php _e( 'Item', 'learningonline' ); ?></th>
				<th><?php _e( 'Cost', 'learningonline' ); ?></th>
				<th><?php _e( 'Quantity', 'learningonline' ); ?></th>
				<th class="align-right"><?php _e( 'Amount', 'learningonline' ); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php if ( $items = $order->get_items() ): ?>
				<?php foreach ( $items as $item ) : ?>
					<?php include learning_online_get_admin_view( 'meta-boxes/order/order-item.php' ); ?>
				<?php endforeach; ?>
			<?php endif; ?>
			<tr class="no-order-items<?php echo $items ? ' hide-if-js' : ''; ?>">
				<td colspan="4"><?php _e( 'No order items', 'learningonline' ); ?></td>
			</tr>
			</tbody>
			<tfoot>
			<tr>
				<td width="300" colspan="3" class="align-right"><?php _e( 'Sub Total', 'learningonline' ); ?></td>
				<td width="100" class="align-right">
					<span class="order-subtotal">
						<?php echo learning_online_format_price( $order->order_subtotal, $currency_symbol ); ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="align-right" colspan="3"><?php _e( 'Total', 'learningonline' ); ?></td>
				<td class="align-right total">
					<span class="order-total">
						<?php echo learning_online_format_price( $order->order_total, $currency_symbol ); ?>
					</span>
				</td>
			</tr>
			<tr>
				<td class="align-right" colspan="4">
					<button class="button" type="button" id="learning-online-add-order-item"><?php _e( 'Add Item', 'learningonline' ); ?></button>
					<!--<button class="button" type="button" id="learning-online-calculate-order-total"><?php _e( 'Calculate Total', 'learningonline' ); ?></button>-->
				</td>
			</tr>
			</tfoot>
		</table>
	</div>
	<?php if ( $note = get_the_excerpt() ) { ?>
		<br />
		<h3><?php _e( 'Customer Note', 'learningonline' ); ?></h3>
		<p class="order-note description"><?php echo $note; ?></p>
	<?php } ?>
</div>
<script type="text/html" id="tmpl-learning-online-modal-add-order-courses">
	<div id="learning-online-modal-add-order-courses" class="lp-modal-search" data-nonce="<?php echo wp_create_nonce( 'add_item_to_order' ); ?>">
		<div class="lp-search-items">
			<input type="text" id="learning-online-search-item-term" data-nonce="<?php echo wp_create_nonce( 'search_item_term' ); ?>" name="lp-item-name" placeholder="<?php _e( 'Type here to search the course', 'learningonline' ); ?>" />
		</div>
		<ul id="learning-online-courses-result">
			<li class="lp-search-no-results hide-if-js" data-id="0"><?php _e( 'No results', 'learningonline' ); ?></li>
		</ul>
		<button class="lp-close-lightbox button" onclick="LP.MessageBox.hide();"><?php _e( 'Close', 'learningonline' ); ?></button>
	</div>
</script>