<?php
/**
 * Display settings for pages
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
	<?php do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	<?php foreach( $this->_get_settings( 'become_a_teacher' ) as $field ){?>
		<?php $this->output_field( $field );?>
	<?php }?>
	<?php do_action( 'learning_online_after_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	</tbody>
</table>