<?php global $product;
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$show_sale_flash = (int) isset( $show_sale_flash ) ? $show_sale_flash : $jws_theme_options['jws_theme_archive_show_sale_flash_product'];
	$show_quick_view = (int) isset( $show_quick_view ) ? $show_quick_view : $jws_theme_options['jws_theme_archive_show_quick_view_product'];
	$show_rating = (int) isset( $show_rating ) ? $show_rating : $jws_theme_options['jws_theme_archive_show_rating_product'];
	$show_add_to_cart = (int) isset( $show_add_to_cart ) ? $show_add_to_cart : $jws_theme_options['jws_theme_archive_show_add_to_cart_product'];
	$show_whishlist = (int) isset( $show_whishlist ) ? $show_whishlist : $jws_theme_options['jws_theme_archive_show_whishlist_product'];
	$show_compare = (int) isset( $show_compare ) ? $show_compare : $jws_theme_options['jws_theme_archive_show_compare_product'];
	$show_title = (int) isset( $show_title ) ? $show_title : $jws_theme_options['jws_theme_archive_show_title_product'];
	$show_price = (int) isset( $show_price ) ? $show_price : $jws_theme_options['jws_theme_archive_show_price_product'];
	$show_cat = (int) isset( $show_cat ) ? $show_cat : $jws_theme_options['jws_theme_archive_show_cat_product'];
	$show_color_attr = (int) isset( $show_color_attr ) ? $show_color_attr : $jws_theme_options['jws_theme_archive_show_color_attribute'];
?>
<div <?php post_class(); ?>>
							
	<div class="tb-product-item-inner">
		
		<div class="tb-image">
			<?php if( $show_sale_flash ) do_action( 'woocommerce_show_product_loop_sale_flash' ); ?>
			<?php
				$postDate = strtotime( get_the_date('j F Y') );
				$todaysDate = time() - (7 * 86400);// publish < current time 1 week
				if( $postDate >= $todaysDate) echo '<span class="new">'. esc_html__('New', 'eduonline') .'</span>';
				$att_ids = $product->get_gallery_attachment_ids();
				$exist_thumb = ! empty( $att_ids );
				if( $exist_thumb ){
					?>
					<a href="<?php the_permalink(); ?>" class="tb-thumb-effect" data-tb-thumb="true">
						<?php do_action( 'woocommerce_template_loop_product_thumbnail' ); ?>
						<span>
							<img src="<?php echo esc_url( wp_get_attachment_image_src( array_shift( $att_ids ),'full' )[0] );?>" alt="<?php the_title();?>">
						</span>
						<?php if( $show_color_attr ):
						$color_atts = wc_get_product_terms( $product->id, 'pa_color', array( 'fields' => 'names' ) );
						if( ! empty( $color_atts ) ):
						?>
						<ul class="list-inline text-center tb-color-attribute">
							<?php foreach( $color_atts as $color ):
								$color = esc_attr( strtolower( $color ) );
							?>
								<li class="tb-attribute-<?php echo $color;?>"><?php echo $color;?></li>
							<?php endforeach; ?>
						</ul>
						<?php endif; endif ?>
					</a>
					<?php
				}else{
					?>
					<a class="tb-normal-effect" href="<?php the_permalink(); ?>">
						<img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' )[0]; ?>" alt="large thumbnail" />
					</a>
					<?php
				}
			?>

		</div>
		
		<div class="tb-content">
			<div class="tb-header-content">
				<?php if( $show_cat ): ?>
					<div class="row">
						<div class="col-xs-6">
							<div class="tb-category"><?php the_terms( get_the_ID(), 'product_cat', '', ', ');?></div>
						</div>
						<div class="col-xs-6">
				<?php endif;?>
							<div class="tb-action<?php if( !$show_cat ) echo ' tb-hidden-cat';?>">
								<?php if( $show_quick_view ): ?>
								<div class="tb-product-btn tb-btn-quickview">
									<div data-toggle="tooltip" data-placement="top" title="<?php _e('Quick view','eduonline');?>">
										<?php jws_theme_add_quick_view_button(); ?>
									</div>
								</div>
								<?php
									endif;
									if( $show_whishlist ):
										if( function_exists('YITH_WCWL') ):
											$wishlist_text = YITH_WCWL()->is_product_in_wishlist( get_the_ID() ) ? __(' Browse Wishlist','eduonline') : __('Add To Wishlist', 'eduonline');
								 ?>
								<div class="tb-product-btn tb-btn-wishlist">
									<div data-toggle="tooltip" data-placement="top" title="<?php echo $wishlist_text;?>">
										<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]');?>
									</div>
								</div>
								<?php
										endif;
									endif;
									if( $show_compare ):
								?>
								<div class="tb-product-btn tb-btn-compare">
									<div data-toggle="tooltip" data-placement="top" title="<?php _e('Add To Compare','eduonline');?>">
										<?php jws_theme_add_compare_link();?>
									</div>
								</div>
								<?php
									endif;
									if( $show_add_to_cart ):
								?>

								<div class="tb-product-btn tb-btn-tocart">
									<div data-toggle="tooltip" data-placement="top" title="<?php echo esc_html( $product->add_to_cart_text()); ?>">
										<?php do_action( 'woocommerce_template_loop_add_to_cart' ); ?>
									</div>
								</div>
								<?php endif; ?>
							</div>
				<?php if( $show_cat ):?>
						</div>
					</div>
				<?php endif;?>
			</div>
			<div class="tb-footer-content">
				<?php if( $show_title ): ?>
				<div class="tb-title text-ellipsis"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
				<?php endif; ?>
				<div class="tb-price-rating">
					<?php

						if( $show_rating ) do_action( 'woocommerce_template_loop_rating' );
						if( $show_price ) do_action( 'woocommerce_template_loop_price' );
					?>
				</div>
			</div>
			
		</div>
	</div>
	
</div>