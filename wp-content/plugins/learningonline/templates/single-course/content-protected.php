<?php
/**
 * Template for displaying message for content protected
 *
 * @author  JwsTheme
 * @version 1.1
 */
?>
<div class="learning-online-content-protected-message">
	<span class="icon"></span>
	<?php
		echo apply_filters(
			'learning_online_content_item_protected_message',
			sprintf( __( 'This content is protected, please <a href="%s">login</a> and enroll course to view this content', 'learningonline' ), learning_online_get_login_url( learning_online_get_current_url() ) ) ,
			$item
		); ?>
</div>