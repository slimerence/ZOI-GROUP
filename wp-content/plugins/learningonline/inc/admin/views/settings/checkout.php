<?php
/**
 * Display settings for checkout
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
		do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $this );
		$this->output_settings();
	?>
	</tbody>

</table>