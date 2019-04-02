<?php
	/**
		* Cart Page
		*
		* @author  WooThemes
		* @package WooCommerce/Templates
		* @version 2.3.8
	*/
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}
	
	wc_print_notices();
	
do_action( 'woocommerce_before_cart' ); ?>

<form class="ro-cart-form" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
	
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	<div class="ro-cart-table">
		<table class="shop_table cart" cellspacing="0">
			<thead>
				<tr>
					<th class="ro-table-col-product text-center"><?php _e( 'Product', 'eduonline' ); ?></th>
					<th class="ro-table-col-qty text-center"><?php _e( 'Quantity', 'eduonline' ); ?></th>
					<th class="ro-table-col-price text-center"><?php _e( 'Price', 'eduonline' ); ?></th>
					<th class="ro-table-col-total text-center"><?php _e( 'Total', 'eduonline' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php do_action( 'woocommerce_before_cart_contents' ); ?>
				
				<?php
				foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
				
				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="ro-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				
				<td>
				<div class="ro-cart-thumb">
				<?php
				$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				
				if ( ! $_product->is_visible() )
				echo do_shortcode( $thumbnail );
				else
				printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
				?>
				</div>
				
				<div class="ro-cart-detail">
				<?php
				if ( ! $_product->is_visible() )
				echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
				else
				echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s </a>', $_product->get_permalink( $cart_item ), $_product->get_title() ), $cart_item, $cart_item_key );
				
				// Meta data
				echo WC()->cart->get_item_data( $cart_item );
				
				// Backorder notification
				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
				echo '<p class="backorder_notification">' . __( 'Available on backorder', 'eduonline' ) . '</p>';
				?>
				</div>
				</td>
				
				<td class="ro-table-col-qty text-center">
				<?php
				if ( $_product->is_sold_individually() ) {
				$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
				} else {
				$product_quantity = woocommerce_quantity_input( array(
				'input_name'  => "cart[{$cart_item_key}][qty]",
				'input_value' => $cart_item['quantity'],
				'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
				'min_value'   => '0'
				), $_product, false );
				}
				
				echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
				?>
				
				<?php
				echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s"><span>x</span></a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', 'eduonline' ) ), $cart_item_key );
				?>
				
				</td>
				
				<td class="ro-table-col-price text-center">
				<?php
				echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				?>
				</td>
				
				<td class="text-center">
				<?php
				echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
				?>
				</td>
				
				
				</tr>
				<?php
				}
				}
				
				do_action( 'woocommerce_cart_contents' );
				?>
				<tr class="ro-action-wrap">
				<td colspan="6" class="actions">
				
				<input type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update Cart', 'eduonline' ); ?>" />
				
				<?php do_action( 'woocommerce_cart_actions' ); ?>
				
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
				</td>
				</tr>
				
				<?php do_action( 'woocommerce_after_cart_contents' ); ?>
				</tbody>
				</table>
				</div>
				<?php do_action( 'woocommerce_after_cart_table' ); ?>
				
				</form>
				
				<div class="row">
				<div class="col-lg-7 col-xs-12 col-sm-8">
				
				<div id="tb-tab-container" class="tb-tab-container">
				<ul class="etabs">
				<li class='tab'><a href="#tabs-2"><?php esc_html_e('Estimate Shipping & Tax','eduonline');?></a></li>
				<li class='tab'><a href="#tabs-1"><?php esc_html_e('Use Coupon Code','eduonline');?></a></li>
				</ul>
				
				<div class="tb-data-tab">
				<div id="tabs-1">
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
				<form class="ro-cart-form" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">
				<div class="coupon">
				<label for="coupon_code"><?php _e( 'Coupon', 'eduonline' ); ?>:</label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'noraure' ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply Coupon', 'noraure' ); ?>" />
				
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
				</div>
				</form>
				<?php } ?>
				</div>
				
				<div id="tabs-2">
				<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
				
				<?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
				
				<?php wc_cart_totals_shipping_html(); ?>
				
				<?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
				
				<?php elseif ( WC()->cart->needs_shipping() ) : ?>
				
				<div class="shipping">
				<div><?php woocommerce_shipping_calculator(); ?></div>
				</div>
				
				<?php endif; ?>
				</div>
				</div>
				</div>
				
				</div>
				
				<div class="col-xs-12 col-sm-4 col-lg-offset-1">
				<div class="cart-collaterals">
				
				<?php do_action( 'woocommerce_cart_collaterals' ); ?>
				
				</div>
				</div>
				</div>
				<?php do_action( 'woocommerce_after_cart' ); ?>				