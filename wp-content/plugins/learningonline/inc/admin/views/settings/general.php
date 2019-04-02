<?php
/**
 * Display html for general settings
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$settings = LP()->settings;
?>

<table class="form-table">
	<tbody>
	<?php
		do_action( 'learning_online_before_general_settings_fields', $settings );
		$this->output_settings();
	?>
	</tbody>
</table>
