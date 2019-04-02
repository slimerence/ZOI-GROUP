<?php
/**
 * Manage the admin notices and display them in admin
 *
 * @package    LearningOnline
 * @author     JwsTheme
 * @version    1.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_Admin_Notice
 */
class LP_Admin_Notice {
	/**
	 * Store all notices which added anywhere before show
	 * @var array
	 */
	protected static $_notices = array();

	/**
	 * LP_Admin_Notice construct
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'dismiss_notice' ) );
		add_action( 'admin_notices', array( __CLASS__, 'show_notices' ), 100000 );
	}

	public function dismiss_notice() {
		$notice = learning_online_get_request( 'lp-hide-notice' );
		if ( !$notice ) {
			return;
		}
		if ( $transient = learning_online_get_request( 't' ) ) {
			set_transient( 'lp-hide-notice-' . $notice, 'yes', $transient );
		} else {
			learning_online_update_user_option( 'hide-notice-' . $notice, 'yes' );
		}

		if ( $redirect = apply_filters( 'learning_online_hide_notice_redirect', remove_query_arg( 'lp-hide-notice' ) ) ) {
			wp_redirect( untrailingslashit( $redirect ) );
			exit();
		}
	}

	/**
	 * Add new notice to queue
	 *
	 * @param string $message The message want to display
	 * @param string $type    The class name of WP message type updated|update-nag|error
	 * @param string $id      Custom id for html element's ID
	 * @param        bool
	 */
	public static function add( $message, $type = 'success', $id = '', $redirect = false ) {
		if ( $redirect ) {
			$notices = get_transient( 'learning_online_redirect_notices' );
			if ( empty( $notices ) ) {
				$notices = array();
			}
			$notices[] = array(
				'type'    => $type,
				'message' => $message,
				'id'      => $id
			);
			set_transient( 'learning_online_redirect_notices', $notices );
		} else {
			self::$_notices[] = array(
				'type'    => $type,
				'message' => $message,
				'id'      => $id
			);
		}
	}

	public static function add_redirect( $message, $type = 'updated', $id = '' ) {
		self::add( $message, $type, $id, true );
	}

	/**
	 * Show all notices has registered
	 */
	public static function show_notices() {
		if ( self::$_notices ) {
			foreach ( self::$_notices as $notice ) {
				if ( empty( $notice ) ) {
					continue;
				}
				learning_online_admin_view( 'admin-notice.php', $notice );
			}
		}
		if ( $notices = get_transient( 'learning_online_redirect_notices' ) ) {
			foreach ( $notices as $notice ) {
				if ( empty( $notice ) ) {
					continue;
				}
				learning_online_admin_view( 'admin-notice.php', $notice );
			}
			delete_transient( 'learning_online_redirect_notices' );
		}
	}
}

new LP_Admin_Notice();