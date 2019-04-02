<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;
	//product hot
	$featured_value = get_post_meta( $product->id, '_featured', true );
	if ( $featured_value == 'yes' ) {
		echo '<span class="onsale hot">'.__('Hot', 'venus').'</span>';
	} else {
		//product discount
		if ( $product->is_on_sale() && $product->product_type == 'simple' ) {
			$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
			echo '<span class="onsale"> - '.$percentage.'%</span>';
		}
		//product sale
		if ( ($product->is_on_sale() && $product->product_type == 'variable') || ($product->is_on_sale() && $product->product_type == 'external') ) {
			echo '<span class="onsale sale_variable">'.__('Sale', 'venus').'</span>';
		}
	}
?>