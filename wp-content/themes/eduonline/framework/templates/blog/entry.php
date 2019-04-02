<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
$image_default = isset($jws_theme_options['jws_theme_blog_image_default']) ? $jws_theme_options['jws_theme_blog_image_default'] : '';
if(is_home()){
	$jws_theme_show_post_title = 1;
	$jws_theme_show_post_desc = 1;
	$jws_theme_show_post_info = 1;
}elseif (is_single()) {
	$jws_theme_blog_crop_image = isset($jws_theme_options['jws_theme_post_crop_image']) ? $jws_theme_options['jws_theme_post_crop_image'] : 0;
	$jws_theme_blog_image_width = (int) isset($jws_theme_options['jws_theme_post_image_width']) ? $jws_theme_options['jws_theme_post_image_width'] : 800;
	$jws_theme_blog_image_height = (int) isset($jws_theme_options['jws_theme_post_image_height']) ? $jws_theme_options['jws_theme_post_image_height'] : 400;
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_post_show_post_title']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_post_show_post_info']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_post_show_social_share = (int) isset($jws_theme_options['jws_theme_post_show_social_share']) ? $jws_theme_options['jws_theme_post_show_social_share'] : 1;
	$jws_theme_post_show_post_tags = (int) isset($jws_theme_options['jws_theme_post_show_post_tags']) ? $jws_theme_options['jws_theme_post_show_post_tags'] : 1;
	$jws_theme_post_show_post_author = (int) isset($jws_theme_options['jws_theme_post_show_post_author']) ? $jws_theme_options['jws_theme_post_show_post_author'] : 1;
	$jws_theme_show_post_desc = 1;
}else{
	$jws_theme_blog_crop_image = isset($jws_theme_options['jws_theme_blog_crop_image']) ? $jws_theme_options['jws_theme_blog_crop_image'] : 0;
	$jws_theme_blog_image_width = (int) isset($jws_theme_options['jws_theme_blog_image_width']) ? $jws_theme_options['jws_theme_blog_image_width'] : 600;
	$jws_theme_blog_image_height = (int) isset($jws_theme_options['jws_theme_blog_image_height']) ? $jws_theme_options['jws_theme_blog_image_height'] : 400;
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_blog_show_post_title']) ? $jws_theme_options['jws_theme_blog_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_blog_show_post_info']) ? $jws_theme_options['jws_theme_blog_show_post_title'] : 1;
	$jws_theme_show_post_desc = (int) isset($jws_theme_options['jws_theme_blog_show_post_desc']) ? $jws_theme_options['jws_theme_blog_show_post_desc'] : 1;
	$jws_theme_blog_post_excerpt_leng = (int) isset($jws_theme_options['jws_theme_blog_post_excerpt_leng']) ? $jws_theme_options['jws_theme_blog_post_excerpt_leng'] : 25;
	$jws_theme_blog_post_excerpt_more = isset($jws_theme_options['jws_theme_blog_post_excerpt_more']) ? $jws_theme_options['jws_theme_blog_post_excerpt_more'] : __('...','eduonline');
	$jws_theme_blog_post_excerpt_more = esc_attr( $jws_theme_blog_post_excerpt_more );
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="tb-blog-image">
		<?php
		$image_full = '';
		if(has_post_thumbnail()){
			the_post_thumbnail('eduonline-blog-medium');
		}
		?>
	</div>
	<div class="tb_blog_content">
		<?php if($jws_theme_show_post_info){
			echo jws_theme_date_render();
		}?>
		<div class="tb-info-block">
			
			<?php
			if($jws_theme_show_post_title) echo jws_theme_title_render(); ?>
			<?php if($jws_theme_show_post_desc) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($jws_theme_blog_post_excerpt_leng , $jws_theme_blog_post_excerpt_more).'</div>'; ?>
			
			<div class="tb-info-footer">
				<span class="author-name"><?php esc_html_e('By ', 'eduonline'); the_author_posts_link(); ?></span>
				<span class="tb-cate" ><?php echo jws_theme_post_cate(); ?></span>
			
			</div>
		</div>
		<div style="clear: both"></div>
	</div>
</article>