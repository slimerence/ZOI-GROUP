<?php
/* Main function for importing dummy data */
if ( ! function_exists( 'installSample' ) ) {
function installSample(){
ob_start();
$msg = '<br/>';
if ( !defined('WP_LOAD_IMPORTERS') ) define('WP_LOAD_IMPORTERS', true);
require_once ABSPATH . 'wp-admin/includes/import.php';
$importer_error = false;

if ( !class_exists( 'WP_Importer' ) ) {
	$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
	file_exists( $class_wp_importer ) ? require_once($class_wp_importer):$importer_error = true;
}
if ( !class_exists( 'WP_Import' ) ) {
	$class_wp_import = JWS_THEME_ABS_PATH_ADMIN . '/sample/wordpress-importer/wordpress-importer.php';
	file_exists( $class_wp_import ) ? require_once($class_wp_import): $importer_error = true;
}
if($importer_error)
{
	die("Import error! Please unninstall WP importer plugin and try again");
}
$wp_import = new WP_Import();
$wp_import->fetch_attachments = true;
$themename = 'eduonline';
/* Import contents */
$result = $wp_import->import( JWS_THEME_ABS_PATH_ADMIN. '/sample/'.$themename.'/sample.xml');
// setup menus
$locations = get_registered_nav_menus();
foreach ( $locations as $locationId => $menuValue ) {
	switch ( $locationId ) {
		case 'main_navigation':
		$menu = get_term_by( 'name', 'Menu 1', 'nav_menu' );
		break;
	}
	if ( isset( $menu ) ) {
		$locations[ $locationId ] = $menu->term_id;
	}
}
set_theme_mod( 'nav_menu_locations', $locations );
// Use a static front page			
$homepage = get_page_by_title( 'Home Page 01' );
update_option( 'page_on_front', $homepage->ID );
update_option( 'show_on_front', 'page' );	
/* Import revsliders */
if(!tb_import_revslider($themename)){
	die('<br />You haven\'t install Rev Slider plugin. Slider isn\'t imported<br />');
}
/* Import widgets */
$wie_file = JWS_THEME_ABS_PATH_ADMIN . '/sample/wordpress-importer/widgets_import.php';
if ( file_exists( $wie_file ) ) {
	require $wie_file;
	$temp_dir = wp_upload_dir();
	$newname  = $temp_dir['path'] . '/widgets_import.wie';
	copy( JWS_THEME_ABS_PATH_ADMIN. '/sample/'.$themename.'/widgets.wie', $newname );
	$widgets = wie_process_import_file( $newname );		
}
/* Import options*/
$option_string = JWS_THEME_URI_PATH_ADMIN. '/sample/'.$themename.'/options.json';
$option_data = wp_remote_get($option_string);		
if ( ! empty( $option_data ) ) {
	$option_data = json_decode( $option_data,true );
}
tb_set_options($option_data);
die('Import is Completed.');
ob_end_clean();	
}
}
if ( !function_exists( 'tb_set_options' ) ){
function tb_set_options($options){
$args = array('global_variable'=>'jws_theme_options','opt_name'=>'jws_theme_options');
$ReduxFramework = new ReduxFramework(array(),$args);
$ReduxFramework->set_options($options);
}
}
if(!function_exists('tb_import_revslider')){
function tb_import_revslider($theme){
if(class_exists('UniteBaseAdminClassRev')){
	require_once(ABSPATH .'wp-content/plugins/revslider/admin/revslider-admin.class.php');
	if ($handle = opendir(JWS_THEME_ABS_PATH_ADMIN.'/sample/'.$theme.'/revslider')) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				$_FILES['import_file']['tmp_name'] = JWS_THEME_ABS_PATH_ADMIN.'/sample/'.$theme.'/revslider/'.$entry;
				$slider = new RevSlider();
				ob_start();
				$response = $slider->importSliderFromPost(true, true);
				ob_end_clean();
			}
		}
		closedir($handle);
	}
	return true;
}
return false;
}
}		