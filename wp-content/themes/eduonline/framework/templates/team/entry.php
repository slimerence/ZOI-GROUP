<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
$image_default = isset($jws_theme_options['jws_theme_blog_image_default']) ? $jws_theme_options['jws_theme_blog_image_default'] : '';
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail() || $image_default) { ?>
        <div class="tb-blog-image team-single col-md-4">
            <?php
			if(has_post_thumbnail()){
				the_post_thumbnail();
			}else{
				if($image_default['url']){
					echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
				}
			} ?>
        </div>
    <?php } ?>
	<div class="tb-content-block col-md-8">
		<h2 class="blog-title"><?php the_title(); ?></h2>
		<div class="blog-desc">
			<?php
				the_content();
			?>
		</div>
		<div class="blog-info">
			<span class="publish-date" data-datetime="<?php echo get_the_date('Y-m-j') . ' ' . get_the_time('H:i:s'); ?>" data-pubdate="pubdate">
			   <?php echo get_the_date('F j, Y'); ?>
			</span>
			<span class="line-end"></span>
		</div>
	</div>
</article>