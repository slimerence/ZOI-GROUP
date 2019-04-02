<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
$jws_theme_options = $GLOBALS['jws_theme_options'];
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0; 

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

$start_row = $end_row = $woo_columns = '';

// Extra post classes
$classes = array();

$is_full_wid = jws_theme_get_op_full_wid();
if( isset( $_GET['columns'] ) ){
	$woocommerce_loop['columns'] = intval( $_GET['columns'] );
}else{
	
	if( $is_full_wid  ){
		$woocommerce_loop['columns'] = isset( $jws_theme_options['jws_theme_archive_shop_ful_column'] ) ?  (int)$jws_theme_options['jws_theme_archive_shop_ful_column'] : 4;
	}elseif ( empty( $woocommerce_loop['columns'] ) ) {
		$columns = isset( $jws_theme_options['jws_theme_archive_shop_column'] ) ?  (int)$jws_theme_options['jws_theme_archive_shop_column'] : 4;
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', $columns );
	}
}

// if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ){
//     $classes[] = 'first';
//     $start_row = 1;
// }

// if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ){
//     $classes[] = 'last';
//     $end_row = 1;
// }

$classes[] = 'tb-product-items';

?>
<?php
	if($woocommerce_loop['columns'] == 5){
		$woo_columns = "tb-products-grid tb-woo-five-column col-lg-20 col-md-3 col-sm-6 col-xs-12";
	}elseif($woocommerce_loop['columns'] == 4){
		$woo_columns = "tb-products-grid tb-woo-four-column col-lg-3 col-md-4 col-sm-6 col-xs-12";
	}elseif($woocommerce_loop['columns'] == 3){
		$woo_columns = "tb-products-grid tb-woo-three-column col-lg-4 col-md-6 col-sm-6 col-xs-12";
	}elseif($woocommerce_loop['columns'] == 2){
		$woo_columns = "tb-products-grid tb-woo-three-column col-lg-6 col-md-6 col-sm-6 col-xs-12";
	}else{
		$woo_columns = "tb-woo-one-column col-xs-12";
	}

?>
<div class="tb-product-item <?php echo esc_attr($woo_columns); ?>">
	<?php ( $woocommerce_loop['columns'] == 1) ? wc_get_template('loop/loop-content-one.php') : wc_get_template('loop/loop-content-shortcode.php'); ?>
</div>