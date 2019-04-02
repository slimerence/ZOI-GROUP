<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
if(is_home()){
	$jws_theme_show_post_title = 1;
	$jws_theme_show_post_desc = 1;
	$jws_theme_show_post_info = 1;
}elseif (is_single()) {
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_post_show_post_title']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_post_show_post_info']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_post_show_social_share = (int) isset($jws_theme_options['jws_theme_post_show_social_share']) ? $jws_theme_options['jws_theme_post_show_social_share'] : 1;
	$jws_theme_post_show_post_tags = (int) isset($jws_theme_options['jws_theme_post_show_post_tags']) ? $jws_theme_options['jws_theme_post_show_post_tags'] : 1;
	$jws_theme_post_show_post_author = (int) isset($jws_theme_options['jws_theme_post_show_post_author']) ? $jws_theme_options['jws_theme_post_show_post_author'] : 1;
	$jws_theme_show_post_desc = 1;
}else{
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_blog_show_post_title']) ? $jws_theme_options['jws_theme_blog_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_blog_show_post_info']) ? $jws_theme_options['jws_theme_blog_show_post_title'] : 1;
	$jws_theme_show_post_desc = (int) isset($jws_theme_options['jws_theme_blog_show_post_desc']) ? $jws_theme_options['jws_theme_blog_show_post_desc'] : 1;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="tb-blog-video">
            <?php
			if(!is_home()){
				$video_source = get_post_meta(get_the_ID(), 'jws_theme_post_video_source', true);
				if(empty($video_source)) $video_source = 'post';
				$video_height = get_post_meta(get_the_ID(), 'jws_theme_post_video_height', true);
				if(is_single() || is_archive()){
				$video_height = $video_height * 2;
				}
				switch ($video_source) {
					case 'post':
						$shortcode = jws_theme_theme_get_shortcode_from_content('wpvideo');
						if(!$shortcode){
							the_content();
						}
						if($shortcode):
							echo do_shortcode('[wpvideo tFnqC9XQ w=680]');
						endif;
						break;
					case 'youtube':
						$video_youtube = get_post_meta(get_the_ID(), 'jws_theme_post_video_youtube', true);
						if($video_youtube){
							echo do_shortcode('[video_post height="'.$video_height.'"]'.$video_youtube.'[/video_post]');
						}
						break;
					case 'vimeo':
						$video_vimeo = get_post_meta(get_the_ID(), 'jws_theme_post_video_vimeo', true);
						if($video_vimeo){
							echo do_shortcode('[video_post height="'.$video_height.'"]'.$video_vimeo.'[/video_post]');
						}
						break;
					case 'media':
						$video_type = get_post_meta(get_the_ID(), 'jws_theme_post_video_type', true);
						$preview_image = get_post_meta(get_the_ID(), 'jws_theme_post_preview_image', true);
						$video_file = get_post_meta(get_the_ID(), 'jws_theme_post_video_url', true);
						if($video_file){
							echo do_shortcode('[video_post height="'.$video_height.'" '.$video_type.'="'.$video_file.'" poster="'.$preview_image.'"][/video_post]');
						}
						break;
				}
			}
			?>
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