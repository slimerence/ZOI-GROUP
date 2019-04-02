<?php
/**
 * Template for displaying the instructor of a course
 *
 * @author  JwsTheme
 * @package LearningOnline/Templates
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$course = LP()->global['course'];

printf(
	'<span class="course-author" aria-hidden="true" itemprop="author">
		%s %s</a>%s
	</span>',
	apply_filters( 'before_instructor_link', __( 'Instructor: ', 'learningonline' ) ),
	apply_filters( 'learning_online_instructor_profile_link', $course->get_instructor_html(), null, $course->id ),
	apply_filters( 'after_instructor_link', '' )
);