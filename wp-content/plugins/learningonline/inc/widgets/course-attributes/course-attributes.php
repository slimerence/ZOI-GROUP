<?php
if ( !class_exists( 'LP_Widget_Course_Attributes' ) ) {
	/**
	 * Class LP_Widget_Course_Attribute
	 */
	class LP_Widget_Course_Attributes extends LP_Widget {
		public function __construct() {
			$prefix        = '';
			$this->options = array(
				array(
					'name' => __( 'Title', 'learningonline' ),
					'id'   => "{$prefix}title",
					'type' => 'text',
					'std'  => __( 'Course attributes', 'learningonline' )
				)
			);
			parent::__construct();
			add_filter( 'learning_online_widget_display_content-' . $this->id_base, 'learning_online_is_course' );

		}

		public function show() {
			$postId     = get_the_ID();
			$attributes = learning_online_get_course_attributes( $postId );
			if ( !$attributes ) {
				return;
			}
			include learning_online_locate_widget_template( $this->get_slug() );
		}
	}
}