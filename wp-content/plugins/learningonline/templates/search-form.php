<?php
/**
 * Template for displaying form to search courses
 *
 * @package LearningOnline/Templates
 * @author  JwsTheme
 * @version 2.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !( learning_online_is_courses() || learning_online_is_search() ) ) {
	return;
}
?>
<form method="get" name="search-course" class="learning-online-search-course-form">
	<input type="text" name="s" class="search-course-input" value="<?php echo $s; ?>" placeholder="<?php _e( 'Search course...', 'learningonline' ); ?>" />
	<input type="hidden" name="ref" value="course" />
	<button class="search-course-button"><?php _e( 'Search', 'learningonline' ); ?></button>
</form>
