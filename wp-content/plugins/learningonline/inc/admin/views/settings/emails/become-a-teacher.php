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
$default_subject = 'Become an teacher';
$default_message = '<strong>Hello %s</strong>,
<p>Your request become an teacher was accepted</p>
';
?>
<table class="form-table">
	<tbody>
	<?php do_action( 'learning_online_before_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	<tr>
		<th scope="row"><label for="lp_email_enable"><?php _e( 'Enable', 'learningonline' ); ?></label></th>
		<td>
                        <input type="hidden" name="<?php echo $settings_class->get_field_name( 'emails_become_an_instructor[enable]' ) ?>" value="no" />
			<input id="lp_email_enable" type="checkbox" name="<?php echo $settings_class->get_field_name( 'emails_become_an_instructor[enable]' ) ?>" value="yes" <?php checked( $settings->get( 'emails_become_an_instructor.enable' ), 'yes' ); ?> />

			<p class="description"><?php _e( 'Send notification to user when accept', 'learningonline' ); ?></p>
		</td>
	</tr>
	<tr>
		<th scope="row"><label for="lp_email_subject"><?php _e( 'Subject', 'learningonline' ); ?></label></th>
		<td>
			<input id="lp_email_subject" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_become_an_instructor[subject]' ) ?>" value="<?php echo $settings->get( 'emails_become_an_instructor.subject', $default_subject ); ?>" />

			<p class="description"><?php _e( 'Email subject', 'learningonline' ); ?></p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<label for="learning-online-emails-finished-course-heading"><?php _e( 'Heading', 'learningonline' ); ?></label></th>
		<td>
			<input id="learning-online-emails-finished-course-heading" class="regular-text" type="text" name="<?php echo $settings_class->get_field_name( 'emails_become_an_instructor[heading]' ) ?>" value="<?php echo $settings->get( 'emails_become_an_instructor.heading', $this->default_heading ); ?>" />

			<p class="description">
				<?php printf( __( 'Email heading, default: <code>%s</code>', 'learningonline' ), $this->default_heading ); ?>
			</p>
		</td>
	</tr>
	<?php
	$view = learning_online_get_admin_view( 'settings/emails/email-template.php' );
	include_once $view;
	?>
	<?php do_action( 'learning_online_after_' . $this->id . '_' . $this->section['id'] . '_settings_fields', $settings ); ?>
	</tbody>
</table>