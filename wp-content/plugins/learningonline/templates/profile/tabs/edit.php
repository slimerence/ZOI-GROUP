<?php
/**
 * User Information
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.1.6
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

$user                    = learning_online_get_current_user();
$user_info               = get_userdata( $user->id );
$username                = $user_info->user_login;
$nick_name               = $user_info->nickname;
$first_name              = $user_info->first_name;
$last_name               = $user_info->last_name;
$profile_picture_type    = $user->profile_picture ? 'picture' : 'gravatar';
$profile_picture         = $user->profile_picture;
$class_gravatar_selected = ( 'gravatar' === $profile_picture_type ) ? ' lp-menu-item-selected' : '';
$class_picture_selected  = ( 'picture' === $profile_picture_type ) ? ' lp-menu-item-selected' : '';
$section                 = !empty( $_REQUEST['section'] ) ? $_REQUEST['section'] : 'basic-information';
$url_tab                 = learning_online_user_profile_link( $user->id, $current );

$edit_tabs = array(
	'basic-information' => __( 'Basic Information', 'learningonline' ),
	'avatar'            => __( 'Avatar', 'learningonline' ),
	'change-password'   => __( 'Change Password', 'learningonline' ),
);
$first_tab = 'basic-information';
?>
	<div id="lp-user-profile-form" class="lp-user-profile-form">
		<form method="post" name="lp-edit-profile">
			<ul class="learning-online-subtabs">
				<?php foreach ( $edit_tabs as $sub_key => $title ): ?>
					<?php
					$classes = array();
					if ( ( $section && $section == $sub_key ) || ( !$section && $sub_key == $first_tab ) ) {
						$classes[] = 'current';
					} ?>
					<li class="<?php echo join( ' ', $classes ); ?>">
						<?php if ( in_array( 'current', $classes ) ) { ?>
							<span><?php echo esc_html( $title ); ?></span>
						<?php } else { ?>
							<a href="<?php echo esc_url( add_query_arg( 'section', $sub_key, $url_tab ) ); ?>"><?php echo esc_html( $title ); ?></a>
						<?php } ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<div class="learning-online-subtab-content user-profile-section-content">
				<?php
				$section_template = learning_online_locate_template( 'profile/tabs/edit/' . $section . '.php' );
				if ( $section && file_exists( $section_template ) ) {
					?>
					<?php include $section_template; ?>
					<input type="hidden" name="lp-profile-section" value="<?php echo $section; ?>" />
				<?php } else {
					?>
					<?php learning_online_display_message( __( 'The section you are trying to access does not exists.', 'learningonline' ) ); ?>
				<?php } ?>
			</div>

			<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user->id ); ?>" />
			<input type="hidden" name="profile-nonce" value="<?php echo esc_attr( wp_create_nonce( 'learning-online-update-user-profile-' . $user->id ) ); ?>" />
			<p class="submit update-profile">
				<input disabled="disabled" type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Update', 'learningonline' ); ?>" />
			</p>
		</form>
	</div>
<?php
