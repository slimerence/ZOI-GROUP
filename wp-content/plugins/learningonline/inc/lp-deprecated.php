<?php
/**
 * Handle renamed/removed hooks
 *
 */
global $lp_map_deprecated_filters;

$lp_map_deprecated_filters = array(
	'learning_online_register_add_ons' => 'learning_online_loaded'
);

foreach ( $lp_map_deprecated_filters as $old => $new ) {
	add_filter( $old, 'lp_deprecated_filter_mapping', 9999999 );
}

function lp_deprecated_filter_mapping( $data, $arg_1 = '', $arg_2 = '', $arg_3 = '' ) {
	global $lp_map_deprecated_filters, $wp_filter;
	$filter = current_filter();
	if ( !empty( $wp_filter[$filter] ) && count( $wp_filter[$filter] ) > 1 ) {
		_deprecated_function( 'The ' . $filter . ' hook', '1.0', $lp_map_deprecated_filters[$filter] );
	}

	return $data;
}

function learning_online_text_image( $text = null, $args = array() ) {
	_deprecated_function( __FUNCTION__, '1.0' );
	$width      = 200;
	$height     = 150;
	$font_size  = 1;
	$background = 'FFFFFF';
	$color      = '000000';
	$padding    = 20;
	extract( $args );

	// Output to browser
	if ( empty( $_REQUEST['debug'] ) ) {
		header( 'Content-Type: image/png' );
	}
	/*
    $uniqid = md5( serialize( array( 'width' => $width, 'height' => $height, 'text' => $text, 'background' => $background, 'color' => $color ) ) );
    @mkdir( LP_PLUGIN_PATH . '/cache' );
    $cache = LP_PLUGIN_PATH . '/cache/' . $uniqid . '.cache';
    if( file_exists( $cache ) ){
        readfile( $cache );
        die();
    }*/

	$im = imagecreatetruecolor( $width, $height );

	list( $r, $g, $b ) = sscanf( "#{$background}", "#%02x%02x%02x" );
	$background = imagecolorallocate( $im, $r, $g, $b );

	list( $r, $g, $b ) = sscanf( "#{$color}", "#%02x%02x%02x" );
	$color = imagecolorallocate( $im, $r, $g, $b );

	// Set the background to be white
	imagefilledrectangle( $im, 0, 0, $width, $height, $background );

	// Path to our font file
	$font = LP_PLUGIN_PATH . '/assets/fonts/Sumana-Regular.ttf';
	$x    = $width;
	$loop = 0;
	do {
		// First we create our bounding box for the first text
		$bbox = imagettfbbox( $font_size, 0, $font, $text );
		// This is our cordinates for X and Y
		$x = $bbox[0] + ( imagesx( $im ) / 2 ) - ( $bbox[4] / 2 );
		$y = $bbox[1] + ( imagesy( $im ) / 2 ) - ( $bbox[5] / 2 );
		$font_size ++;
		if ( $loop ++ > 100 ) {
			break;
		}
	} while ( $x > $padding );
	// Write it
	imagettftext( $im, $font_size, 0, $x - 5, $y, $color, $font, $text );
	imagepng( $im );
	//readfile( $cache );
	imagedestroy( $im );
}
/**
 * Get all lessons in a course
 *
 * @param $course_id
 *
 * @return array
 */
function learning_online_get_lessons( $course_id ) {
	_deprecated_function( __FUNCTION__, '1.0' );
	$lessons    = array();
	$curriculum = get_post_meta( $course_id, '_lpr_course_lesson_quiz', true );
	if ( $curriculum ) {
		foreach ( $curriculum as $lesson_quiz_s ) {
			if ( array_key_exists( 'lesson_quiz', $lesson_quiz_s ) ) {
				foreach ( $lesson_quiz_s['lesson_quiz'] as $lesson_quiz ) {
					if ( get_post_type( $lesson_quiz ) == LP_LESSON_CPT ) {
						$lessons[] = $lesson_quiz;
					}
				}
			}
		}
	}

	return $lessons;
}

/**
 * @param $course_id
 *
 * @return array
 */
function learning_online_get_course_quizzes( $course_id ) {
	_deprecated_function( __FUNCTION__, '1.0' );
	$quizzes    = array();
	$curriculum = get_post_meta( $course_id, '_lpr_course_lesson_quiz', true );
	if ( $curriculum ) {
		foreach ( $curriculum as $lesson_quiz_s ) {
			if ( array_key_exists( 'lesson_quiz', $lesson_quiz_s ) ) {
				foreach ( $lesson_quiz_s['lesson_quiz'] as $lesson_quiz ) {
					if ( get_post_type( $lesson_quiz ) == LP_QUIZ_CPT ) {
						$quizzes[] = $lesson_quiz;
					}
				}
			}
		}
	}

	return $quizzes;
}

