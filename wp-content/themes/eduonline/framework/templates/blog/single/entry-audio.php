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
$audio_type = get_post_meta(get_the_ID(), 'jws_theme_post_audio_type', true);
$audio_url = get_post_meta(get_the_ID(), 'jws_theme_post_audio_url', true);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="tb-content-block">
		<?php if($jws_theme_show_post_title) echo jws_theme_theme_title_render(); ?>
		<?php if($jws_theme_show_post_desc) echo jws_theme_theme_content_render(); ?>
		<div style="clear: both"></div>
		<?php if($jws_theme_show_post_info) echo jws_theme_theme_info_bar_render(); ?>
		<?php if(is_single() && $jws_theme_post_show_social_share) echo jws_theme_theme_social_share_post_render(); ?>
		<?php if(is_single() && $jws_theme_post_show_post_tags) echo jws_theme_theme_tags_render(); ?>
		<?php if(is_single() && $jws_theme_post_show_post_author) echo jws_theme_theme_author_render(); ?>
	</div>
</article>