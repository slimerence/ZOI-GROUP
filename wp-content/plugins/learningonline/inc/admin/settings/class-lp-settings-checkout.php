<?php

/**
 * Class LP_Settings_Checkout
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Classes/Settings
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class LP_Settings_Checkout extends LP_Settings_Base {

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->id   = 'checkout';
		$this->text = __( 'Checkout', 'learningonline' );

		parent::__construct();
	}

	/**
	 * Tab's sections
	 *
	 * @return mixed
	 */
	public function get_sections() {
		$sections = array(
			'general' => array(
				'id'    => 'general',
				'title' => __( 'General', 'learningonline' )
			)
		);
		return $sections = apply_filters( 'learning_online_settings_sections_' . $this->id, $sections );
	}

	public function output_section_general() {
		$view = learning_online_get_admin_view( 'settings/checkout.php' );
		include_once $view;
	}

	public function get_settings() {
		return apply_filters(
			'learning_online_checkout_settings',
			array(
				array(
					'title'   => __( 'Auto enroll', 'learningonline' ),
					'desc'    => __( 'Auto enroll a user after they buy a course.', 'learningonline' ),
					'id'      => $this->get_field_name( 'auto_enroll' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),
				array(
					'title'   => __( 'Checkout page', 'learningonline' ),
					'id'      => $this->get_field_name( 'checkout_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				),
				array(
					'title' => __( 'Checkout Endpoints', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Order received', 'learningonline' ),
					'id'      => $this->get_field_name( 'checkout_endpoints[lp_order_received]' ),
					'default' => 'lp-order-received',
					'type'    => 'text'
				),
			),
			$this
		);
	}
}

//
return new LP_Settings_Checkout();