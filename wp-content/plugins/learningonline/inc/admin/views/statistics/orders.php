<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$sections       = array(
	'students'    => __( 'Students', 'learningonline' ),
	'instructors' => __( 'Instructors', 'learningonline' ),
);

$section        = $this->section ? $this->section : 'students';
$sections_count = sizeof( $sections );
$count          = 0;
?>
<div id="learning-online-statistic" class="learning-online-statistic-orders">
	<ul class="subsubsub chart-buttons">
		<li>
			<button class="button" data-type="order-last-7-days" disabled="disabled"><?php _e( 'Last 7 Days', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="order-last-30-days"><?php _e( 'Last 30 Days', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="order-last-12-months"><?php _e( 'Last 12 Months', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="order-all"><?php _e( 'All', 'learningonline' ); ?></button>
		</li>
		<li>
			<form id="order-custom-time">
				<span><?php _e( 'From', 'learningonline' ) ?></span>
				<input type="text" placeholder="Y/m/d" name="from" class="date-picker" readonly="readonly">
				<span><?php _e( 'To', 'learningonline' ) ?></span>
				<input type="text" placeholder="Y/m/d" name="to" class="date-picker" readonly="readonly">
				<input type="hidden" name="action" value="learningonline_custom_stats">
				<button class="button button-primary" data-type="order-custom-time" type="submit" disabled="disabled"><?php _e( 'Go', 'learningonline' ); ?></button>
			</form>
		</li>
	</ul>
	<div class="clear"></div>
	<br/>
	<div id="chart-options">
		<?php _e( 'Sale by', 'learningonline' ); ?>
		<select id="report_sales_by">
			<option value="date"><?php _e( 'Date', 'learningonline' ); ?></option>
			<option value="course"><?php _e( 'Course', 'learningonline' ); ?></option>
			<option value="category"><?php _e( 'Course Category', 'learningonline' ); ?></option>
		</select>
		<span id="panel_report_sales_by_course" class="panel_report_option">
			<?php _e( 'Select a course', 'learningonline' );?>
			<input id="report-by-course-id" class="statistics-search-course" />
		</span>
		<span id="panel_report_sales_by_category" class="panel_report_option">
			<?php _e( 'Select a course category', 'learningonline' );?>
			<input id="report-by-course-category-id" class="statistics-search-course-category" />
		</span>
	</div>

	<div class="clear"></div>
	<ul class="chart-description">
		<li class="all"><span><?php _e( 'All', 'learningonline' ); ?></span></li>
		<li class="instructors"><span><?php _e( 'Completed', 'learningonline' ); ?></span></li>
		<li class="students"><span><?php _e( 'Pending', 'learningonline' ); ?></span></li>
	</ul>
	<div id="learning-online-chart" class="learning-online-chart">
	</div>

	<script type="text/javascript">
		var LP_Chart_Config =  <?php learning_online_config_chart();?>;
		jQuery(document).ready(function ($) {
			$('#learning-online-chart').LP_Chart_Line(<?php echo json_encode( learning_online_get_chart_orders( null, 'days', 7 ) );?>, LP_Chart_Config);
		});
	</script>
</div>

