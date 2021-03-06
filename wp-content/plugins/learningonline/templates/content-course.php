<?php
/**
 * Template for displaying course content within the loop
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'learning_online_before_courses_loop_item' ); ?>

	<a href="<?php the_permalink();?>" class="course-title">

		<?php do_action( 'learning_online_courses_loop_item_title' ); ?>

	</a>

	<?php do_action( 'learning_online_after_courses_loop_item' ); ?>

</li>