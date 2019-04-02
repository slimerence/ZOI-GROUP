<?php
/**
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 2.1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$user        = learning_online_get_current_user();
$course      = LP()->global['course'];
$viewable    = learning_online_user_can_view_quiz( $item->ID, $course->id );//learning_online_is_enrolled_course();
$tag         = $viewable ? 'a' : 'span';
$target      = apply_filters( 'learning_online_section_item_link_target', '_blank', $item );
$item_title  = apply_filters( 'learning_online_section_item_title', get_the_title( $item->ID ), $item );
$item_link   = $viewable ? 'href="' . $course->get_item_link( $item->ID ) . '"' : '';
$item_status = $user->get_item_status( $item->ID );
$result      = $user->get_quiz_results( $item->ID );
$has_result  = false;
if ( in_array( $item_status, array( 'completed', 'started' ) ) ) {
	$has_result = true;
}
$class = '';
if ( $has_result ) {
	$class = 'item-has-result';
}
?>

<li <?php learning_online_course_item_class( $item->ID, $course->id, $class ); ?> data-type="<?php echo $item->post_type; ?>">
	<?php do_action( 'learning_online_before_section_item_title', $item, $section, $course ); ?>

	<?php
	printf(
		'<%s class="%s" target="%s" data-id="%d" %s>%s</%s>',
		$tag,
		'course-item-title button-load-item',
		$target,
		$item->ID,
		$item_link,
		$item_title,
		$tag
	);
	?>
	<!--<<?php echo $tag; ?> class="course-item-title button-load-item" target="<?php echo $target; ?>" <?php echo $item_link; ?> data-id="<?php echo $item->ID; ?>"><?php echo $item_title ?></<?php echo $tag; ?>>-->
	<?php do_action( 'learning_online_after_section_item_title', $item, $section, $course ); ?>
</li>