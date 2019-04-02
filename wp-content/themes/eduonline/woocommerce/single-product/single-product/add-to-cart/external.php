<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

<p class="cart">
	<a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button ro-btn-1 alt"><?php echo esc_attr($button_text); ?></a>
	<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
	<?php jws_theme_add_compare_link(); ?>
	<a class="ro-btn-circle tb-send-mail" href="#jws_theme_send_mail">
		<i class="fa fa-envelope"></i>
	</a>
</p>

<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>