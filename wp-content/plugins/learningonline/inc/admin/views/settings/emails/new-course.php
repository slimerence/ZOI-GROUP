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

$settings_class = $obj;
$settings       = LP()->settings;
?>
<h3><?php _e( 'New course for review', 'learningonline' ); ?></h3>
<p class="description">
	<?php _e( 'Email settings when a new course is submitted for review.', 'learningonline' ); ?>
</p>
<table class="form-table">
	<tbody>
	<?php do_action( 'learning_online_before_' . $settings_class->id . '_' . $settings_class->section['id'] . '_settings_fields', $settings ); ?>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-course-enable"><?php _e( 'Enable', 'learningonline' ); ?></label></th>
		<td>
			<input type="hidden" name="<?php echo $settings_class->get_field_name( 'emails_new_course[enable]' ); ?>" value="no" />
			<input id="learning-online-emails-new-course-enable" type="checkbox" name="<?php echo $settings_class->get_field_name( 'emails_new_course[enable]' ); ?>" value="yes" <?php checked( $settings->get( 'emails_new_course.enable' ) == 'yes' ); ?>" />
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-course-recipients"><?php _e( 'Recipient(s)', 'learningonline' ); ?></label>
		</th>
		<td>
			<?php $default = get_option( 'admin_email' ); ?>
			<input id="learning-online-emails-new-course-recipients" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_new_course[recipient]' ); ?>" value="<?php echo $settings->get( 'emails_new_course.recipient', $default ); ?>" />

			<p class="description">
				<?php printf( __( 'Email recipient(s), default: <code>%s</code>', 'learningonline' ), $default ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-course-subject"><?php _e( 'Subject', 'learningonline' ); ?></label></th>
		<td>
			<input id="learning-online-emails-new-course-subject" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_new_course[subject]' ); ?>" value="<?php echo $settings->get( 'emails_new_course.subject', $this->default_subject ); ?>" />

			<p class="description">
				<?php printf( __( 'Email subject (separated by comma), default: <code>%s</code>', 'learningonline' ), $this->default_subject ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-new-course-heading"><?php _e( 'Heading', 'learningonline' ); ?></label></th>
		<td>
			<?php $default = __( 'New course', 'learningonline' ); ?>
			<input id="learning-online-emails-new-course-heading" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_new_course[heading]' ); ?>" value="<?php echo $settings->get( 'emails_new_course.heading', $this->default_heading ); ?>" />

			<p class="description">
				<?php printf( __( 'Email subject, default: <code>%s</code>', 'learningonline' ), $this->default_heading ); ?>
			</p>
		</td>
	</tr>
	<!--<tr>
		<th scope="row">
			<label for="learning-online-emails-new-course-email-format"><?php _e( 'Email format', 'learningonline' ); ?></label>
		</th>
		<td>
			<?php learning_online_email_formats_dropdown( array( 'name' => $settings_class->get_field_name( 'emails_new_course[email_format]' ), 'id' => 'learning_online_email_formats', 'selected' => $settings->get( 'emails_new_course.email_format' ) ) ); ?>
		</td>
	</tr>-->
	<?php
	$view = learning_online_get_admin_view( 'settings/emails/email-template.php' );
	include_once $view;
	?>
	<?php do_action( 'learning_online_after_' . $settings_class->id . '_' . $settings_class->section['id'] . '_settings_fields', $settings ); ?>
	</tbody>
</table>