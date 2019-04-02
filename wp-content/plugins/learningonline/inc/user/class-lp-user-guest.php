<?php

/**
 * Class LP_User_Guest
 *
 * @author  JwsTheme
 * @package LearningOnline/Classes
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();

class LP_User_Guest extends LP_Abstract_User {

	/**
	 * @param $the_user
	 */
	public function __construct( $the_user ) {
		$this->id   = $the_user ? $the_user : LP_User_Factory::generate_guest_id();
		$this->user = new WP_User();
	}

	/**
	 * @static
	 *
	 * @return LP_User_Guest
	 */
	public static function instance() {
		_deprecated_function( __CLASS__ . '::' . __FUNCTION__, '2.0.7' );
		static $user;
		if ( !$user ) {
			if ( !session_id() ) @session_start();
			if ( empty( $_SESSION['learning_online_temp_user_id'] ) ) {
				$_SESSION['learning_online_temp_user_id']    = time();
				$_SESSION['learning_online_temp_session_id'] = session_id();
			}
			$user = new self( $_SESSION['learning_online_temp_user_id'] );
		}
		return $user;
	}
}