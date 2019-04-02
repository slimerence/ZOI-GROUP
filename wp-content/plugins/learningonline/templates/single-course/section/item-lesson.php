<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$course = LP()->global['course'];
$viewable = learning_online_user_can_view_lesson( $item->ID, $course->id );//learning_online_is_enrolled_course();
$tag      = $viewable ? 'a' : 'span';
$target   = apply_filters( 'learning_online_section_item_link_target', '_blank', $item );
$item_title = apply_filters( 'learning_online_section_item_title', get_the_title( $item->ID ), $item );
$item_link = $viewable ? 'href="' . $course->get_item_link( $item->ID ) . '"' : '';
?>

<li <?php learning_online_course_item_class( $item->ID ); ?> data-type="<?php echo $item->post_type; ?>">
	<?php do_action( 'learning_online_before_section_item_title', $item, $section, $course ); ?>
	<<?php echo $tag; ?> class="course-item-title button-load-item" target="<?php echo $target; ?>" <?php echo $item_link; ?> data-id="<?php echo $item->ID; ?>" data-complete-nonce="<?php echo wp_create_nonce( 'learning-online-complete-' . $item->post_type . '-' . $item->ID ); ?>"><?php echo $item_title; ?></<?php echo $tag; ?>>
	<?php do_action( 'learning_online_after_section_item_title', $item, $section, $course ); ?>
</li>
