<?php
/**
 * Template for displaying user profile
 *
 * @author ThimPress
 * @package LearningOnline/Templates
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="learning-online-user-profile" id="learning-online-user-profile">
	<div class="container">

		<?php
		do_action( 'learning_online_user_profile_summary', $user, $current, $tabs );
		?>

	</div>
</div>