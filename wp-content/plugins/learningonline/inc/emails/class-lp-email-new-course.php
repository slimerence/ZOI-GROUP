<?php
defined( 'ABSPATH' ) || exit();

/**
 * Class LP_Email_New_Course
 *
 * @author  JwsTheme
 * @package LearningOnline/Classes
 * @version 1.0
 */

if ( !class_exists( 'LP_Email_New_Course' ) ) {

	class LP_Email_New_Course extends LP_Email {
		/**
		 * LP_Email_New_Course constructor.
		 */
		public function __construct() {
			$this->id    = 'new_course';
			$this->title = __( 'New course', 'learningonline' );

			$this->template_html  = 'emails/new-course.php';
			$this->template_plain = 'emails/plain/new-course.php';

			$this->default_subject = __( '[{{site_title}}] New course has been submitted for review ({{course_name}})', 'learningonline' );
			$this->default_heading = __( 'New course', 'learningonline' );
			$this->recipient       = LP()->settings->get( 'emails_new_course.recipient' );

			$this->support_variables = array(
				'{{site_url}}',
				'{{site_title}}',
				'{{site_admin_email}}',
				'{{site_admin_name}}',
				'{{login_url}}',
				'{{header}}',
				'{{footer}}',
				'{{email_heading}}',
				'{{footer_text}}',
				'{{course_id}}',
				'{{course_name}}',
				'{{course_edit_url}}',
				'{{course_user_id}}',
				'{{course_user_name}}',
				'{{course_user_email}}',
			);

			//$this->email_text_message_description = sprintf( '%s {{course_id}}, {{course_title}}, {{course_url}}, {{course_edit_url}}, {{user_email}}, {{user_name}}, {{user_profile_url}}', __( 'Shortcodes', 'learningonline' ) );
			parent::__construct();
		}

		public function admin_options( $obj ) {
			$view = learning_online_get_admin_view( 'settings/emails/new-course.php' );
			include_once $view;
		}

		public function trigger( $course_id ) {

			if ( ( !$this->enable ) || !$this->get_recipient() ) {
				return;
			}

			$format = $this->email_format == 'plain_text' ? 'plain' : 'html';
			$course = learning_online_get_course( $course_id );
			$user   = learning_online_get_course_user( $course_id );

			$this->object = $this->get_common_template_data(
				$format,
				array(
					'course_id'         => $course_id,
					'course_name'       => $course->get_title(),
					'course_edit_url'   => admin_url( 'post.php?post=' . $course_id . '&action=edit' ),
					'course_user_id'    => $user->id,
					'course_user_name'  => learning_online_get_profile_display_name( $user ),
					'course_user_email' => $user->user_email
				)
			);

			$this->variables = $this->data_to_variables( $this->object );

			$this->object['course']      = $course;
			$this->object['user_course'] = $user;

			$return = $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );

			return $return;
		}

		public function get_recipient() {
			$recipient = $this->recipient;
			if ( !$recipient ) {
				$recipient = get_option( 'admin_email' );
			}
			$this->recipient = $recipient;
			return parent::get_recipient(); // TODO: Change the autogenerated stub
		}
		/*
			public function get_content_html() {
				ob_start();
				learning_online_get_template( $this->template_html, array(
					'email_heading' => $this->get_heading(),
					'footer_text'   => $this->get_footer_text(),
					'site_title'    => $this->get_blogname(),
					'course_id'     => $this->object['course'],
					'plain_text'    => false
				) );
				return ob_get_clean();
			}

			public function get_content_plain() {
				ob_start();
				learning_online_get_template( $this->template_plain, array(
					'email_heading' => $this->get_heading(),
					'footer_text'   => $this->get_footer_text(),
					'site_title'    => $this->get_blogname(),
					'course_id'     => $this->object['course'],
					'login_url'     => learning_online_get_login_url(),
					'plain_text'    => true
				) );
				return ob_get_clean();
			}

			public function _prepare_content_text_message() {
				$course = isset( $this->object['course'] ) ? $this->object['course'] : null;
				$user   = learning_online_get_course_user( $course->id );
				if ( $course ) {
					$this->text_search  = array(
						"/\{\{course\_id\}\}/",
						"/\{\{course\_title\}\}/",
						"/\{\{course\_url\}\}/",
						"/\{\{course\_edit\_url\}\}/",
						"/\{\{user\_email\}\}/",
						"/\{\{user\_name\}\}/",
						"/\{\{user\_profile\_url\}\}/",
					);
					$this->text_replace = array(
						$course->id,
						get_the_title( $course->id ),
						get_the_permalink( $course->id ),
						get_edit_post_link( $course->id ),
						$user->user_email,
						$user->user_nicename,
						learning_online_user_profile_link( $user->id )
					);
				}
			}*/

		/**
		 * @param string $format
		 *
		 * @return array|void
		 */
		public function get_template_data( $format = 'plain' ) {
			return $this->object;
		}
	}
}

return new LP_Email_New_Course();