// Deprecated template functions


if ( !function_exists( 'learning_online_course_content_lesson' ) ) {
	/**
	 * Display course description
	 */
	function learning_online_course_content_lesson() {
		learning_online_get_template( 'content-lesson/summary.php' );
	}
}

if ( !function_exists( 'learning_online_course_lesson_data' ) ) {
	/**
	 * Display course lesson description
	 */
	function learning_online_course_lesson_data() {
		$course = LP()->course;
		if ( !$course ) {
			return;
		}
		if ( !( $lesson = $course->current_lesson ) ) {
			return;
		}
		?>
		<input type="hidden" name="learning-online-lesson-viewing" value="<?php echo $lesson->id; ?>" />
		<?php
	}
}

if ( !function_exists( 'learning_online_course_lesson_description' ) ) {
	/**
	 * Display course lesson description
	 */
	function learning_online_course_lesson_description() {
		learning_online_get_template( 'content-lesson/description.php' );
	}
}

if ( !function_exists( 'learning_online_course_quiz_description' ) ) {
	/**
	 * Display lesson content
	 */
	function learning_online_course_quiz_description() {
		learning_online_get_template( 'single-course/content-quiz.php' );
	}
}


if ( !function_exists( 'learning_online_course_lesson_complete_button' ) ) {
	/**
	 * Display lesson complete button
	 */
	function learning_online_course_lesson_complete_button() {
		learning_online_get_template( 'content-lesson/complete-button.php' );
	}
}


if ( !function_exists( 'learning_online_course_lesson_navigation' ) ) {
	/**
	 * Display lesson navigation
	 */
	function learning_online_course_lesson_navigation() {
		learning_online_get_template( 'content-lesson/navigation.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_preview_mode' ) ) {
	/**
	 * Output the title of the quiz
	 */
	function learning_online_single_quiz_preview_mode() {
		learning_online_get_template( 'content-quiz/preview-mode.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_left_start_wrap' ) ) {
	function learning_online_single_quiz_left_start_wrap() {
		learning_online_get_template( 'content-quiz/left-start-wrap.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_question' ) ) {
	/**
	 * Output the single question for quiz
	 */
	function learning_online_single_quiz_question() {
		learning_online_get_template( 'content-quiz/content-question.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_result' ) ) {
	/**
	 * Output the result for the quiz
	 */
	function learning_online_single_quiz_result() {
		learning_online_get_template( 'content-quiz/result.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_questions_nav' ) ) {
	/**
	 * Output the navigation to next and previous questions
	 */
	function learning_online_single_quiz_questions_nav() {
		learning_online_get_template( 'content-quiz/nav.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_questions' ) ) {
	/**
	 * Output the list of questions for quiz
	 */
	function learning_online_single_quiz_questions() {
		learning_online_get_template( 'content-quiz/questions.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_history' ) ) {
	/**
	 * Output the history of a quiz
	 */
	function learning_online_single_quiz_history() {
		learning_online_get_template( 'content-quiz/history.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_left_end_wrap' ) ) {
	function learning_online_single_quiz_left_end_wrap() {
		learning_online_get_template( 'content-quiz/left-end-wrap.php' );
	}
}




if ( !function_exists( 'learning_online_single_quiz_sidebar' ) ) {
	/**
	 * Output the sidebar for a quiz
	 */
	function learning_online_single_quiz_sidebar() {
		learning_online_get_template( 'content-quiz/sidebar.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_information' ) ) {
	/**
	 *
	 */
	function learning_online_single_quiz_information() {
		learning_online_get_template( 'content-quiz/intro.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_timer' ) ) {
	/**
	 * Output the quiz countdown timer
	 */
	function learning_online_single_quiz_timer() {
		learning_online_get_template( 'content-quiz/timer.php' );
	}
}


if ( !function_exists( 'learning_online_single_quiz_buttons' ) ) {
	/**
	 * Output the buttons for quiz actions
	 */
	function learning_online_single_quiz_buttons() {
		learning_online_get_template( 'content-quiz/buttons.php' );
	}
}

if ( !function_exists( 'learning_online_single_quiz_description' ) ) {
	/**
	 * Output the content of the quiz
	 */
	function learning_online_single_quiz_description() {
		learning_online_get_template( 'content-quiz/description.php' );
	}
}



if ( !function_exists( 'learning_online_single_quiz_information' ) ) {
	/**
	 *
	 */
	function learning_online_single_quiz_information() {
		learning_online_get_template( 'content-quiz/intro.php' );
	}
}




if ( !function_exists( 'learning_online_single_quiz_sidebar_buttons' ) ) {
	/**
	 *
	 */
	function learning_online_single_quiz_sidebar_buttons() {
		learning_online_get_template( 'content-quiz/sidebar-buttons.php' );
	}
}