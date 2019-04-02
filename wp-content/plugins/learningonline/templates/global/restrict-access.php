<?php
/**
 * The template for displaying single course content
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header(); ?>

<?php do_action( 'learning_online_before_main_content' ); ?>

<div class="restrict-access-page">
	<?php learning_online_display_message( __( 'You have no permission to view this area. Please contact site\'s administrators for more details.', 'learningonline' ) ); ?>
</div>

<?php do_action( 'learning_online_after_main_content' ); ?>

<?php get_footer(); ?>
