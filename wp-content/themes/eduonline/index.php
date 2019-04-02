<?php get_header(); ?>
<?php
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$jws_theme_show_page_title = isset($jws_theme_options['jws_theme_page_show_page_title']) ? $jws_theme_options['jws_theme_page_show_page_title'] : 1;
	$jws_theme_show_page_breadcrumb = isset($jws_theme_options['jws_theme_page_show_page_breadcrumb']) ? $jws_theme_options['jws_theme_page_show_page_breadcrumb'] : 1;	
?>
<div class="main-content">
	<div class="container">
		<div class="row">
			<?php
				$jws_theme_blog_layout = isset($jws_theme_options['jws_theme_blog_layout']) ? $jws_theme_options['jws_theme_blog_layout'] : '2cr';
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
					if(is_active_sidebar( 'tbtheme-left-sidebar' )){
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
					case '3cm':
					if(is_active_sidebar( 'tbtheme-left-sidebar' ) && is_active_sidebar( 'tbtheme-right-sidebar' )){
						$cl_content = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						$cl_sb_left = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
						$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}else{
						if(is_active_sidebar( 'tbtheme-left-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
							$cl_sb_left = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}
						if(is_active_sidebar( 'tbtheme-right-sidebar' )){
							$cl_content = 'col-xs-12 col-sm-9 col-md-9 col-lg-9';
							$cl_sb_right = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
						}
					}
					break;
				}
			?>
			<!-- Start Left Sidebar -->
			<?php if($jws_theme_blog_layout == '2cl' && is_active_sidebar( 'tbtheme-left-sidebar' ) || ($jws_theme_blog_layout == '3cm' && is_active_sidebar( 'tbtheme-left-sidebar' ))){ ?>
				<div class="<?php echo esc_attr($cl_sb_left) ?> sidebar-area">
					<?php get_sidebar('left'); ?>
				</div>
			<?php } ?>
			<!-- End Left Sidebar -->
			<!-- Start Content -->
			<div class="<?php echo esc_attr($cl_content) ?> content">
				<div class="tb-blog">
					<?php
						if( have_posts() ) {
							$loop = 0;
							$columns = 1;
							$class_columns = null;
							switch ($columns) {
								case 1: $class_columns = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
								break;
								case 2: $class_columns = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
								break;
								case 3: $class_columns = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
								break;
								case 4: $class_columns = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
								break;
								default: $class_columns = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
								break;
							}
							while ( have_posts() ) : the_post();
							$loop++;
							$start_row = $end_row = '';
							if( 0 == ( $loop - 1 ) % $columns || 1 == $columns ) echo '<div class="row">';
							echo '<div class="'.$class_columns.'">';
							get_template_part( 'framework/templates/blog/entry', get_post_format());
							echo '</div>';
							if( 0 == $loop % $columns ) echo '</div>';
							endwhile;
							if($loop % $columns != 0) echo '</div>';
							jws_theme_theme_paging_nav();
							}else{
							get_template_part( 'framework/templates/entry', 'none');
						}
					?>
				</div>
			</div>
			<!-- End Content -->
			<!-- Start Right Sidebar -->
			<?php if(($jws_theme_blog_layout == '2cr' && is_active_sidebar( 'tbtheme-right-sidebar' )) || ($jws_theme_blog_layout == '3cm' && is_active_sidebar( 'tbtheme-right-sidebar' ))){ ?>
				<div class="<?php echo esc_attr($cl_sb_right) ?> sidebar-area">
					<?php get_sidebar(); ?>
				</div>
			<?php } ?>
			<!-- End Right Sidebar -->
		</div>
	</div>
</div>
<?php get_footer(); ?>