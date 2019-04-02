<?php
global $tb_options;
$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail() || $image_default) { ?>
        <div class="tb-blog-image">
            <?php
			$image_full = '';
			if(has_post_thumbnail()){
				$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
				$image_full = $attachment_image[0];
				if($crop_image){
					$image_resize = matthewruddy_image_resize( $attachment_image[0], $width_image, $height_image, true, false );
					echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
				}else{
					the_post_thumbnail();
				}
			}else{
				if($image_default['url']){
					$image_full = $image_default['url'];
					if($tb_blog_crop_image){
						$image_resize = matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false );
						echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
					}else{
						echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
					}
				}
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
	<div class="tb_blog_content">
	<?php if($show_date){
		echo jws_theme_date_render();
	}?>
	<div class="tb-info-block">
		
		<?php
		 echo jws_theme_post_cate();
		if($show_title) echo jws_theme_title_render(); 
		if($show_info) echo jws_theme_info_bar_render(); ?>
	</div>
	<?php if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
	</div>
</article>