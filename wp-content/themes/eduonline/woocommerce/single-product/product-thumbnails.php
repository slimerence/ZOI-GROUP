<?php
/**
 * Single Product Thumbnails
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.6.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

if ( $attachment_ids ) {
	?>
	<div class="ro-product-option-wrapper">
		<div id="Ro_gallery_0" class="ro-product-option"><?php
			
			foreach ( $attachment_ids as $attachment_id ) {

				$image_link = wp_get_attachment_url( $attachment_id );

				if ( ! $image_link )
					continue;

				$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'thumbnail' ) );
				
				echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<a href="#" data-image="%s" data-zoom-image="%s">%s</a>', $image_link, $image_link, $image ), $attachment_id, $post->ID );

			}

		?></div>
	</div>
	<?php
}
