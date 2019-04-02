<?php
/**
 * Template for displaying content of landing course
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<?php do_action( 'learning_online_before_content_landing' ); ?>

<div class="course-landing-summary">

	<?php do_action( 'learning_online_content_landing_summary' ); ?>

</div>

<?php do_action( 'learning_online_after_content_landing' ); ?>
