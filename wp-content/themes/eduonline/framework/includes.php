<?php
/* Metaboxes */
require_once JWS_THEME_ABS_PATH_FR.'/meta-boxes/meta-boxes.php';
/* Load Shortcodes Function */
require_once JWS_THEME_ABS_PATH_FR . '/shortcodes/shortcode-functions.php';
/* Load Shortcodes */
require_once JWS_THEME_ABS_PATH_FR . '/shortcodes/shortcodes.php';
/* Load custom menu */
require_once JWS_THEME_ABS_PATH_FR . '/megamenu/mega-menu.php';
/* Load Calendar post */
//require_once JWS_THEME_ABS_PATH_FR . '/includes/calendar_post.php';
/* Vc extra params */
if (function_exists("vc_add_param")){
	require_once JWS_THEME_ABS_PATH_FR.'/includes/vc_extra_params.php';
}
/* Vc extra Fields */
if (class_exists('Vc_Manager')) {
    function vc_add_extra_field( $name, $form_field_callback, $script_url = null ) {
            return WpbakeryShortcodeParams::addField( $name, $form_field_callback, $script_url );
    }
}
/* Vc extra shorcodes */
if (function_exists("vc_map")){
	foreach (glob(JWS_THEME_ABS_PATH_FR."/includes/vc_element_shortcodes/*.php") as $filepath)
	{
		require_once $filepath;
	}
}
/* Vc extra field */
if (function_exists("vc_add_extra_field")){
	require_once JWS_THEME_ABS_PATH_FR.'/includes/vc_extra_fields.php';
}