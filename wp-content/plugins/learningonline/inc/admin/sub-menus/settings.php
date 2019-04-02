<?php
/**
 * Admin view for settings page display in admin under menu Settings -> LearningOnline
 *
 * @author  JwsTheme
 * @package Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Setting page
 */
function learning_online_settings_page() {

	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

	$tabs = learning_online_settings_tabs_array();

	if ( !$current_tab && $tabs ) {
		$keys        = array_keys( $tabs );
		$current_tab = reset( $keys );
	}

	// ensure all settings relevant to rewrite rules effect immediately
	flush_rewrite_rules();

	if ( !empty( $_GET['settings-updated'] ) ) : ?>
		<div id="message" class="updated notice is-dismissible">
			<p><?php _e( 'LearningOnline settings updated.', 'learningonline' ); ?></p>
		</div>
	<?php endif; ?>

	<div class="wrap no-subtabs" id="learning-online-admin-settings">
		<div id="learning-online-updating-message" class="error hide-if-js">
			<p><?php esc_html_e( 'Settings changed. Updating...', 'learningonline' ); ?></p>
		</div>
		<div id="learning-online-updated-message" class="updated hide-if-js">
			<p><?php esc_html_e( 'Settings updated. Redirecting...', 'learningonline' ); ?></p>
		</div>
		<form method="<?php echo esc_attr( apply_filters( 'learning_online_settings_form_method_tab_' . $current_tab, 'post' ) ); ?>" id="mainform" action="" enctype="multipart/form-data">
			<div id="icon-themes" class="icon32"><br></div>
			<h2 class="nav-tab-wrapper">
				<?php if ( $tabs ) foreach ( $tabs as $tab => $name ) { ?>
					<?php $class = ( $tab == $current_tab ) ? ' nav-tab-active' : ''; ?>
					<a class="nav-tab <?php echo $class; ?>" href="?page=learning-online-settings&tab=<?php echo $tab; ?>"><?php echo $name; ?></a>
				<?php } ?>
				<?php do_action( 'learning_online_settings_tabs' ); ?>
			</h2>
			<?php do_action( 'learning_online_sections_' . $current_tab ); ?>
			<div class="learning-online-settings-wrap">
				<?php do_action( 'learning_online_settings_' . $current_tab ); ?>
				<p>
					<button class="button button-primary"><?php _e( 'Save settings', 'learningonline' ); ?></button>
					<a class="button" href="<?php echo wp_nonce_url( add_query_arg( 'reset', 'yes' ), 'learning-online-reset-settings' ); ?>" id="learning-online-reset-settings" data-text="<?php esc_attr_e( 'Do you want to restore all settings to default?', 'learningonline' ); ?>"><?php _e( 'Reset', 'learningonline' ); ?></a>
				</p>
				<?php wp_nonce_field( 'learning_online_settings', 'learning_online_settings_nonce' ); ?>
			</div>
		</form>
	</div>
	<?php
}

function learning_online_admin_update_settings() {

	$tabs        = learning_online_settings_tabs_array();
	$current_tab = isset( $_GET['tab'] ) ? $_GET['tab'] : '';

	if ( !$current_tab && $tabs ) {
		$keys        = array_keys( $tabs );
		$current_tab = reset( $keys );
	}

	$class_name = apply_filters( 'learning_online_settings_class_' . $current_tab, 'LP_Settings_' . $tabs[$current_tab] );
	if ( !class_exists( $class_name ) ) {
		$class_file = apply_filters( 'learning_online_settings_file_' . $current_tab, LP()->plugin_path( 'inc/admin/settings/class-lp-settings-' . $current_tab . '.php' ) );
		if ( !file_exists( $class_file ) ) {
			return false;
		}

		include_once $class_file;
		if ( !class_exists( $class_name ) ) {

		}
	}

	if ( learning_online_get_request( 'reset' ) == 'yes' && wp_verify_nonce( learning_online_get_request( '_wpnonce' ), 'learning-online-reset-settings' ) ) {
		global $wpdb;
		$sql = "
			DELETE FROM {$wpdb->options} WHERE option_name LIKE %s
		";
		$wpdb->query( $wpdb->prepare( $sql, $wpdb->esc_like( 'learning_online_' ) . '%' ) );
		wp_redirect( remove_query_arg( array( 'reset', '_wpnonce' ) ) );
		exit();
	}

	if ( !empty( $_POST ) ) {
		//	 Check if our nonce is set.
		if ( !isset( $_POST['learning_online_settings_nonce'] ) ) {
			return;
		}

		// Verify that the nonce is valid.
		if ( !wp_verify_nonce( $_POST['learning_online_settings_nonce'], 'learning_online_settings' ) ) {
			return;
		}

		do_action( 'learning_online_settings_save_' . $current_tab );

		$section = !empty( $_REQUEST['section'] ) ? '&section=' . $_REQUEST['section'] : '';
		LP_Admin_Notice::add( '<p><strong>' . __( 'Settings saved', 'learningonline' ) . '</strong></p>' );

		wp_redirect( admin_url( 'admin.php?page=learning-online-settings&tab=' . $current_tab . $section . '&settings-updated=true' ) );
		exit();
	}
}