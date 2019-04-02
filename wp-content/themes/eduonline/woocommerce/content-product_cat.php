<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}
if( $woocommerce_loop['columns'] < 4){
	add_filter('single_product_small_thumbnail_size', 'jws_theme_custom_cat_thumbnail', 10, 1);
}
$class_columns = '';
switch ($woocommerce_loop['columns']) {
	case 1:
		$class_columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
		break;
	case 2:
		$class_columns = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
		break;
	case 3:
		$class_columns = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
		break;
	case 4:
		$class_columns = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
		break;
	default:
		$class_columns = 'col-xs-12 col-sm-6 col-md-3 col-lg-3';
		break;
}

// Increase loop count
$woocommerce_loop['loop'] ++;
// enable slider
$class_columns = 'col-xs-12';
?>
<div class="<?php echo esc_attr($class_columns); ?>" <?php //wc_product_cat_class(); ?>>
	<div class="tb-item-category">
		<?php do_action( 'woocommerce_before_subcategory', $category ); ?>

			<div class="tb-thumb">
				<?php
					/**
					 * woocommerce_before_subcategory_title hook
					 *
					 * @hooked woocommerce_subcategory_thumbnail - 10
					 */
					do_action( 'woocommerce_before_subcategory_title', $category );
				?>
			</div>
			<div class="tb-title">
				<h3>
				<?php
					echo $category->name;

					if ( $category->count > 0 )
						echo apply_filters( 'woocommerce_subcategory_count_html', sprintf( __('<small class="count">( %d Products )</small>', 'eduonline' ), $category->count ), $category );
				?>
				</h3>
			</div>

			<?php
				/**
				 * woocommerce_after_subcategory_title hook
				 */
				do_action( 'woocommerce_after_subcategory_title', $category );
			?>

		<?php do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</div>
