<?php
/**
 * Template for displaying the enroll button
 *
 * @author  ThimPress
 * @package learningonline/Templates
 * @version 2.1.6
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];
//print_r($course);

if ( !$course->is_required_enroll() ) {
	return;
}

$course_status = learning_online_get_user_course_status();
$user          = learning_online_get_current_user();
$in_cart       = learning_online_is_added_to_cart( $course->id );
// only show enroll button if user had not enrolled
$purchase_button_text  = apply_filters( 'learning_online_purchase_button_text', __( 'Start this course', 'learningonline' ) );
$enroll_button_text    = apply_filters( 'learning_online_enroll_button_text', __( 'Enroll', 'learningonline' ) );
$retake_button_text    = apply_filters( 'learning_online_retake_button_text', __( 'Retake', 'learningonline' ) );
$notice_enough_student = apply_filters( 'learning_online_course enough students_notice', __( 'The class is full so the enrollment is close. Please contact the site admin.', 'learningonline' ) );
?>
<div class="learning-online-course-buttons">

	<?php do_action( 'learning_online_before_course_buttons', $course->id ); ?>

	<?php

	# -------------------------------
	# Finished Course
	# -------------------------------
	if ( $user->has( 'finished-course', $course->id ) ): ?>
		<?php if ( $count = $user->can( 'retake-course', $course->id ) ): ?>
            <button
                class="button button-retake-course"
                data-course_id="<?php echo esc_attr( $course->id ); ?>"
                data-security="<?php echo esc_attr( wp_create_nonce( sprintf( 'learning-online-retake-course-%d-%d', $course->id, $user->id ) ) ); ?>">
				<?php echo esc_html( sprintf( __( 'Retake course (+%d)', 'learningonline' ), $count ) ); ?>
            </button>
		<?php endif; ?>
		<?php

	# -------------------------------
	# Enrolled Course
	# -------------------------------
	elseif ( $user->has( 'enrolled-course', $course->id ) ): ?>
		<?php
		$can_finish = $user->can_finish_course( $course->id );
		//if ( $can_finish ) {
		$finish_course_security = wp_create_nonce( sprintf( 'learning-online-finish-course-' . $course->id . '-' . $user->id ) );
		//} else {
		//$finish_course_security = '';
		//}
		?>
        <button
            id="learning-online-finish-course"
            class="button-finish-course<?php echo !$can_finish ? ' hide-if-js' : ''; ?>"
            data-id="<?php echo esc_attr( $course->id ); ?>"
            data-security="<?php echo esc_attr( $finish_course_security ); ?>">
			<?php esc_html_e( 'Finish course', 'learningonline' ); ?>
        </button>
	<?php elseif ( $user->can( 'enroll-course', $course->id ) === true ) : ?>
        <?php if (false) :?>
            <form name="enroll-course" class="enroll-course" method="post" enctype="multipart/form-data">
                <?php do_action( 'learning_online_before_enroll_button' ); ?>

                <input type="hidden" name="lp-ajax" value="enroll-course" />
                <input type="hidden" name="enroll-course" value="<?php echo $course->id; ?>" />
                <button class="button enroll-button" data-block-content="yes"><?php echo $enroll_button_text; ?></button>

                <?php do_action( 'learning_online_after_enroll_button' ); ?>
            </form>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="button enroll-button">
            <?php do_action( 'learning_online_before_enroll_button' ); ?>
            <?php echo $enroll_button_text; ?>
            <?php do_action( 'learning_online_after_enroll_button' ); ?>
        </a>

	<?php elseif ( $user->can( 'purchase-course', $course->id ) ) : ?>
        <form name="purchase-course" class="purchase-course" method="post" enctype="multipart/form-data">
			<?php do_action( 'learning_online_before_purchase_button' ); ?>
            <button class="button purchase-button" data-block-content="yes">
				<?php echo $course->is_free() ? $enroll_button_text : $purchase_button_text; ?>
            </button>
			<?php do_action( 'learning_online_after_purchase_button' ); ?>
            <input type="hidden" name="purchase-course" value="<?php echo $course->id; ?>" />
        </form>

	<?php elseif ( $user->can( 'enroll-course', $course->id ) === 'enough' ) : ?>
        <p class="learning-online-message"><?php echo $notice_enough_student; ?></p>

	<?php else: ?>
		<?php $order_status = $user->get_order_status( $course->id ); ?>
		<?php if ( in_array( $order_status, array( 'lp-pending', 'lp-refunded', 'lp-cancelled', 'lp-failed' ) ) ) { ?>
            <form name="purchase-course" class="purchase-course" method="post" enctype="multipart/form-data">
				<?php do_action( 'learning_online_before_purchase_button' ); ?>
                <button class="button purchase-button" data-block-content="yes">
					<?php echo $course->is_free() ? $enroll_button_text : $purchase_button_text; ?>
                </button>
				<?php do_action( 'learning_online_after_purchase_button' ); ?>
                <input type="hidden" name="purchase-course" value="<?php echo $course->id; ?>" />
            </form>
		<?php } elseif ( in_array( $order_status, array( 'lp-processing', 'lp-on-hold' ) ) ) { ?>
			<?php learning_online_display_message( '<p>' . apply_filters( 'learning_online_user_course_pending_message', __( 'You have purchased this course. Please wait for approval.', 'learningonline' ), $course, $user ) . '</p>' ); ?>
		<?php } elseif ( $order_status && $order_status != 'lp-completed' ) { ?>
			<?php learning_online_display_message( '<p>' . apply_filters( 'learning_online_user_can_not_purchase_course_message', __( 'Sorry, you can not purchase this course', 'learningonline' ), $course, $user ) . '</p>' ); ?>
		<?php } ?>
	<?php endif; ?>

	<?php do_action( 'learning_online_after_course_buttons', $course->id ); ?>

</div>