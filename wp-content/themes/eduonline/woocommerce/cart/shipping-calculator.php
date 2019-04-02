<?php
/**
 * Shipping Calculator
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( get_option( 'woocommerce_enable_shipping_calc' ) === 'no' || ! WC()->cart->needs_shipping() ) {
	return;
}

?>

<?php do_action( 'woocommerce_before_shipping_calculator' ); ?>

<form class="woocommerce-shipping-calculator" action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

	<div class="tb-form-calculator-title"><?php esc_html_e('Enter your destination to get a shipping estimate', 'eduonline')?></div>
	<section class="form-shipping-calculator">

		<p class="form-row form-row-wide" id="calc_shipping_country_field">
            <label for="calc_shipping_country"><?php esc_html_e('Country', 'eduonline'); ?> <span class="required"><?php esc_html_e('*', 'eduonline'); ?></span></label>
			<select name="calc_shipping_country" id="calc_shipping_country" class="country_to_state" rel="calc_shipping_state">
				<option value=""><?php esc_html_e( 'Select a country&hellip;', 'eduonline' ); ?></option>
				<?php
					foreach( WC()->countries->get_shipping_countries() as $key => $value )
						echo '<option value="' . esc_attr( $key ) . '"' . selected( WC()->customer->get_shipping_country(), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				?>
			</select>
		</p>

		<p class="form-row form-row-wide" id="calc_shipping_state_field">
			<?php
				$current_cc = WC()->customer->get_shipping_country();
				$current_r  = WC()->customer->get_shipping_state();
				$states     = WC()->countries->get_states( $current_cc );

				// Hidden Input
				if ( is_array( $states ) && empty( $states ) ) {

					?>
                    <label for="calc_shipping_state"><?php esc_html_e('State / Province', 'eduonline'); ?></label>
                    <input type="hidden" name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / county', 'eduonline' ); ?>" />
                    <?php

				// Dropdown Input
				} elseif ( is_array( $states ) ) {

					?><span>
                        <label for="calc_shipping_state"><?php esc_html_e('State / Province', 'eduonline'); ?>  <span class="required"><?php esc_html_e('*', 'eduonline'); ?></span></label>
						<select name="calc_shipping_state" id="calc_shipping_state" placeholder="<?php esc_html_e( 'State / Province', 'eduonline' ); ?>">
							<option value=""><?php esc_html_e( 'Select a state&hellip;', 'eduonline' ); ?></option>
							<?php
								foreach ( $states as $ckey => $cvalue )
									echo '<option value="' . esc_attr( $ckey ) . '" ' . selected( $current_r, $ckey, false ) . '>' . esc_html( $cvalue ) .'</option>';
							?>
						</select>
					</span><?php

				// Standard Input
				} else {

					?>
                    <label for="calc_shipping_state"><?php esc_html_e('State / Province', 'eduonline'); ?> <span class="required"><?php esc_html_e('*', 'eduonline'); ?></span></label>
                    <input type="text" class="input-text" value="<?php echo esc_attr( $current_r ); ?>" placeholder="<?php esc_html_e( 'State / Province', 'eduonline' ); ?>" name="calc_shipping_state" id="calc_shipping_state" />
                <?php

				}
			?>
		</p>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_city', false ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_city_field">
                <label for="calc_shipping_city"><?php esc_html_e('City', 'eduonline'); ?> <span class="required"><?php esc_html_e('*', 'eduonline'); ?></span></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_city() ); ?>" placeholder="<?php esc_html_e( 'City', 'eduonline' ); ?>" name="calc_shipping_city" id="calc_shipping_city" />
			</p>

		<?php endif; ?>

		<?php if ( apply_filters( 'woocommerce_shipping_calculator_enable_postcode', true ) ) : ?>

			<p class="form-row form-row-wide" id="calc_shipping_postcode_field">
                <label for="calc_shipping_postcode"><?php esc_html_e('Post Code', 'eduonline'); ?> <span class="required"><?php esc_html_e('*', 'eduonline'); ?></span></label>
				<input type="text" class="input-text" value="<?php echo esc_attr( WC()->customer->get_shipping_postcode() ); ?>" placeholder="<?php esc_html_e( '1234567', 'eduonline' ); ?>" name="calc_shipping_postcode" id="calc_shipping_postcode" />
			</p>

		<?php endif; ?>

		<p><button type="submit" name="calc_shipping" value="1" class="button"><?php esc_html_e( 'Get Quotes', 'eduonline' ); ?></button></p>

		<?php wp_nonce_field( 'woocommerce-cart' ); ?>
	</section>
</form>

<?php do_action( 'woocommerce_after_shipping_calculator' ); ?>
