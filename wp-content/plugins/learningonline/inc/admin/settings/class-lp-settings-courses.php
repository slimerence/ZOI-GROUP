<?php

/**
 * Class LP_Settings_Courses
 */
class LP_Settings_Courses extends LP_Settings_Base {
	public function __construct() {
		$this->id   = 'courses';
		$this->text = __( 'Courses', 'learningonline' );

		parent::__construct();
	}

	public function _get_sections() {
		$sections = array(
			'general' => array(
				'id'    => 'general',
				'title' => __( 'General', 'learningonline' )
			)
		);

		return $sections = apply_filters( 'learning_online_settings_sections_' . $this->id, $sections );
	}

	public function save() {
		parent::save();
		$course_permalink = $_POST['learning_online_course_base'];
		if ( $course_permalink == 'custom' ) {
			$course_permalink = trim( $_POST['course_permalink_structure'], '/' );

			if ( '%course_category%' == $course_permalink ) {
				$course_permalink = _x( 'courses', 'slug', 'learningonline' ) . '/' . $course_permalink;
			}

			$course_permalink = '/' . $course_permalink;
			update_option( 'learning_online_course_base_type', 'custom' );

		} else {
			delete_option( 'learning_online_course_base_type' );
		}

		$course_base = untrailingslashit( $course_permalink );

		update_option( 'learning_online_course_base', $course_base );

		$courses_page_id   = learning_online_get_page_id( 'courses' );
		$courses_permalink = ( $courses_page_id > 0 && get_post( $courses_page_id ) ) ? get_page_uri( $courses_page_id ) : _x( 'courses', 'default-slug', 'learningonline' );

		if ( $courses_page_id && trim( $course_base, '/' ) === $courses_permalink ) {
			update_option( 'learning_online_use_verbose_page_rules', 'yes' );
		} else {
			delete_option( 'learning_online_use_verbose_page_rules' );
		}
	}

	public function output() {
		$view = learning_online_get_admin_view( 'settings/courses.php' );
		require_once $view;
	}

	public function get_settings() {

		$generate_course_thumbnail = get_option( 'learning_online_generate_course_thumbnail' ) ? get_option( 'learning_online_generate_course_thumbnail' ) : 'no';

		return apply_filters(
			'learning_online_courses_settings',
			array(
				array(
					'title'   => __( 'Courses Page', 'learningonline' ),
					'id'      => $this->get_field_name( 'courses_page_id' ),
					'default' => '',
					'type'    => 'pages-dropdown'
				),
				array(
					'title'   => __( 'Course category base', 'learningonline' ),
					'id'      => $this->get_field_name( 'course_category_base' ),
					'default' => 'course-category',
					'type'    => 'text'
				),
				array(
					'title'   => __( 'Course tag base', 'learningonline' ),
					'id'      => $this->get_field_name( 'course_tag_base' ),
					'default' => 'course-tag',
					'type'    => 'text'
				),
				array(
					'title'   => __( 'Review course before publish', 'learningonline' ),
					'desc'    => __( 'The course needs to be reviewed by admin before it can be published.', 'learningonline' ),
					'id'      => $this->get_field_name( 'required_review' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),
				array(
					'title'   => __( 'Enable edit published course', 'learningonline' ),
					'desc'    => __( 'Allow instructors to edit the course that are published without review.<br /> If this option is disabled, the course status will be changed to Pending Review when the instructor update course.', 'learningonline' ),
					'id'      => $this->get_field_name( 'enable_edit_published' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),
				// Removed from 2.1.4
				/*array(
					'title'   => __( 'Show list of question in quiz', 'learningonline' ),
					'desc'    => __( 'Show/Hide list questions in quiz.', 'learningonline' ),
					'id'      => $this->get_field_name( 'disable_question_in_quiz' ),
					'default' => 'yes',
					'type'    => 'checkbox'
				),*/
				/* Temporary remove from 2.1.4
				array(
					'title'   => __( 'Auto redirect next lesson', 'learningonline' ),
					'desc'    => __( 'Redirect to the next lesson after completed the lesson', 'learningonline' ),
					'id'      => $this->get_field_name( 'auto_redirect_next_lesson' ),
					'default' => 'no',
					'type'    => 'checkbox'
				),
				array(
					'title'             => __( 'Time delay redirect', 'learningonline' ),
					'desc'              => __( 'The item will be redirected after certain amount of time, unit: seconds (s)', 'learningonline' ),
					'id'                => $this->get_field_name( 'auto_redirect_time' ),
					'default'           => '3',
					'type'              => 'number',
					'custom_attributes' => array(
						'min' => '0'
					)
				),
				array(
					'title'   => __( 'Auto redirect message ', 'learningonline' ),
					'desc'    => '',
					'id'      => $this->get_field_name( 'auto_redirect_message' ),
					'default' => 'Redirecting to the next item ... ',
					'type'    => 'text'
				),*/
				array(
					'title' => __( 'Archive', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'             => __( 'Courses limit', 'learningonline' ),
					'desc'              => __( 'Number of courses displayed per page.', 'learningonline' ),
					'id'                => $this->get_field_name( 'archive_course_limit' ),
					'default'           => '10',
					'type'              => 'number',
					'custom_attributes' => array(
						'min' => '1'
					)
				),
				array(
					'title' => __( 'Course thumbnail', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Extra thumbnail', 'learningonline' ),
					'id'      => $this->get_field_name( 'generate_course_thumbnail' ),
					'default' => 'yes',
					'type'    => 'checkbox',
					'desc'    => __( 'Turn on/off courses extra thumbnail', 'learningonline' ),
				),
				array(
					'title'   => __( 'Single course', 'learningonline' ),
					'id'      => $this->get_field_name( 'single_course_image_size' ),
					'default' => array( 800, 450, 'yes' ),
					'type'    => 'image-size',
					'class'   => 'single-course-thumbnail' . ( ( $generate_course_thumbnail == 'no' ) ? ' hide-if-js' : '' )
				),
				array(
					'title'   => __( 'Courses page', 'learningonline' ),
					'id'      => $this->get_field_name( 'course_thumbnail_image_size' ),
					'default' => array( 400, 250, 'yes' ),
					'type'    => 'image-size',
					'class'   => 'archive-course-thumbnail' . ( ( $generate_course_thumbnail == 'no' ) ? ' hide-if-js' : '' )
				),
				array(
					'title' => __( 'Single course permalink', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Single course permalink', 'learningonline' ),
					'type'    => 'course-permalink',
					'default' => ''
				),
				array(
					'title' => __( 'Course item slug', 'learningonline' ),
					'type'  => 'title'
				),
				array(
					'title'   => __( 'Lesson', 'learningonline' ),
					'type'    => 'text',
					'id'      => $this->get_field_name( 'lesson_slug' ),
					'desc'    => __( sprintf( '%s/course/sample-course/<code>lessons</code>/sample-lesson/', home_url() ), 'learningonline' ),
					'default' => 'lessons'
				),
				array(
					'title'   => __( 'Quiz', 'learningonline' ),
					'type'    => 'text',
					'id'      => $this->get_field_name( 'quiz_slug' ),
					'desc'    => __( sprintf( '%s/course/sample-course/<code>quizzes</code>/sample-lesson/', home_url() ), 'learningonline' ),
					'default' => 'quizzes'
				)
			)
		);
	}
}

return new LP_Settings_Courses();