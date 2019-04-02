<?php
/**
 * Loop Rating
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post;

if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' )
	return;
$review_count = $product->get_review_count();
?>
<?php if ( $rating_html = $product->get_rating_html() ) : ?>
	<div class="tb-item-rating primary_color clearfix">
		<?php echo do_shortcode( $rating_html ); ?>
		<?php if ( isset( $post->comment_status ) && $post->comment_status ) : ?><a href="<?php echo esc_url( get_permalink( $product->ID ) ) ?>#tab-reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s Review (s)', '%s Review (s)', $review_count, 'eduonline' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' ); ?></a><?php endif ?>
	</div>
<?php elseif ( $rating_html = $product->get_rating_html(5) ) : ?>
	<div class="tb-item-rating primary_color clearfix">
		<?php echo do_shortcode( $rating_html ); ?>
		<?php if ( isset( $post->comment_status ) && $post->comment_status ) : ?><a href="<?php echo esc_url( get_permalink( $product->ID ) ) ?>#tab-reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s Review (s)', '%s Review (s)', $review_count, 'eduonline' ), '<span itemprop="reviewCount" class="count">' . $review_count . '</span>' ); ?></a><?php endif ?>
	</div>
<?php endif; ?>