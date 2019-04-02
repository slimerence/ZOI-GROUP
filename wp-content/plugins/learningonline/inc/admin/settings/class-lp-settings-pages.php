<?php

/**
 * Class LP_Settings_Pages
 */
class LP_Settings_Pages extends LP_Settings_Base {
	public function __construct() {
		$this->id   = 'pages';
		$this->text = __( 'Pages', 'learningonline' );

		parent::__construct();
	}

	public function get_sections() {
		$sections = array(
			'profile'          => array(
				'id'    => 'profile',
				'title' => __( 'Profile', 'learningonline' )
			),
			'quiz'             => array(
				'id'    => 'quiz',
				'title' => __( 'Quiz', 'learningonline' )
			),
			'become_a_teacher' => array(
				'id'    => 'become_a_teacher',
				'title' => __( 'Become a teacher', 'learningonline' )
			)
		);
		return $sections = apply_filters( 'learning_online_settings_sections_' . $this->id, $sections );
	}

	public function get_settings() {

		$display_name = array(
			'nice'      => esc_html__( 'Nicename', 'learningonline' ),
			'first'     => esc_html__( 'First name', 'learningonline' ),
			'last'      => esc_html__( 'Last name', 'learningonline' ),
			'nick'      => esc_html__( 'Nickname', 'learningonline' ),
			'firstlast' => esc_html__( 'First name + Last name', 'learningonline' ),
			'lastfirst' => esc_html__( 'Last name + First name', 'learningonline' ),

		);

		return apply_filters(
			'learning_online_page_settings',
			array(
				array( 'section' => 'profile' ),
				array(
					'title' => __( 'General', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Profile', 'learningonline' ),
					'id'      => $this->get_field_name( 'profile_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				),

				array(
					'title'   => __( 'Add link to admin bar', 'learningonline' ),
					'id'      => $this->get_field_name( 'admin_bar_link' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),
				array(
					'title'       => __( 'Text link', 'learningonline' ),
					'id'          => $this->get_field_name( 'admin_bar_link_text' ),
					'default'     => '',
					'type'        => 'text',
					'placeholder' => __( 'Default: View Course Profile', 'learningonline' ),
					'class'       => 'regular-text'
				),
				array(
					'title'   => __( 'Target link', 'learningonline' ),
					'id'      => $this->get_field_name( 'admin_bar_link_target' ),
					'default' => 'yes',
					'type'    => 'select',
					'options' => array(
						'_self'  => __( 'Self', 'learningonline' ),
						'_blank' => __( 'New window', 'learningonline' )
					)
				),
				array(
					'title'   => __( 'Courses limit', 'learningonline' ),
					'id'      => $this->get_field_name( 'profile_courses_limit' ),
					'default' => '10',
					'type'    => 'number',
					'min'     => 1
				),
				/*array(
					'title'   => __( 'Access level', 'learningonline' ),
					'id'      => $this->get_field_name( 'profile_access_level' ),
					'default' => 'private',
					'type'    => 'select',
					'options' => array(
						'private' => __( 'Private (Only account own)', 'learningonline' ),
						'public'  => __( 'Public', 'learningonline' )
					)
				),*/
				array(
					'title' => __( 'Page slug', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'       => __( 'Courses', 'learningonline' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-courses]' ),
					'default'     => 'courses',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learningonline' ) . sprintf( ' %s <code>[profile/admin/courses]</code>', __( 'Example link is', 'learningonline' ) )
				),
				array(
					'title'       => __( 'Quizzes', 'learningonline' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-quizzes]' ),
					'default'     => 'quizzes',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learningonline' ) . sprintf( ' %s <code>[profile/admin/quizzes]</code>', __( 'Example link is', 'learningonline' ) )
				),
				array(
					'title'       => __( 'Orders', 'learningonline' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-orders]' ),
					'default'     => 'orders',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learningonline' ) . sprintf( ' %s <code>[profile/admin/orders]</code>', __( 'Example link is', 'learningonline' ) )
				),
				array(
					'title'       => __( 'View order', 'learningonline' ),
					'id'          => $this->get_field_name( 'profile_endpoints[profile-order-details]' ),
					'default'     => 'order-details',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learningonline' ) . sprintf( ' %s <code>[profile/admin/order-details/123]</code>', __( 'Example link is', 'learningonline' ) )
				),
				array(
					'title' => __( 'User avatar', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Ratio', 'learningonline' ),
					'id'      => $this->get_field_name( 'profile_picture_thumbnail_size' ),
					'default' => array( 150, 150, 'yes' ),
					'type'    => 'image-size'
				),
				/*array(
					'title'   => __( 'Crop', 'learningonline' ),
					'id'      => $this->get_field_name( 'profile_picture_crop' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),*/
				array( 'section' => 'quiz' ),
				array(
					'title' => __( 'Endpoints', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'       => __( 'Results', 'learningonline' ),
					'id'          => $this->get_field_name( 'quiz_endpoints[results]' ),
					'default'     => 'results',
					'type'        => 'text',
					'placeholder' => '',
					'desc'        => __( 'This is a slug and should be unique.', 'learningonline' ) . sprintf( ' %s <code>[quizzes/sample-quiz/results]</code>', __( 'Example link is', 'learningonline' ) )
				),
				array( 'section' => 'become_a_teacher' ),
				array(
					'title'   => __( 'Become a teacher', 'learningonline' ),
					'id'      => $this->get_field_name( 'become_a_teacher_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				)
			), $this
		);
	}

	public function _get_settings( $section ) {
		$settings = $this->get_settings();
		$get      = false;
		$return   = array();
		foreach ( $settings as $k => $v ) {
			if ( !empty( $v['section'] ) ) {
				if ( $get ) {
					break;
				}
				if ( $v['section'] == $section ) {
					$get = true;
					continue;
				}
			}
			if ( $get ) {
				$return[] = $v;
			}
		}
		return $return;
	}

	public function output_section_profile() {
		$view = learning_online_get_admin_view( 'settings/pages/profile.php' );
		require_once $view;
	}

	public function output_section_quiz() {
		$view = learning_online_get_admin_view( 'settings/pages/quiz.php' );
		require_once $view;
	}

	public function output_section_become_a_teacher() {
		$view = learning_online_get_admin_view( 'settings/pages/become-a-teacher.php' );
		require_once $view;
	}
}

return new LP_Settings_Pages();