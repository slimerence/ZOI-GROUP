<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a href="<?php the_permalink(); ?>" class="course-title">

	<?php do_action( 'learning_online_courses_loop_item_title' ); ?>

</a>
