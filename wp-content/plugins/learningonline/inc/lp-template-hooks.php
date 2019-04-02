<?php
/**
 * Build courses content
 */

defined( 'ABSPATH' ) || exit();

add_filter( 'learning_online_course_tabs', '_learning_online_default_course_tabs', 5 );

add_filter( 'body_class', 'learning_online_body_class' );
add_filter( 'post_class', 'learning_online_course_class', 15, 3 );

/* wrapper */
add_action( 'learning_online_before_main_content', 'learning_online_wrapper_start' );
add_action( 'learning_online_after_main_content', 'learning_online_wrapper_end' );

/* breadcrumb */
add_action( 'learning_online_before_main_content', 'learning_online_breadcrumb' );

add_action( 'learning_online_before_main_content', 'learning_online_search_form' );

/* archive courses */
add_action( 'learning_online_courses_loop_item_title', 'learning_online_courses_loop_item_thumbnail', 10 );
add_action( 'learning_online_courses_loop_item_title', 'learning_online_courses_loop_item_title', 10 );

add_action( 'learning_online_after_courses_loop_item', 'learning_online_courses_loop_item_begin_meta', 10 );
add_action( 'learning_online_after_courses_loop_item', 'learning_online_courses_loop_item_instructor', 15 );
add_action( 'learning_online_after_courses_loop_item', 'learning_online_courses_loop_item_students', 20 );
add_action( 'learning_online_after_courses_loop_item', 'learning_online_courses_loop_item_price', 25 );
add_action( 'learning_online_after_courses_loop_item', 'learning_online_courses_loop_item_end_meta', 30 );

add_action( 'learning_online_after_courses_loop', 'learning_online_courses_pagination', 5 );

/* single course content */
add_action( 'wp_head', 'learning_online_single_course_args', 5 );
add_action( 'learning_online_single_course_learning_summary', 'learning_online_output_single_course_learning_summary', 5 );
add_action( 'learning_online_single_course_landing_summary', 'learning_online_output_single_course_landing_summary', 5 );

/* actions to display course content for landing page */
add_action( 'learning_online_course_item_content', 'learning_online_course_item_content', 5 );

