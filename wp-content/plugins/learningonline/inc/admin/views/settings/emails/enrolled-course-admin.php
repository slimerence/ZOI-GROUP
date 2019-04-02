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
<h3><?php _e( 'Send mail for admins & instructors ', 'learningonline' ); ?></h3>
<p class="description">
	<?php _e( 'Send this email to admins & instructor when the course is enrolled.', 'learningonline' ); ?>
</p>
<table class="form-table">
	<tbody>
	<?php do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-enrolled-course-enable"><?php _e( 'Enable', 'learningonline' ); ?></label></th>
		<td>
			<input type="hidden" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[enable]' ); ?>" value="no" />
			<input id="learning-online-emails-enrolled-course-enable" type="checkbox" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[enable]' ); ?>" value="yes" <?php checked( $settings->get( 'emails_enrolled_course_admin.enable' ) == 'yes' ); ?> />
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-enrolled-course-send-admins"><?php _e( 'Send Admins', 'learningonline' ); ?></label></th>
		<td>
			<input type="hidden" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[send_admins]' ); ?>" value="no" />
			<input id="learning-online-emails-enrolled-course-send-admins" type="checkbox" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[send_admins]' ); ?>" value="yes" <?php checked( $settings->get( 'emails_enrolled_course_admin.send_admins' ) == 'yes' ); ?> />
		</td>
	</tr>
	<?php do_action( 'learning_online_before_subject_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings, $settings_class ); ?>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-enrolled-course-subject"><?php _e( 'Subject', 'learningonline' ); ?></label></th>
		<td>
			<input id="learning-online-emails-enrolled-course-subject" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[subject]' ); ?>" value="<?php echo $settings->get( 'emails_enrolled_course_admin.subject', $this->default_subject ); ?>" />

			<p class="description">
				<?php printf( __( 'Email subject , default: <code>%s</code>', 'learningonline' ), $this->default_subject ); ?>
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-enrolled-course-heading"><?php _e( 'Heading', 'learningonline' ); ?></label></th>
		<td>
			<input id="learning-online-emails-enrolled-course-heading" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_enrolled_course_admin[heading]' ); ?>" value="<?php echo $settings->get( 'emails_enrolled_course_admin.heading', $this->default_heading ); ?>" />

			<p class="description">
				<?php printf( __( 'Email heading, default: <code>%s</code>', 'learningonline' ), $this->default_heading ); ?>
			</p>
		</td>
	</tr>
	<!--
	<tr>
		<th scope="row">
			<label for="learning-online-emails-enrolled-course-email-format"><?php _e( 'Email format', 'learningonline' ); ?></label>
		</th>
		<td>
			<?php learning_online_email_formats_dropdown( array( 'name' => $settings_class->get_field_name( 'emails_enrolled_course_admin[email_format]' ), 'id' => 'learning_online_email_formats', 'selected' => $settings->get( 'emails_enrolled_course_admin.email_format' ) ) ); ?>
		</td>
	</tr>-->
	<?php
	$view = learning_online_get_admin_view( 'settings/emails/email-template.php' );
	include_once $view;
	?>
	<?php do_action( 'learning_online_after_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	</tbody>
</table>