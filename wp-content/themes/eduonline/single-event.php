<?php get_header(); ?>
<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];

$jws_theme_show_post_comment = (int) isset($jws_theme_options['jws_theme_classes_show_post_comment']) ?  $jws_theme_options['jws_theme_classes_show_post_comment']: 1;

$jws_theme_classes_single_content = (int) isset($jws_theme_options['jws_theme_classes_single_content']) ? $jws_theme_options['jws_theme_classes_single_content'] : '';

?>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-58c66589c6acc5e3"></script>
	<div class="main-content">
		<div class="container">
			<div class="row">
				<?php
					$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
					$cl_sb_left = '';
					$cl_sb_right = '';
				?>
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content tb-blog">
					
					<?php
					//echo $jws_theme_blog_layout;
					while ( have_posts() ) : the_post();
						get_template_part( 'framework/templates/event/single/entry');
					
					endwhile;
					?>
					<div style="clear: both"></div>
					<!-- End Content -->
					<?php if(is_active_sidebar( 'tbtheme-maps-single-event' )){ ?>
						<div class="tb-map-event">
							<?php dynamic_sidebar("tbtheme-maps-single-event");?>
						</div>
					<?php } ?>
				</div>
				
			</div>
		</div>
		
	</div>
<?php get_footer(); ?>