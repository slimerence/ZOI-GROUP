<?php
global $tb_options;
$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="tb-blog-image">
		<?php
		$image_full = '';
		if(has_post_thumbnail()){
			the_post_thumbnail('eduonline-blog-medium');
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
	</div>
	<div class="tb_blog_content">
		<?php if($show_date){
			echo jws_theme_date_render();
		}?>
		<div class="tb-info-block">
			
			<?php
			
			if($show_title) echo jws_theme_title_render(); ?>
			<?php if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
			
			<div class="tb-info-footer">
				<span class="author-name"><?php esc_html_e('By ', 'eduonline'); the_author_posts_link(); ?></span>
				<span class="tb-cate" ><?php echo jws_theme_post_cate(); ?></span>
			
			</div>
		</div>
		<div style="clear: both"></div>
	</div>
</article>