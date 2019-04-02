<?php

/**
 * Class LP_Settings_Profile
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Classes/Settings
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LP_Settings_Profile extends LP_Settings_Base {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id   = 'profile';
		$this->text = __( 'Profile', 'learningonline' );

		parent::__construct();
	}

	public function output() {
		$view = learning_online_get_admin_view( 'settings/profile.php' );
		include_once $view;
	}

	public function get_settings() {
		return apply_filters(
			'learning_online_profile_settings',
			array(
				array(
					'title'   => __( 'Profile page', 'learningonline' ),
					'id'       => $this->get_field_name( 'profile_page_id' ),
					'id'       => $this->get_field_name( 'profile_page_id' ),
					'default'  => '',
					'type'     => 'pages-dropdown'
				)
			)
		);
	}
}

return new LP_Settings_Profile();