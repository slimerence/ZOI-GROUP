<?php get_header(); ?>
<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
$jws_theme_show_page_title = (int) isset($jws_theme_options['jws_theme_post_show_page_title']) ? $jws_theme_options['jws_theme_post_show_page_title'] : 1;
$jws_theme_show_page_breadcrumb = (int) isset($jws_theme_options['jws_theme_post_show_page_breadcrumb']) ? $jws_theme_options['jws_theme_post_show_page_breadcrumb'] : 1;

$jws_theme_show_post_comment = (int) isset($jws_theme_options['jws_theme_post_show_post_comment']) ?  $jws_theme_options['jws_theme_post_show_post_comment']: 1;
$jws_theme_post_show_post_related = (int) isset($jws_theme_options['jws_theme_post_show_post_related']) ?  $jws_theme_options['jws_theme_post_show_post_related']: 1;
$jws_theme_post_no_post_related = (int) isset($jws_theme_options['jws_theme_post_no_post_related']) ?  $jws_theme_options['jws_theme_post_no_post_related']: 3;
$columns = $jws_theme_post_no_post_related > 0 ? $jws_theme_post_no_post_related : 3;

?>
	<div class="main-content">
		<div class="container">
			<div class="row">
				<?php
				$jws_theme_blog_layout = isset($jws_theme_options['jws_theme_post_layout']) ? $jws_theme_options['jws_theme_post_layout'] : '3cm';
				if( isset( $_GET['sidebar'] ) ){
					$jws_theme_blog_layout =  $_GET['sidebar'];
				}
				$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
				$cl_sb_left = '';
				$cl_sb_right = '';
				
				switch ($jws_theme_blog_layout) {
					case '1col':
						$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
						$cl_sb_left = '';
						$cl_sb_right = '';
						break;
					case '2cl':
						if(is_active_sidebar( 'tbtheme-right-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
							$cl_sb_left = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}
						break;
					case '2cr':
						if(is_active_sidebar( 'tbtheme-right-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
							$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}
						break;
					
				}
				?>
				<!-- Start Left Sidebar -->
				<?php if($jws_theme_blog_layout == '2cl' && is_active_sidebar( 'tbtheme-right-sidebar' )){ ?>
					<div class="<?php echo esc_attr($cl_sb_left) ?> sidebar-area">
						<?php get_sidebar('right'); ?>
					</div>
				<?php } ?>
				<!-- End Left Sidebar -->
				<!-- Start Content -->
				<div class="<?php echo esc_attr($cl_content) ?> content tb-blog blog">
				
					<?php
					while ( have_posts() ) : the_post();
						$post_id = get_the_ID();
						get_template_part( 'framework/templates/blog/single/entry', get_post_format());
						
						
					endwhile;
					?>
					
					<?php 
					// If comments are open or we have at least one comment, load up the comment template.
					if ( (comments_open() && $jws_theme_show_post_comment) || (get_comments_number() && $jws_theme_show_post_comment) ) comments_template();
					?>
					
					<?php if($jws_theme_post_show_post_related) { ?>
					<article class="tb-blog-related">
						<?php
						$i =0;
						$related = get_posts( array( 'category__in' => wp_get_post_categories($post_id), 'numberposts' => $jws_theme_post_no_post_related, 'post__not_in' => array($post_id) ) );
						if( $related ) {
						echo '<div class="tb-title"><h4>'. __('Relate Posts','eduonline') .'</h4></div>
							<div class="row">';
							foreach( $related as $post ) {
							$i++;
							setup_postdata($post); 
								if(has_post_thumbnail()){
									$attachment_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full', false);
									$image_resize = matthewruddy_image_resize( $attachment_image[0], 600, 400, true, false );
									?>
									<div class="col-md-<?php echo intval( 12/$columns );?> col-sm-6 hidden-xs">
										<a href="<?php the_permalink(); ?>"><img style="width:100%;" class="bt-image-cropped" src="<?php echo esc_attr($image_resize['url']); ?>" alt=""></a>
										<div class="tb_blog_content">
											<?php echo jws_theme_title_render(); ?>
											<div  class="tb-date"><span><?php echo __('Updated: ','eduonline');?></span><?php echo get_the_time('d / m / Y');?></div>
											<div class="tb-info-block">
												<?php 
												echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt(15, '...').'</div>'; ?>
											</div>
											
										</div>
									</div>
									<?php
								}
							} 
						echo '</div>';
						}
						wp_reset_postdata(); 
						?>
					</article>
					
					<?php } ?>
				</div>
				<!-- End Content -->
				<!-- Start Right Sidebar -->
				<?php if($jws_theme_blog_layout == '2cr' && is_active_sidebar( 'tbtheme-right-sidebar' )){ ?>
					<div class="<?php echo esc_attr($cl_sb_right) ?> sidebar-area">
						<?php get_sidebar('right'); ?>
					</div>
				<?php } ?>
				<!-- End Right Sidebar -->
			</div>
		</div>
	</div>
<?php get_footer(); ?>