<?php
/**
 * Template for displaying user profile
 *
 * @author JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="learning-online-user-profile" id="learning-online-user-profile">

	<?php
	do_action( 'learning_online_user_profile_summary', $user, $current, $tabs );
	?>

</div>