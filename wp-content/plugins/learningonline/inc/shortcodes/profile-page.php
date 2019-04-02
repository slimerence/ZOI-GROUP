<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Shortcodes
 * @version 1.0
 */

defined( 'ABSPATH' ) || exit();

function learning_online_profile_shortcode() {
	global $wp_query;

	if ( isset( $wp_query->query['user'] ) ) {
		$user = get_user_by( 'login', urldecode( $wp_query->query['user'] ) );
	} else {
		$user = get_user_by( 'id', get_current_user_id() );
	}

	$output = '';
	if ( !$user ) {
		$output .= '<strong>' . __( 'This user is not available!', 'learningonline' ) . '</strong>';
		return $output;
	}

	do_action( 'learning_online_before_profile_content', $user );

	?>
	<div id="profile-tabs">
		<?php do_action( 'learning_online_add_profile_tab', $user ); ?>
	</div>
	<?php do_action( 'learning_online_after_profile_content', $user ); ?>
	<script>
		jQuery(document).ready(function ($) {
			$("#profile-tabs").tabs();
			$("#quiz-accordion").accordion();
		});
	</script>
	<?php
}

//add_shortcode( 'learning_online_profile', 'learning_online_profile_shortcode' );