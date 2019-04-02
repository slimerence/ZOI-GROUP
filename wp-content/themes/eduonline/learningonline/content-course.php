<?php
/**
 * Template for displaying course content within the loop
 *
 * @author  ThimPress
 * @package LearnPress/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$columns = $jws_theme_options['jws_theme_archive_course_column'];
	
	if( isset( $_GET['columns'] ) ){
		$columns = intval( $_GET['columns'] );
	}
?>
<?php
	if( $columns == 4 ){
		$lo_columns = "col-lg-3 col-md-4 col-sm-6 col-xs-12";
	}elseif( $columns == 3 ){
		$lo_columns = "col-lg-4 col-md-6 col-sm-6 col-xs-12";
	}elseif( $columns == 2 ){
		$lo_columns = "col-lg-6 col-md-6 col-sm-6 col-xs-12";
	}else{
		$lo_columns = "col-xs-12 tb-courses-one-column ";
	}

?>
<div class="<?php echo esc_attr($lo_columns); ?> tb-course-item">
	<?php if( $columns == 1 ){
		learning_online_get_template('loop/course/loop-course-list-item.php'); 
	}else   learning_online_get_template('loop/course/loop-course-item.php'); ?>
</div>