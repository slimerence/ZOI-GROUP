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
}
if(is_home()){
	$image_default = '';
	$jws_theme_blog_crop_image = 0;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="tb-blog-gallery">
        <?php
        $date = time() . '_' . uniqid(true);
        $gallery_ids = jws_theme_theme_grab_ids_from_gallery()->ids;
        if(!empty($gallery_ids)):
        ?>
            <div id="carousel-generic<?php echo wp_kses_post($date); ?>" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
					<?php
					$i = 0;
					foreach ($gallery_ids as $image_id){
						$attachment_image = wp_get_attachment_image_src($image_id, 'full', false);
						if($attachment_image[0]){
							if($jws_theme_blog_crop_image){
								$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_blog_image_width, $jws_theme_blog_image_height, true, false );
								?>
								<div class="item tb-blog-gallery <?php echo wp_kses_post($i==0?'active':''); ?>">
									<img style="width:100%;" class="bt-image-cropped" src="<?php echo esc_attr($image_resize['url']); ?>" alt="">
								</div>
								<?php
							}else{
								?>
								<div class="item tb-blog-gallery <?php echo wp_kses_post($i==0?'active':''); ?>">
									<img style="width:100%;" src="<?php echo esc_url($attachment_image[0]);?>" alt="" />
								</div>
								<?php
							}
							$i++;
						}else{
							if(has_post_thumbnail()){
								$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
								if($jws_theme_blog_crop_image){
									$image_resize = matthewruddy_image_resize( $attachment_image[0], $jws_theme_blog_image_width, $jws_theme_blog_image_height, true, false );
									echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
								}else{
									the_post_thumbnail();
								}
							}else{
								if($image_default['url']){
									if($jws_theme_blog_crop_image){
										$image_resize = matthewruddy_image_resize( $image_default['url'], $jws_theme_blog_image_width, $jws_theme_blog_image_height, true, false );
										echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
									}else{
										echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
									}
								}
							}
						}
					}
					?>
                </div>
                <a class="left carousel-control" href="#carousel-generic<?php echo wp_kses_post($date); ?>" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left ion-ios7-arrow-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-generic<?php echo wp_kses_post($date); ?>" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right ion-ios7-arrow-right"></span>
                </a>
            </div>
        <?php elseif (has_post_thumbnail() && ! post_password_required() && ! is_attachment()): ?>
            <div class="tb-blog-image">
                <?php the_post_thumbnail(); ?>
            </div>
        <?php endif; ?>
    </div>
	<div class="tb_blog_content">
		<?php echo jws_theme_date_render(); ?>
		<div class="tb-info-block">
				
			<?php
			 echo jws_theme_post_cate();
			 if($jws_theme_show_post_title) echo jws_theme_title_render();
			 if($jws_theme_show_post_info) echo jws_theme_info_bar_render();
			 ?>
		</div>
		
		
		<div style="clear: both"></div>
		<?php if(is_single() && $jws_theme_post_show_social_share) echo jws_theme_social_share_post_render(); ?>
		<?php if(is_single() && $jws_theme_post_show_post_tags) echo jws_theme_tags_render(); ?>
		<?php if(is_single() && $jws_theme_post_show_post_author) echo jws_theme_author_render(); ?>
		<?php if($jws_theme_show_post_desc) echo jws_theme_content_render(); ?>
	</div>
</article>

