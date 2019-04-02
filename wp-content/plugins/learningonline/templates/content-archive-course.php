<?php
/**
 * Template for displaying archive course content
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.0.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $wp_query, $lp_tax_query;
?>
<?php do_action( 'learning_online_before_main_content' ); ?>

<?php do_action( 'learning_online_archive_description' ); ?>

<?php if ( LP()->wp_query->have_posts() ) : ?>

	<?php do_action( 'learning_online_before_courses_loop' ); ?>

	<?php learning_online_begin_courses_loop(); ?>


	<?php while ( LP()->wp_query->have_posts() ) : LP()->wp_query->the_post(); ?>

		<?php learning_online_get_template_part( 'content', 'course' ); ?>

	<?php endwhile; ?>

	<?php learning_online_end_courses_loop(); ?>

	<?php do_action( 'learning_online_after_courses_loop' ); ?>
<?php else: ?>
	<?php learning_online_display_message( __( 'No course found.', 'learningonline' ), 'error' ); ?>
<?php endif; ?>

<?php do_action( 'learning_online_after_main_content' ); ?>
