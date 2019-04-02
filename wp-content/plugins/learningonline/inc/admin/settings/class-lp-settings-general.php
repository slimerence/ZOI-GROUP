<?php

/**
 * Class LP_Settings_General
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Settings/Classes
 * @version 1.0
 */
class LP_Settings_General extends LP_Settings_Base {
	/**
	 * Construct
	 */
	public function __construct() {
		$this->id   = 'general';
		$this->text = __( 'General', 'learningonline' );
		//add_action( 'learning_online_settings_general', array( $this, 'output' ) );
		//add_action( 'learning_online_settings_save_general', array( $this, 'save' ) );
		parent::__construct();
	}

	public function output() {
		$view = learning_online_get_admin_view( 'settings/general.php' );
		include_once $view;
	}

	public function get_settings() {
		return apply_filters(
			'learning_online_general_settings',
			array(
				array(
					'title'   => __( 'Instructors registration', 'learningonline' ),
					'desc'    => __( 'Create option for instructors registration.', 'learningonline' ),
					'id'      => $this->get_field_name( 'instructor_registration' ),
					'default' => 'no',
					'type'    => 'checkbox'
				),
				array(
					'title'   => __( 'Currency', 'learningonline' ),
					'id'      => $this->get_field_name( 'currency' ),
					'default' => 'USD',
					'type'    => 'select',
					'options' => $this->_get_currency_options()
				),
				array(
					'title'   => __( 'Currency position', 'learningonline' ),
					'id'      => $this->get_field_name( 'currency_pos' ),
					'default' => 'left',
					'type'    => 'select',
					'options' => $this->_get_currency_positions()
				),
				array(
					'title'   => __( 'Thousands Separator', 'learningonline' ),
					'id'      => $this->get_field_name( 'thousands_separator' ),
					'default' => ',',
					'type'    => 'text',
					'options' => $this->_get_currency_positions()
				),
				array(
					'title'   => __( 'Decimals Separator', 'learningonline' ),
					'id'      => $this->get_field_name( 'decimals_separator' ),
					'default' => '.',
					'type'    => 'text',
					'options' => $this->_get_currency_positions()
				),
				array(
					'title'   => __( 'Number of Decimals', 'learningonline' ),
					'id'      => $this->get_field_name( 'number_of_decimals' ),
					'default' => '2',
					'type'    => 'number',
					'options' => $this->_get_currency_positions()
				),
				array(
					'title'   => __( 'Load css', 'learningonline' ),
					'id'      => $this->get_field_name( 'load_css' ),
					'default' => 'yes',
					'type'    => 'checkbox',
					'desc'    => __( 'Load default stylesheet for LearningOnline', 'learningonline' )
				),
				array(
					'title'   => __( 'Debug mode', 'learningonline' ),
					'id'      => $this->get_field_name( 'debug' ),
					'default' => 'yes',
					'type'    => 'checkbox',
					'desc'    => __( 'Turn on/off debug mode for developer', 'learningonline' )
				),
				array(
					'title' => __( 'Logout', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Redirect to page', 'learningonline' ),
					'id'      => $this->get_field_name( 'logout_redirect_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				),
			)
		);
	}

	private function _get_currency_options() {
		$currencies = array();

		if ( $payment_currencies = learning_online_get_payment_currencies() )
			foreach ( $payment_currencies as $code => $symbol ) {
				$currencies[$code] = $symbol;
			}

		return $currencies;
	}

	private function _get_currency_positions() {
		$positions = array();
		foreach ( learning_online_currency_positions() as $pos => $text ) {
			switch ( $pos ) {
				case 'left':
					$text = sprintf( '%s ( %s%s )', $text, learning_online_get_currency_symbol(), '69.99' );
					break;
				case 'right':
					$text = sprintf( '%s ( %s%s )', $text, '69.99', learning_online_get_currency_symbol() );
					break;
				case 'left_with_space':
					$text = sprintf( '%s ( %s %s )', $text, learning_online_get_currency_symbol(), '69.99' );
					break;
				case 'right_with_space':
					$text = sprintf( '%s ( %s %s )', $text, '69.99', learning_online_get_currency_symbol() );
					break;
			}
			$positions[$pos] = $text;
		}
		return $positions;
	}
}

return new LP_Settings_General();