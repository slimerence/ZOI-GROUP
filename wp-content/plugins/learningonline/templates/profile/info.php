<?php
/**
 * User Information
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
global $wp_query;

$tabs         = learning_online_user_profile_tabs( $user );
$current      = learning_online_get_current_profile_tab();
$profile_link = learning_online_get_page_link( 'profile' );
$cuser        = learning_online_get_current_user();
if ( !empty( $tabs ) && !empty( $tabs[$current] ) ) : ?>
	<div class="user-info" id="learning-online-user-info">
		<span class="user-avatar"><?php echo $user->get_profile_picture(); ?></span>
		<div class="user-basic-info">
			<strong class="user-nicename"><?php echo learning_online_get_profile_display_name( $user ); ?></strong>
			<?php if ( $description = get_user_meta( $user->id, 'description', true ) ): ?>
				<p class="user-bio"><?php echo get_user_meta( $user->id, 'description', true ); ?></p>
			<?php endif; ?>
			<?php if ( $cuser->id == $user->ID ): ?>
				<p>
					<a href="<?php echo esc_url( wp_logout_url() ); ?>"><?php _e( 'Logout', 'learningonline' ) ?></a>
				</p>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>