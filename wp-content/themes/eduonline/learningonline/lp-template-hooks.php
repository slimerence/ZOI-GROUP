<?php 


add_action( 'learning_online_button_buy_courser', 'learning_online_course_buttons', true );


// Single course
add_action( 'learning_online_courses_loop_item_thumbnail', 'learning_online_courses_loop_item_thumbnail', 10 );

add_action( 'learning_online_courses_loop_single_item_title', 'learning_online_courses_loop_item_title', 50 );

add_action( 'learning_online_courses_loop_single_item_action', 'learning_online_courses_loop_item_price', 10 );
add_action( 'learning_online_courses_loop_single_item_action', 'learning_online_course_buttons' , 10 );

add_filter( 'learning_online_custom_course_tabs', '_learning_online_custom_course_tabs', 5 );

add_action( 'learning_online_single_course_tabs', 'learning_online_custom_course_tabs' , 10 );
add_action( 'learning_online_single_course_tabs', 'learning_online_single_course_content_lesson', 40 );
add_action( 'learning_online_single_course_tabs', 'learning_online_single_course_content_item', 40 );
add_action( 'learning_online_single_course_tabs', 'learning_online_course_progress', 60 );
add_action( 'learning_online_single_course_tabs', 'learning_online_course_curriculum_popup', 65 );

add_action( 'learning_online_single_course_students', 'learning_online_course_students' , 10 );

// archive course

add_action( 'learning_online_courses_loop_item_thumbnail', 'learning_online_courses_loop_item_thumbnail', 10 );
//add_action( 'learning_online_custom_page_title', 'learning_online_page_title', 10 );

add_action( 'learning_online_custom_page_title', 'learning_online_page_title' );
