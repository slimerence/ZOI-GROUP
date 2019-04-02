<?php

/**
 * Class LP_Session
 *
 * @author  JwsTheme
 * @package LearningOnline/Classes
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class LP_Session {
	/**
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( self::$instance ) return;
		//$this->_init();
	}

	public function __get( $key ) {
		$return = null;
		switch ( $key ) {
			case 'id':
				$return = session_id();
				break;
			default:
				$return = self::get( $key );
		}
		return $return;

	}

	public function __set( $key, $value ) {
		return self::set( $key, $value );
	}

	/**
	 * Start session if it is not started
	 * and init global session used by LearningOnline
	 *
	 * @access private
	 * @return array
	 */
	public static function init() {
		if ( !session_id() && !headers_sent() ) {
			session_start();
		}
		if ( !session_id() ) {
			LP_Debug::instance()->add( 'Session start failed!' );
			return false;
		}
		if ( empty( $_SESSION['learning_online'] ) ) {
			$_SESSION['learning_online'] = array();
		}

		do_action( 'learning_online_session_init' );

		return $_SESSION['learning_online'];
	}

	/**
	 * Push new value with a key into session array
	 *
	 * @param $key
	 * @param $value
	 *
	 * @return mixed
	 */
	public static function set( $key, $value ) {
		$_SESSION['learning_online'][$key] = $value;
		return $_SESSION['learning_online'][$key];
	}

	/**
	 * Get a value from session array by key
	 *
	 * @param $key
	 *
	 * @return mixed
	 */
	public static function get( $key ) {
		$content = !empty( $_SESSION['learning_online'][$key] ) ? $_SESSION['learning_online'][$key] : false;
		if ( $key == 'cart' && $content ) {
			if ( !empty( $content['items'] ) ) {
				$total = 0;
				foreach ( $content['items'] as $id => $data ) {
					$price   = get_post_meta( $data['item_id'], '_lp_price', true );
					$payment = get_post_meta( $data['item_id'], '_lp_payment', true );
					if ( $payment != 'yes' || !$price ) {
						$price = 0;
					}
					$content['items'][$id]['subtotal'] = $content['items'][$id]['total'] = $data['quantity'] * $price;
					$total += $content['items'][$id]['total'];
				}
				$content['subtotal'] = $content['total'] = $total;
			}
		}
		return $content;
	}

	/**
	 * Clear a value from session by key
	 *
	 * @param $key
	 */
	public static function remove( $key ) {
		if ( isset( $_SESSION['learning_online'][$key] ) ) {
			unset( $_SESSION['learning_online'][$key] );
		}
	}

	/**
	 * Get unique instance object of the class
	 *
	 * @return LP_Session|object
	 */
	public static function instance() {
		if ( !self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

LP_Session::init();