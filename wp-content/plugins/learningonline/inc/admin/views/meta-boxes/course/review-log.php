<?php
global $post;
if ( get_post_type() != 'lp_course' ) {
	return;
}
if ( !learning_online_course_is_required_review( $post->ID, get_current_user_id() ) ) {
	//return;
}
$user                  = learning_online_get_current_user();
$course_user           = learning_online_get_user( get_post_field( 'post_author', $post->ID ) );
$required_review       = LP()->settings->get( 'required_review' ) == 'yes';
$enable_edit_published = LP()->settings->get( 'enable_edit_published' ) == 'yes';
$pending_review        = 'yes' == get_post_meta( $post->ID, '_lp_submit_for_reviewer', true );
$edited                = get_post_meta( $post->ID, '_edit_last', true );
$status                = get_post_status();
?>
<div id="learning-online-review-message">
	<input type="hidden" id="learning-online-course-status" value="<?php echo get_post_status(); ?>" />
	<input type="hidden" name="learning-online-course-pending-review" value="<?php echo $pending_review ? 'yes' : 'no'; ?>" />
	<?php if ( $user->is_instructor() ): ?>

		<?php if ( $status != 'publish' ) { ?>
			<?php if ( $required_review ) { ?>
				<?php if ( $pending_review ) { ?>
					<p class="lp-pending-review-message"><?php _e( 'Your course is pending for reviewing', 'learningonline' ); ?></p>
				<?php } else { ?>
					<p class="lp-pending-review-message"><?php _e( 'Your course will not be submitted for reviewing until you check \'Submit for Review\'', 'learningonline' ); ?></p>
					<p>
						<label>
							<input type="checkbox" name="learning-online-submit-for-review" value="yes" />
							<?php _e( 'Submit for Review', 'learningonline' ); ?>
						</label>
					</p>
					<textarea class="widefat hide-if-js" rows="5" id="review-message" name="review-message" resize="none" placeholder="<?php _e( 'Message to Reviewer', 'learningonline' ); ?>"></textarea>
				<?php } ?>
			<?php } ?>
		<?php } else { ?>
			<?php if ( $required_review && !$enable_edit_published ) { ?>
				<p class="description submitdelete">
					<?php _e( 'Warning! Your course will become Pending Review for admins to review before it can be published when you update.' ); ?>
				</p>
				<textarea class="widefat" rows="5" id="review-message" name="review-message" resize="none" placeholder="<?php _e( 'Message to Reviewer', 'learningonline' ); ?>"></textarea>
			<?php } ?>
		<?php } ?>
	<?php elseif ( $user->is_admin() && !$course_user->is_admin() ): ?>

		<?php if ( $status != 'publish' ) { ?>
			<p class="lp-pending-review-message"><?php _e( 'This course is pending for reviewing', 'learningonline' ); ?></p>
		<?php } ?>

		<textarea class="widefat" rows="5" name="review-message" resize="none" placeholder="<?php _e( 'Message to Instructor', 'learningonline' ); ?>"></textarea>
	<?php endif; ?>
</div>

