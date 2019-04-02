<?php
/**
 * @author        JwsTheme
 * @package       LearningOnline/Templates
 * @version       2.1.6
 */

defined( 'ABSPATH' ) || exit();

$course = LP()->global['course'];
$user   = learning_online_get_current_user();
if ( !$course ) {
	return;
}
$status = $user->get( 'course-status', $course->id );
if ( !$status || !$user->has_purchased_course( $course->id ) ) {
	return;
}
$force             = isset( $force ) ? $force : false;
$num_of_decimal    = 0;
$result            = $course->evaluate_course_results( null, $force );
$current           = absint( $result );
$passing_condition = round( $course->passing_condition, $num_of_decimal );
$passed            = $current >= $passing_condition;
$heading           = apply_filters( 'learning_online_course_progress_heading', $status == 'finished' ? __( 'Your results', 'learningonline' ) : __( 'Learning progress', 'learningonline' ) );
$course_items      = sizeof( $course->get_curriculum_items() );
$completed_items   = $course->count_completed_items();
$course_results    = $course->evaluate_course_results();
?>
<div class="learning-online-course-results-progress">
	<div class="items-progress">
		<?php if ( $heading !== false ): ?>
			<h4 class="lp-course-progress-heading"><?php echo esc_html_e( 'Items completed', 'learningonline' ); ?></h4>
		<?php endif; ?>
		<span class="number"><?php printf( __( '%d of %d items', 'learningonline' ), $completed_items, $course_items ); ?></span>
		<div class="lp-course-progress">
			<div class="lp-progress-bar">
				<div class="lp-progress-value"
					 style="width: <?php echo $course_items ? absint( $completed_items / $course_items * 100 ) : '0'; ?>%;">
				</div>
			</div>
		</div>

	</div>
	<div class="course-progress">
		<h4 class="lp-course-progress-heading">
			<?php esc_html_e( 'Course results', 'learningonline' ); ?>
			<?php if ( $tooltip = learning_online_get_course_results_tooltip( $course->id ) ) { ?>
				<span class="learning-online-tooltip" data-content="<?php echo esc_html( $tooltip ); ?>"></span>
			<?php } ?>
		</h4>
		<div class="lp-course-status">
			<span class="number"><?php echo $current; ?><span class="percentage-sign">%</span></span>
			<?php if ( $grade = $user->get_course_grade( $course->id ) ) { ?>
				<span class="grade <?php echo esc_attr( $grade ); ?>">
				<?php learning_online_course_grade_html( $grade ); ?>
				</span>
			<?php } ?>
		</div>
		<div class="lp-course-progress <?php echo $passed ? ' passed' : ''; ?>" data-value="<?php echo $current; ?>"
			 data-passing-condition="<?php echo $passing_condition; ?>">
			<div class="lp-progress-bar">
				<div class="lp-progress-value" style="width: <?php echo $current; ?>%;">
				</div>
			</div>
			<div class="lp-passing-conditional"
				 data-content="<?php printf( esc_html__( 'Passing condition: %s%%', 'learningonline' ), $passing_condition ); ?>"
				 style="left: <?php echo $passing_condition; ?>%;">
			</div>
		</div>
	</div>
</div>