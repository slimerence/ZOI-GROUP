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

gmdate( 'Y-m-d H:i:s', ( time() + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS ) ) );
$now		= current_time( 'timestamp' );
$now_mysql	= current_time( 'mysql' );
$last_sunday		= strtotime('Last Sunday', $now );

$last_sunday_sql	= gmdate( 'Y-m-d H:i:s', $last_sunday );

$pre_sunday = strtotime('-7 day',$last_sunday);
$pre_sunday_sql	= gmdate( 'Y-m-d H:i:s', $pre_sunday );

learning_online_get_chart_general( null, 'days', 7 );

?>
<div id="learning-online-statistic" class="learning-online-statistic-courses">
	<ul class="subsubsub chart-buttons">
		<li>
			<button class="button" data-type="course-last-7-days" disabled="disabled"><?php _e( 'Last 7 Days', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="course-last-30-days"><?php _e( 'Last 30 Days', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="course-last-12-months"><?php _e( 'Last 12 Months', 'learningonline' ); ?></button>
		</li>
		<li>
			<button class="button" data-type="course-all"><?php _e( 'All', 'learningonline' ); ?></button>
		</li>
		<li>
			<form id="course-custom-time">
				<span><?php _e( 'From', 'learningonline' ) ?></span>
				<input type="text" placeholder="Y/m/d" name="from" class="date-picker" readonly="readonly">
				<span><?php _e( 'To', 'learningonline' ) ?></span>
				<input type="text" placeholder="Y/m/d" name="to" class="date-picker" readonly="readonly">
				<input type="hidden" name="action" value="learningonline_custom_stats">
				<button class="button button-primary" data-type="course-custom-time" type="submit" disabled="disabled"><?php _e( 'Go', 'learningonline' ); ?></button>
			</form>
		</li>
	</ul>
	<div class="clear"></div>
	<ul class="chart-description">
		<li class="all"><span><?php _e( 'All', 'learningonline' ); ?></span></li>
		<li class="free"><span><?php _e( 'Public', 'learningonline' ); ?></span></li>
		<li class="paid"><span><?php _e( 'Pending', 'learningonline' ); ?></span></li>
		<li class="all"><span><?php _e( 'Paid', 'learningonline' ); ?></span></li>
		<li class="free"><span><?php _e( 'Free', 'learningonline' ); ?></span></li>
	</ul>
	<div id="learning-online-chart" class="learning-online-chart">
	</div>

	<script type="text/javascript">
		var LP_Chart_Config =  <?php learning_online_config_chart();?>;
		jQuery(document).ready(function ($) {
			$('#learning-online-chart').LP_Chart_Line(<?php echo json_encode( learning_online_get_chart_general( null, 'days', 7 ) );?>, LP_Chart_Config);
		});
	</script>
</div>

