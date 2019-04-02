<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) {
	return;
}

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$tb_cols = $posts_per_page === 4 ? 'col-md-3 col-sm-6 col-xs-12' : 'col-md-4 col-sm-6 col-xs-12';

if ( $products->have_posts() ) : ?>

	<div class="upsellss products">
		<div class="eduonline-title-separator-wrap text-center eduonline-title-underline-2">
            <h3 class="eduonline-title-separator eduonline-title text-center"><span><?php esc_html_e( 'Upsell Products', 'woocommerce' ) ?></span></h3>
        </div>
		<div class="woocommerce tb-product-carousel tb-product-carousel3">
			<div class="owl-carousel tb-products-grid">

				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<div class="pd-item">
						<?php wc_get_template('loop/loop-content-shortcode.php'); ?>
					</div>
				<?php endwhile;wp_reset_postdata(); // end of the loop. ?>
			</div>
		</div>

	</div>

<?php endif;?>
