<?php
/**
 * @author  JwsThemes
 * @package LearningOnline/Templates
 * @version 2.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
} ?>

<a href="<?php the_permalink(); ?>" class="course-title">

	<?php 
		if(has_post_thumbnail()){
			the_post_thumbnail('lo_course_thumbnail');
		}
		echo jws_theme_title_render(); 

	?>
</a>
