<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if($show_date) { ?>
		<div class="tb-info clases-hidden-sm">
			<?php echo jws_theme_class_info_bar_render(); ?>
		</div>
	<?php } ?>
	<div class="tb-classes-content">
    <?php if (has_post_thumbnail()) { ?>
        <div class="tb-blog-image">
            <?php
			$image_full = '';
			$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
			$image_full = $attachment_image[0];
			if($crop_image){
				$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
				echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
			}else{
				the_post_thumbnail();
			}
			?>
			<div class="colorbox-wrap">
				<div class="colorbox-inner">
					<?php if($show_popup) : ?><a class="cb-popup view-image" title="<?php the_title() ?>" href="<?php echo esc_url($image_full); ?>">
						<i class="fa fa-plus"></i>
					</a>
					<?php endif ?>
				</div>
			</div>
        </div>
    <?php } ?>
	<div class="tb-content <?php if($post_type == 'classes') echo 'text-center'; ?>">
		
		<?php if($show_title) { ?>
			<a href="<?php the_permalink(); ?>"><h4 class="tb-title"><?php the_title(); ?></h4></a>
		<?php } ?>
		<?php if($show_cate) { ?>
		<div class="tb-cate">
			<?php 
				$terms = get_the_terms( get_the_ID(), $taxonomy );
                         
				if ( $terms && ! is_wp_error( $terms ) ) : 
				 
					$cate_item = array();
					foreach ( $terms as $term ) {
						$cate_item[] = sprintf(wp_kses_post(__('<a href="%1$s">%2$s</a>'),'prechool'), esc_url( get_term_link( $term->slug, $taxonomy ) ), esc_html( $term->name )) ;
					}
										 
					$on_draught = join( ", ", $cate_item );
					echo join( ", ", $cate_item );
				endif;
			 ?>
		</div>
		<?php } ?>
		
		<?php if($show_excerpt) { ?>
			<div class="tb-excerpt">
				<?php echo jws_theme_custom_excerpt( intval( $excerpt_length ), $excerpt_more); ?>
			</div>
		<?php } ?>
		<?php if( !empty( $readmore_text ) ) { ?>
			<a class="tb-readmore<?php if( $readmore_block ) echo ' block';?>" href="<?php the_permalink(); ?>"><?php echo esc_attr( $readmore_text ); ?></a>
		<?php } ?>
		<hr>
		<?php if($show_info) { ?>
		<ul class="jws_info">
			<?php 
				$year_olds = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_year_olds', true) );
				$class_size = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_classes_size', true) );
				$member = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_member_hours', true) );
			?>
			<li><?php echo esc_html__('Year olds','prechool'); ?> <span><?php echo $year_olds; ?></span></li>
			<li><?php echo esc_html__('Class size','eduonline'); ?><span><?php echo $class_size; ?></span></li>
			<li><span><?php echo $member; ?></span></li>
		</ul>
		<?php } ?>
		
	</div>
	</div>
</article>
