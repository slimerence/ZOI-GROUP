<?php
/**
 * Display general settings for emails
 *
 * @author  JwsTheme
 * @package LearningOnline/Admin/Views/Emails
 * @version 1.0
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$settings = LP()->settings;
?>
<h3><?php _e( 'User order changed status', 'learningonline' ); ?></h3>
<p class="description">
	<?php _e( 'Send email to user when the order is changed status.', 'learningonline' ); ?>
</p>
<table class="form-table">
	<tbody>
	<?php do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-order-enable"><?php _e( 'Enable', 'learningonline' ); ?></label></th>
		<td>
			<input type="hidden" name="<?php echo $settings_class->get_field_name( 'emails_user_order_changed_status[enable]' ); ?>" value="no" />
			<input id="learning-online-emails-new-order-enable" type="checkbox" name="<?php echo $settings_class->get_field_name( 'emails_user_order_changed_status[enable]' ); ?>" value="yes" <?php checked( $settings->get( 'emails_user_order_changed_status.enable' ) == 'yes' ); ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-order-subject"><?php _e( 'Subject', 'learningonline' ); ?></label></th>
		<td>
			<?php $default = $this->default_subject; ?>
			<input id="learning-online-emails-new-order-subject" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_user_order_changed_status[subject]' ); ?>" value="<?php echo $settings->get( 'emails_user_order_changed_status.subject', $default ); ?>" />

			<p class="description">
				<?php printf( __( 'Email subject, default: <code>%s</code>', 'learningonline' ), $default ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-order-heading"><?php _e( 'Heading', 'learningonline' ); ?></label></th>
		<td>
			<?php $default = $this->default_heading; ?>
			<input id="learning-online-emails-new-order-heading" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_user_order_changed_status[heading]' ); ?>" value="<?php echo $settings->get( 'emails_user_order_changed_status.heading', $default ); ?>" />

			<p class="description">
				<?php printf( __( 'Email heading, default: <code>%s</code>', 'learningonline' ), $default ); ?>
			</p>
		</td>
	</tr>
	<!--<tr>
		<th scope="row">
			<label for="learning-online-emails-new-order-email-format"><?php _e( 'Email format', 'learningonline' ); ?></label>
		</th>
		<td>
			<?php learning_online_email_formats_dropdown( array( 'name' => $settings_class->get_field_name( 'emails_user_order_changed_status[email_format]' ), 'id' => 'learning_online_email_formats', 'selected' => $settings->get( 'emails_user_order_changed_status.email_format', $default ) ) ); ?>
		</td>
	</tr>-->
	<?php
	$view = learning_online_get_admin_view( 'settings/emails/email-template.php' );
	include_once $view;
	?>
	<?php do_action( 'learning_online_after_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	</tbody>
</table>