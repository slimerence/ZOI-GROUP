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
		
		<div class="tb-product-items">
			<!--
			<div id="carousel-related" class="tb-carousel" data-paginationspeed="700" data-items="4" data-paginationnumbers="false" data-pagination="true" data-scrollperpage="false" data-navigation="true" data-stoponhover="true" data-autoplay="false" data-itemsscaleup="false" data-singleitem="true" >
			-->
			<div class="row">
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
					<div class="<?php echo $jws_theme_cols; ?>">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							
							<div class="tb-product-item">
								
								<div class="tb-image">
									<?php do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
									<?php
										$postDate = strtotime( get_the_date('j F Y') );
										$todaysDate = time() - (7 * 86400);// publish < current time 1 week
										if ( $postDate >= $todaysDate) echo '<span class="new">'.esc_html__('New', 'eduonline').'</span>';
									?>
									<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
									<div class="tb-action">
										<div class="tb-btn-prod tb-btn-quickview">
											<div data-toggle="tooltip" data-placement="right" title="<?php _e('Quick view','eduonline');?>">
												<?php jws_theme_add_quick_view_button(); ?>
											</div>
										</div>
										<?php
											if( function_exists('YITH_WCWL') ):
												$wishlist_text = YITH_WCWL()->is_product_in_wishlist( get_the_ID() ) ? __(' Browse Wishlist','eduonline') : __('Add To Wishlist', 'eduonline');
										 ?>
										<div class="tb-btn-prod tb-btn-wishlist">
											<div data-toggle="tooltip" data-placement="right" title="<?php echo $wishlist_text;?>">
												<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]');?>
											</div>
										</div>
										<?php endif; ?>
										<div class="tb-btn-prod tb-btn-compare">
											<div data-toggle="tooltip" data-placement="right" title="<?php _e('Add To Compare','eduonline');?>">
												<?php jws_theme_add_compare_link();?>
											</div>
										</div>
										<div class="tb-btn-prod tb-btn-tocart">
											<div data-toggle="tooltip" data-placement="right" title="<?php _e('Add To Cart','eduonline');?>">
													<?php do_action( 'woocommerce_template_loop_add_to_cart' ); ?>
											</div>
										</div>
									</div>
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
					</div>
				<?php endwhile; // end of the loop. ?>
			
			</div>
			
		</div>
	</div>

<?php endif;

wp_reset_postdata();
