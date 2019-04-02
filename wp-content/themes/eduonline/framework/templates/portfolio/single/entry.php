<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
$image_default = isset($jws_theme_options['jws_theme_portfolio_image_default']) ? $jws_theme_options['jws_theme_portfolio_image_default'] : '';
if(is_home()){
	$jws_theme_show_post_title = 1;
	$jws_theme_show_post_desc = 1;
	$jws_theme_show_post_info = 1;
}elseif (is_single()) {
	$jws_theme_portfolio_crop_image = isset($jws_theme_options['jws_theme_portfolio_crop_image']) ? $jws_theme_options['jws_theme_portfolio_crop_image'] : 0;
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_post_show_post_title']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_post_show_post_info']) ? $jws_theme_options['jws_theme_post_show_post_title'] : 1;
	$jws_theme_post_show_social_share = (int) isset($jws_theme_options['jws_theme_post_show_social_share']) ? $jws_theme_options['jws_theme_post_show_social_share'] : 1;
	$jws_theme_post_show_post_tags = (int) isset($jws_theme_options['jws_theme_post_show_post_tags']) ? $jws_theme_options['jws_theme_post_show_post_tags'] : 1;
	$jws_theme_post_show_post_author = (int) isset($jws_theme_options['jws_theme_post_show_post_author']) ? $jws_theme_options['jws_theme_post_show_post_author'] : 1;
	$jws_theme_show_post_desc = 1;
}else{
	$jws_theme_portfolio_crop_image = isset($jws_theme_options['jws_theme_portfolio_crop_image']) ? $jws_theme_options['jws_theme_portfolio_crop_image'] : 0;
	
	$jws_theme_show_post_title = (int) isset($jws_theme_options['jws_theme_portfolio_show_post_title']) ? $jws_theme_options['jws_theme_portfolio_show_post_title'] : 1;
	$jws_theme_show_post_info = (int) isset($jws_theme_options['jws_theme_portfolio_show_post_info']) ? $jws_theme_options['jws_theme_portfolio_show_post_title'] : 1;
	$jws_theme_show_post_desc = (int) isset($jws_theme_options['jws_theme_portfolio_show_post_desc']) ? $jws_theme_options['jws_theme_portfolio_show_post_desc'] : 1;
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row tb-post-item">
		
		<div class="col-sm-12 col-md-4">
			<div class="tb-content-block">
				<h4><?php echo esc_html__('Project description','eduonline'); ?></h4>
				
				<?php if($jws_theme_show_post_title) echo jws_theme_title_render(); ?>
				<?php if($jws_theme_show_post_desc) echo jws_theme_content_render(); ?>
				
				<h4 class="tb-info-title"><?php echo esc_html__('Project Detail ','eduonline'); ?></h4>
				<ul class="tb-content-info">
					<?php 
						$creater = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_creater', true) );
						$participant = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_participant', true) );
						$date = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_date', true) );
						$website = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_website', true) );
					?>
					<?php if($creater){?> <li><?php echo esc_html__('Created by: ','eduonline'); ?> <span><?php echo $creater; ?></span></li>
					<?php } if($participant){?><li><?php echo esc_html__('Participants: ','eduonline'); ?><span><?php echo $participant; ?></span></li>
					<?php } if($date){?><li><?php echo esc_html__('Date: ','eduonline'); ?><span><?php echo $date; ?></span></li>
					<?php } if($website){?><li><?php echo esc_html__('Website: ','eduonline'); ?><span><?php echo $website; ?></span></li><?php } ?>

				</ul>
			</div>
		</div>
		<div class="col-sm-12 col-md-8">
		<?php if (has_post_thumbnail()) { ?>
			<div class="tb-blog-image"><?php the_post_thumbnail('portfolio-single-thumb'); ?></div>
		<?php } ?>
		</div>
	</div>
	
</article>