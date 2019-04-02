<?php
/**
 * Display settings for course
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$settings = LP_Settings::instance();
?>
<h3 class=""><?php echo $this->section['title']; ?></h3>
<table class="form-table">
	<tbody>
	<?php
		do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings );
		$this->output_settings();
		do_action( 'learning_online_after_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings );
	?>
	</tbody>
</table>
<script type="text/javascript">
	jQuery(function ($) {
		$('input.learning-online-course-base').change(function () {
			$('#course_permalink_structure').val($(this).val());
		});

		$('#course_permalink_structure').focus(function () {
			$('#learning_online_custom_permalink').click();
		});

		$('#learning_online_courses_page_id').change(function () {
			$('tr.learning-online-courses-page-id').toggleClass('hide-if-js', !parseInt(this.value))
		});
	});
</script>