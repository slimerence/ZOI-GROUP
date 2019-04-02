<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );


if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

$jws_theme_cols = $columns === 4 ? 'col-md-3 col-sm-6 col-xs-12' : 'col-md-4 col-sm-6 col-xs-12';

if ( $products->have_posts() ) : ?>

	<div class="products ro-product-relate">
		<div class="ro-title text-center"><h4><?php _e( 'Related Products', 'eduonline' ); ?></h4></div>
		<div class="woocommerce tb-product-carousel tb-product-carousel4">
				<div class="owl-carousel tb-products-grid">
					<?php while ( $products->have_posts() ) : $products->the_post(); ?>
						<div class="pd-item">
							<?php wc_get_template('loop/loop-content-shortcode.php'); ?>
						</div>
					<?php endwhile; wp_reset_postdata();
 // end of the loop. ?>
			
				</div>
		</div>
	</div>

<?php endif;
