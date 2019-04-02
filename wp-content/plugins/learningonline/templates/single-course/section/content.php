<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/* section item display inside a section */
$learningonline_course_sections = learning_online_get_course_sections();
?>

<ul class="section-content">

	<?php if ( !empty( $section->items ) ) { ?>

	<?php
	foreach ( $section->items as $item ) {
		$post_type = str_replace( 'lp_', '', $item->post_type );

		if ( ! in_array( $item->post_type, $learningonline_course_sections ) ) continue;

		$args = array(
			'item'    => $item,
			'section' => $section
		);
		learning_online_get_template( "single-course/section/item-{$post_type}.php", $args );
	}
	?>
	<?php } else { ?>

		<li class="course-item section-empty"><?php learning_online_display_message( __( 'No items in this section', 'learningonline' ) );?></li>

	<?php } ?>
</ul>
