<?php get_header(); ?>
<?php
global $jws_theme_options;
$jws_theme_show_page_title = isset($jws_theme_options['jws_theme_post_show_page_title']) ? $jws_theme_options['jws_theme_post_show_page_title'] : 1;
$jws_theme_show_page_breadcrumb = isset($jws_theme_options['jws_theme_post_show_page_breadcrumb']) ? $jws_theme_options['jws_theme_post_show_page_breadcrumb'] : 1;

$jws_theme_show_post_nav = (int) isset($jws_theme_options['jws_theme_post_show_post_nav']) ?  $jws_theme_options['jws_theme_post_show_post_nav']: 1;
$jws_theme_show_post_comment = (int) isset($jws_theme_options['jws_theme_post_show_post_comment']) ?  $jws_theme_options['jws_theme_post_show_post_comment']: 1;
$jws_theme_post_show_post_related = (int) isset($jws_theme_options['jws_theme_post_show_post_related']) ?  $jws_theme_options['jws_theme_post_show_post_related']: 1;
?>
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
					while ( have_posts() ) : the_post();
						$post_id = get_the_ID();
						get_template_part( 'framework/templates/portfolio/single/entry', get_post_format());
						// Previous/next post navigation.
					
					endwhile;
					?>
				</div>
				<!-- End Content -->
				
			</div>

		</div>
	</div>
<?php get_footer(); ?>