<?php
/**
  * Include the TGM_Plugin_Activation class.
  */
require_once get_template_directory() . '/framework/admin/tgm-plugin-activation/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'jws_theme_theme_register_required_plugins' );
/**  * Register the required plugins for this theme.
 *
 *  <snip />
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
if(!function_exists('jws_theme_theme_register_required_plugins')){
	function jws_theme_theme_register_required_plugins() {
		/*
		* Array of plugin arrays. Required keys are name and slug.
		* If the source is NOT from the .org repo, then source is also required.
		*/
		$plugins = array(
			array(
				'name' => esc_attr__('JWS Plugins','eduonline'),
				'slug' => 'jwsplugins',
				'source' => 'http://jwsuperthemes.com/plugins/jwsplugins.zip',
				'required' => true,
				'version' => '1.0.0',
			),
			array(
				'name' => esc_attr__('Learning Online','eduonline'),
				'slug' => 'learningonline',
				'source' => 'http://jwsuperthemes.com/plugins/learningonline.zip',
				'required' => true,
				'version' => '1.0.0',
			),
			array(
				'name' => 'One Click Demo Import',
				'slug' => 'one-click-demo-import',
				'source' => 'http://jwsuperthemes.com/plugins/one-click-demo-import.zip',
				'required' => true,
				'version' => '2.3.0',
			),
			array(
			'name' => esc_attr__('Redux Framework','eduonline'),			
			'slug' => 'redux-framework',
			'required' => true,
			),
			array(
				'name' => esc_attr__('Revolution Slider','eduonline'),
				'slug' => 'revslider',
				'source' => 'https://jwsuperthemes.com/plugins/slider/revslider.zip',
				'required' => true,
				'version' => '5.4.5.2',
			),
			array(
				'name' => esc_attr__('Visual Composer','eduonline'),
				'slug' => 'js_composer',
				'source' => 'http://jwsuperthemes.com/plugins/js_composer.zip',
				'required' => true,
				'version' => '5.2.1',
			),
			array(
				'name' => esc_attr__('Slider Revolution Typewriter Effect','eduonline'),
				'slug' => 'revslider-typewriter-addon',
				'source' => 'http://jwsuperthemes.com/plugins/revslider-typewriter-addon.zip',
				'required' => true,
				'version' => '1.0.3',
			),
			array(
				'name' => esc_attr__('Contact Form 7','eduonline'),				
				'slug' => 'contact-form-7',
				'required' => false,
			),
			array(
				'name' => esc_attr__('Newsletter','eduonline'),
				'slug' => 'newsletter',
				'required' => false,
			)
		);
		/*
		* Array of configuration settings. Amend each line as needed.
		*
		* TGMPA will start providing localized text strings soon. If you already have translations of our standard
		* strings available, please help us make TGMPA even better by giving us access to these translations or by
		* sending in a pull-request with .po file(s) with the translations.
		*
		* Only uncomment the strings in the config array if you want to customize the strings.
		*/
		$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		);
		tgmpa( $plugins, $config );
	}
}