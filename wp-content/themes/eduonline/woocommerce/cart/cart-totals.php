<?php
/**
 * Cart totals
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     9.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() ) echo 'calculated_shipping'; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <div class="cart-total-table">
        <table cellspacing="0">

            <tr class="cart-subtotal">
                <th><?php esc_html_e( 'Subtotal:', 'eduonline' ); ?></th>
                <td><?php wc_cart_totals_subtotal_html(); ?></td>
            </tr>

            <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
                <tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
                    <th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
                    <td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
                <tr class="fee">
                    <th><?php echo esc_html( $fee->name ); ?></th>
                    <td><?php wc_cart_totals_fee_html( $fee ); ?></td>
                </tr>
            <?php endforeach; ?>

            <?php if ( WC()->cart->tax_display_cart == 'excl' ) : ?>
                <?php if ( get_option( 'woocommerce_tax_total_display' ) == 'itemized' ) : ?>
                    <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                        <tr class="tax-rate tax-rate-<?php echo sanitize_title( $code ); ?>">
                            <th><?php echo esc_html( $tax->label ); ?></th>
                            <td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr class="tax-total">
                        <th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
                        <td><?php echo wc_cart_totals_taxes_total_html(); ?></td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>

            <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

            <tr class="order-total">
                <th><?php esc_html_e( 'Total:', 'eduonline' ); ?></th>
                <td><?php wc_cart_totals_order_total_html(); ?></td>
            </tr>

            <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

        </table>

        <?php if ( WC()->cart->get_cart_tax() ) : ?>
            <p><small><?php

                $estimated_text = WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping()
                    ? sprintf( ' ' . esc_html__( ' (taxes estimated for %s)', 'eduonline' ), WC()->countries->estimated_for_prefix() . WC()->countries->countries[ WC()->countries->get_base_country() ] )
                    : '';

                printf( esc_html__( 'Note: Shipping and taxes are estimated%s and will be updated during checkout based on your billing and shipping information.', 'eduonline' ), $estimated_text );

            ?></small></p>
        <?php endif; ?>

        <div class="wc-proceed-to-checkout">
			
			<p class="return-to-shop"><a class="button wc-backward" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>"><?php _e( 'Continue Shopping', 'woocommerce' ) ?></a></p>
			
            <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>

        </div>

        <?php do_action( 'woocommerce_after_cart_totals' ); ?>

    </div>

</div>
