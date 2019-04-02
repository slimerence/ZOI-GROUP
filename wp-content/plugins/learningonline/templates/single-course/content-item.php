<?php
/**
 * Display content item
 *
 * @author  JwsTheme
 * @version 2.1.7
 */
$course = learning_online_get_the_course();
$item   = LP()->global['course-item'];
$user   = learning_online_get_current_user();
if ( ! $item ) {
	return;
}
$item_id = isset( $item->id ) ? $item->id : ( isset( $item->ID ) ? $item->ID : 0 );
?>
<div id="learning-online-content-item">
	<?php do_action( 'learning_online/before_course_item_content', $item_id, $course->id ); ?>
	<?php if ( $item ) { ?>
		<?php if ( $user->can( 'view-item', $item->id, $course->id ) ) { ?>

			<?php do_action( 'learning_online_course_item_content', $item ); ?>

		<?php } else { ?>

			<?php learning_online_get_template( 'single-course/content-protected.php', array( 'item' => $item ) ); ?>

		<?php } ?>

	<?php } ?>
	<?php //do_action( 'learning_online_after_content_item', $item_id, $course->id, true ); ?>
	<?php do_action( 'learning_online/after_course_item_content', $item_id, $course->id ); ?>

</div>