<?php
/**
 * Template for display wrap start of courses list
 *
 * @author  ThimPress
 * @version 1.1
 */
 
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	
	$columns = $jws_theme_options['jws_theme_archive_course_column'];
	
	$jws_theme_sidebar_pos = $jws_theme_options['jws_theme_archive_sidebar_pos_course'];
	
	$cl_content = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	
	if( isset( $_GET['sidebar'] ) ){

		$jws_theme_sidebar_pos =  $_GET['sidebar'];
	}
	
	if ( $jws_theme_sidebar_pos != 'tb-sidebar-hidden' && is_active_sidebar('tbtheme-course-sidebar') ) {
		
		$cl_content = 'col-xs-12 col-sm-8 col-md-8 col-lg-9 tb-content';
	
	}
?>
<div class="<?php echo esc_attr($cl_content); ?>"><div class="row course-same-height">
