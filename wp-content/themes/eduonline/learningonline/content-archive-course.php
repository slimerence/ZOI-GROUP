<?php
/**
 * Template for displaying archive course content
 *
 * @author  ThimPress
 * @package eduonline/Templates
 * @version 2.0.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	global $post, $wp_query;

	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$columns = $jws_theme_options['jws_theme_archive_course_column'];

	$jws_theme_sidebar_pos = $jws_theme_options['jws_theme_archive_sidebar_pos_course'];
	
	$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$cl_sidebar = '';

	
	if( isset( $_GET['sidebar'] ) ){
		$jws_theme_sidebar_pos =  $_GET['sidebar'];
	}
	
	if ( $jws_theme_sidebar_pos != 'tb-sidebar-hidden' && is_active_sidebar('tbtheme-course-sidebar') ) {
		$cl_content = 'col-xs-12 col-sm-8 col-md-8 col-lg-9 tb-content';
		$cl_sidebar = 'col-xs-12 col-sm-4 col-md-4 col-lg-3 sidebar-area';
	}
 ?>
<div class="container">

	<div class="row">
		<div class="<?php echo esc_attr($jws_theme_sidebar_pos); ?>">

			<?php if ( is_active_sidebar('tbtheme-course-sidebar') && $jws_theme_sidebar_pos == 'tb-sidebar-left') { ?>
				<div class="<?php echo esc_attr($cl_sidebar); ?>">
					<div id="secondary" class="widget-area" role="complementary">
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'tbtheme-course-sidebar' ); ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php do_action( 'learning_online_archive_description' ); ?>

			<?php if ( LP()->wp_query->have_posts() ) : ?>

				<?php 
				
				//echo jws_theme_sort_by_page(10);
				
				do_action( 'learning_online_before_courses_loop' ); ?>

				<?php learning_online_begin_courses_loop(); ?>

				<?php while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post(); ?>

					<?php learning_online_get_template_part( 'content', 'course' ); ?>

				<?php endwhile; ?>

				<?php learning_online_end_courses_loop(); ?>

				<?php do_action( 'learning_online_after_courses_loop' ); ?>
				
				<?php learning_online_end_courses_loop(); ?>
			<?php else: ?>
				<?php learning_online_display_message( __( 'No course found.', 'eduonline' ), 'error' ); ?>
			<?php endif; ?>
			<?php if ( is_active_sidebar('tbtheme-course-sidebar') && $jws_theme_sidebar_pos == 'tb-sidebar-right') { ?>
				<div class="<?php echo esc_attr($cl_sidebar); ?>">
					<div id="secondary" class="widget-area" role="complementary">
						<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
							<?php dynamic_sidebar( 'tbtheme-course-sidebar' ); ?>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
