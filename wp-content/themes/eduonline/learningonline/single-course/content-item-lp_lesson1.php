<?php
/**
 * Template for display content of lesson
 *
 * @author  JwsThemes
 * @version 2.0.7
 */
global $lp_query, $wp_query;
$user          = learning_online_get_current_user();
$course        = LP()->global['course'];
$item          = LP()->global['course-item'];
$security      = wp_create_nonce( sprintf( 'complete-item-%d-%d-%d', $user->id, $course->id, $item->ID ) );
$can_view_item = $user->can( 'view-item', $item->id, $course->id );
?>
<h2 class="learning-online-content-item-title">
	<a href="" class="lp-expand dashicons-editor-expand dashicons"></a>
	<?php echo $item->get_title(); ?>
</h2>
<div class="learning-online-content-item-summary">

	<?php learning_online_get_template( 'content-lesson/description.php' ); ?>

	<?php if ( $user->has_completed_lesson( $item->ID, $course->id ) ) { ?>
		<button class="" disabled="disabled"> <?php _e( 'Completed', 'learningonline' ); ?></button>
	<?php } else if ( !$user->has( 'finished-course', $course->id ) && !in_array( $can_view_item, array( 'preview', 'no-required-enroll' ) ) ) { ?>

		<form method="post" name="learning-online-form-complete-lesson" class="learning-online-form">
			<input type="hidden" name="id" value="<?php echo $item->id; ?>" />
			<input type="hidden" name="course_id" value="<?php echo $course->id; ?>" />
			<input type="hidden" name="security" value="<?php echo esc_attr( $security ); ?>" />
			<input type="hidden" name="type" value="lp_lesson" />
			<input type="hidden" name="lp-ajax" value="complete-item" />
			<button class="button-complete-item button-complete-lesson"><?php echo __( 'Complete', 'learningonline' ); ?></button>

		</form>
	<?php } ?>

	<?php learning_online_lesson_comment_form( $item->id ); ?>
</div>
<?php LP_Assets::enqueue_script( 'learning-online-course-lesson' ); ?>

<?php LP_Assets::add_var( 'LP_Lesson_Params', wp_json_encode( $item->get_settings( $user->id, $course->id ) ), '__all' ); ?>