//add_action( 'learning_online_content_landing_summary', 'learning_online_course_thumbnail', 5 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_meta_start_wrapper', 15 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_price', 25 );
//add_action( 'learning_online_content_landing_summary', 'learning_online_course_instructor', 30 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_students', 30 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_meta_end_wrapper', 35 );
add_action( 'learning_online_content_landing_summary', 'learning_online_single_course_content_lesson', 40 );
add_action( 'learning_online_content_landing_summary', 'learning_online_single_course_content_item', 40 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_progress', 60 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_tabs', 50 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_curriculum_popup', 65 );
add_action( 'learning_online_content_landing_summary', 'learning_online_course_buttons', 70 );
//add_action( 'learning_online_content_landing_summary', 'learning_online_course_students_list', 75 );

/* actions to display course content for learning page */
add_action( 'learning_online_course_item_content', 'learning_online_course_item_content', 5 );

//add_action( 'learning_online_content_learning_summary', 'learning_online_course_thumbnail', 5 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_meta_start_wrapper', 10 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_status', 15 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_instructor', 20 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_students', 25 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_meta_end_wrapper', 30 );
add_action( 'learning_online_content_learning_summary', 'learning_online_single_course_content_lesson', 35 );
add_action( 'learning_online_content_learning_summary', 'learning_online_single_course_content_item', 40 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_progress', 45 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_tabs', 50 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_remaining_time', 55 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_curriculum_popup', 60 );
add_action( 'learning_online_content_learning_summary', 'learning_online_course_buttons', 65 );

//add_action( 'learning_online_content_learning_summary', 'learning_online_course_students_list', 75 );
//add_action( 'learning_online_course_content_lesson', 'learning_online_course_content_lesson', 5 );

/*
add_action( 'learning_online_course_lesson_summary', 'learning_online_course_lesson_data', 5 );
add_action( 'learning_online_course_lesson_summary', 'learning_online_course_lesson_description', 10 );
add_action( 'learning_online_course_lesson_summary', 'learning_online_course_quiz_description', 15 );
add_action( 'learning_online_course_lesson_summary', 'learning_online_course_lesson_complete_button', 20 );
add_action( 'learning_online_course_lesson_summary', 'learning_online_course_lesson_navigation', 25 );
*/

add_action( 'learning_online_after_enroll_button', 'learning_online_enroll_script' );

/**
 * curriculum
 */
add_action( 'learning_online_curriculum_section_summary', 'learning_online_curriculum_section_title', 5 );
add_action( 'learning_online_curriculum_section_summary', 'learning_online_curriculum_section_content', 10 );

//add_action( 'learning_online_before_course_content_lesson_nav', 'learning_online_before_course_content_lesson_nav', 5 );
//add_action( 'learning_online_after_the_title', 'learning_online_course_thumbnail', 10 );

add_action( 'learning_online_after_section_item_title', 'learning_online_section_item_meta', 5, 3 );

/* order */
add_action( 'learning_online_checkout_before_order_review', 'learning_online_checkout_user_form', 5 );
add_action( 'learning_online_checkout_before_order_review', 'learning_online_checkout_user_logged_in', 10 );

add_action( 'learning_online_checkout_user_form', 'learning_online_checkout_user_form_login', 5 );
add_action( 'learning_online_checkout_user_form', 'learning_online_checkout_user_form_register', 10 );

add_action( 'learning_online_checkout_order_review', 'learning_online_order_review', 5 );
add_action( 'learning_online_checkout_order_review', 'learning_online_order_comment', 10 );
add_action( 'learning_online_checkout_order_review', 'learning_online_order_payment', 15 );

/* Profile */
add_action( 'learning_online_user_profile_summary', 'learning_online_output_user_profile_info', 5, 3 );
add_action( 'learning_online_user_profile_summary', 'learning_online_output_user_profile_tabs', 10, 3 );
add_action( 'learning_online_user_profile_summary', 'learning_online_output_user_profile_order', 15, 3 );
add_action( 'learning_online_profile_tab_courses_all', 'learning_online_profile_tab_courses_all', 5, 2 );
add_action( 'learning_online_profile_tab_courses_learning', 'learning_online_profile_tab_courses_learning', 5, 2 );
add_action( 'learning_online_profile_tab_courses_purchased', 'learning_online_profile_tab_courses_purchased', 5, 2 );
add_action( 'learning_online_profile_tab_courses_finished', 'learning_online_profile_tab_courses_finished', 5, 2 );
add_action( 'learning_online_profile_tab_courses_own', 'learning_online_profile_tab_courses_own', 5, 2 );
//add_action( 'learning_online_after_profile_tab_all_loop_course', 'learning_online_after_profile_tab_loop_course', 5, 2 );
//add_action( 'learning_online_after_profile_tab_own_loop_course', 'learning_online_after_profile_tab_loop_course', 5, 2 );
add_action( 'learning_online_after_profile_loop_course', 'learning_online_after_profile_tab_loop_course', 5, 2 );

add_action( 'learning_online_after_quiz_question_title', 'learning_online_single_quiz_question_answer', 5, 2 );
add_action( 'learning_online_order_received', 'learning_online_order_details_table', 5 );
add_action( 'learning_online_before_template_part', 'learning_online_generate_template_information', 999, 4 );

add_action( 'learning_online/after_course_item_content', 'learning_online_course_item_edit_link', 10, 2 );
function learning_online_course_item_edit_link( $item_id, $course_id ) {
	$user = learning_online_get_current_user();
	if ( $user->can_edit_item( $item_id, $course_id ) ): ?>
        <p class="edit-course-item-link">
            <a href="<?php echo get_edit_post_link( $item_id ); ?>"><?php _e( 'Edit this item', 'learningonline' ); ?></a>
        </p>
	<?php endif;
}

add_action( 'learning_online/after_course_item_content', 'learning_online_course_nav_items', 10, 2 );
add_action( 'learning_online/after_course_item_content', 'learning_online_lesson_comment_form', 10, 2 );

/*
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_preview_mode', 5 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_left_start_wrap', 10 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_question', 15 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_result', 20 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_questions_nav', 25 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_questions', 30 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_history', 35 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_left_end_wrap', 40 );
add_action( 'learning_online_single_quiz_summary', 'learning_online_single_quiz_sidebar', 45 );*/
/*
add_action( 'learning_online_single_quiz_sidebar', 'learning_online_single_quiz_information', 5 );
add_action( 'learning_online_single_quiz_sidebar', 'learning_online_single_quiz_timer', 10 );
add_action( 'learning_online_single_quiz_sidebar', 'learning_online_single_quiz_buttons', 15 );*/

/**
 * Redirect profile page if 'view' = 'courses'
 * and 'courses' not exists in URL
 */
/*add_action( 'template_redirect', 'learning_online_redirect_profile', 10 );
if ( !function_exists( 'learning_online_redirect_profile' ) ) {

	function learning_online_redirect_profile( $template ) {
		global $wp_query, $wp;

		if ( !empty( $wp_query->query['page_id'] ) && learning_online_get_page_id( 'profile' ) == $wp_query->query['page_id'] ) {
			parse_str( $wp->matched_query, $query );
			if ( empty( $query['view'] ) && !empty( $wp->query_vars['view'] ) ) {
				$user = learning_online_get_current_user();
				$url  = learning_online_user_profile_link( $user->id, $wp->query_vars['view'] );
				if ( !$url ) {
					$redirect_url = get_permalink() . $wp_query->query['user'];
					$url          = wp_login_url( $redirect_url );
				}
				die('ddddddddddddd');
				wp_redirect( $url );
				exit();
			}
		}
		return $template;
	}

}*/

function learning_online_comments_template_query_args( $comment_args ) {
	$post_type = get_post_type( $comment_args['post_id'] );
	if ( $post_type == 'lp_course' ) {
		$comment_args['type__not_in'] = 'review';
	}

	return $comment_args;
}

add_filter( 'comments_template_query_args', 'learning_online_comments_template_query_args' );

if ( ! function_exists( 'learning_online_filter_get_comments_number' ) ) {
	function learning_online_filter_get_comments_number( $count, $post_id = 0 ) {
		global $wpdb;
		if ( ! $post_id ) {
			$post_id = learning_online_get_course_id();
		}
		if ( ! $post_id ) {
			return $count;
		}
		if ( get_post_type( $post_id ) == 'lp_course' ) {
			$sql   = " SELECT count(*) "
			         . " FROM {$wpdb->comments} "
			         . " WHERE comment_post_ID=%d "
			         . " and comment_approved=1 "
			         . " and comment_type != 'review' ";
			$count = $wpdb->get_var( $wpdb->prepare( $sql, $post_id ) );

			return apply_filters( 'learning_online_get_comments_number', $count, $post_id );
		}

		return $count;
	}
}

add_filter( 'get_comments_number', 'learning_online_filter_get_comments_number' );