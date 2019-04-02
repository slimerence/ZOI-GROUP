<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user         = learning_online_get_current_user();
$course       = learning_online_get_the_course();
$section_name = apply_filters( 'learning_online_curriculum_section_name', $section->section_name, $section );
$force        = isset( $force ) ? $force : false;

if ( $section_name === false ) {
	return;
}
?>
<h4 class="section-header">
	<?php echo $section_name; ?>&nbsp;
	<?php if ( $section_description = apply_filters( 'learning_online_curriculum_section_description', $section->section_description, $section ) ) { ?>
		<p><?php echo $section_description; ?></p>
	<?php } ?>
	<span class="meta">
            <span class="step"><?php printf( __( '%d/%d', 'learningonline' ), $user->get_completed_items_in_section( $course->id, $section->section_id, $force ), sizeof( $section->items ) ); ?></span>
            <span class="collapse"></span>
        </span>
</h4>
