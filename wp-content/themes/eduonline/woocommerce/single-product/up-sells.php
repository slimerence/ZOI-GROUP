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

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="upsells products widget">

		<h3 class="wg-title"><?php _e( 'Upsell Products', 'woocommerce' ) ?></h3>

		<?php //woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php //wc_get_template_part( 'content', 'product' ); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								
					<div class="tb-product-item">
						
						<div class="tb-image">
							<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
						</div>
						
						<div class="tb-content">
							
							<div class="tb-title text-ellipsis"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
							
							<div class="tb-price-rating">
								<?php
									do_action( 'woocommerce_template_loop_rating' );
									do_action( 'woocommerce_template_loop_price' ); 
								?>
							</div>
							
						</div>
					</div>
					
				</article>


			<?php endwhile;wp_reset_postdata(); // end of the loop. ?>

		<?php //woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();
