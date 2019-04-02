<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;
$jws_theme_options = $GLOBALS['jws_theme_options'];
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="ro-product-wrapper">
		<?php do_action( 'woocommerce_before_single_product_summary' );?>
	</div>

	<div class="ro-product-wrapper col-sm-6 col-xs-12">
		<div class="entry-summary ro-product-information">

			<?php if($jws_theme_options['jws_theme_single_show_title_product']) do_action( 'woocommerce_template_single_title' ); ?>
			
			<?php if($jws_theme_options['jws_theme_single_show_rating_product']) do_action( 'woocommerce_template_single_rating' ); ?>
			
			<div class="ro-product-price-meta">
				<?php if($jws_theme_options['jws_theme_single_show_price_product']) do_action( 'woocommerce_template_single_price' ); ?>
				
				<?php 
					if ( $product->is_in_stock() ) {
						echo '<div class="stock" >' . __(' Avaiability: ', 'eduonline' ) . $product->get_stock_quantity() . '<span>' . __( ' in stock', 'eduonline' ) . '</span></div>';
					} else {
						echo '<div class="out-of-stock" >' . __( 'out of stock', 'eduonline' ) . '</div>';
					}
				?>
				
			</div>
			
			<div class="ro-product-content">
				<?php if($jws_theme_options['jws_theme_single_show_excerpt']) the_content(); ?>
			</div>
			
			<?php if($jws_theme_options['jws_theme_single_show_add_to_cart_product']) do_action( 'woocommerce_template_single_add_to_cart' ); ?>
			
			<?php
				do_action('woocommerce_template_single_sharing');
			?>
		
		</div><!-- .summary -->
	</div>
	<div class="row">	
	<?php if($jws_theme_options['jws_theme_single_show_data_tabs']) do_action( 'woocommerce_output_product_data_tabs' ); ?>
	</div>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
