<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       2.1.5
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user = learning_online_get_current_user();
?>
<?php if ( learning_online_is_course() ): ?>
<div id="lp-single-course" class="lp-single-course">
	<?php if ( !learning_online_get_page_link( 'checkout' ) && ( $user->is_admin() || $user->is_instructor() ) ) { ?>
		<?php
		$message = __( 'LearningOnline <strong>Checkout</strong> page is not set up. ', 'learningonline' );
		if ( $user->is_instructor() ) {
			$message .= __( 'Please contact to administrator for setting up this page.', 'learningonline' );
		} else {
			$message .= sprintf( __( 'Please <a href="%s" target="_blank">setup</a> it so user can purchase a course.', 'learningonline' ), admin_url( 'admin.php?page=learning-online-settings&tab=checkout' ) );
		}
		?>
		<?php learning_online_display_message( $message, 'error' ); ?>

	<?php } ?>
	<?php else: ?>
	<div id="lp-archive-courses" class="lp-archive-courses">
		<?php endif; ?>
