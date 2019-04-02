<?php
/**
 * Define common constants used by LearningOnline
 */
$upload_dir = wp_upload_dir();
// version
define( 'LEARNINGONLINE_VERSION', '2.1.7.1' );

define( 'LP_WP_CONTENT', basename( WP_CONTENT_DIR ) );

// Plugin paths and urls
define( 'LP_PLUGIN_PATH', trailingslashit( plugin_dir_path( LP_PLUGIN_FILE ) ) );
define( 'LP_CONTENT_PATH', '/' . LP_WP_CONTENT . '/plugins/learningonline/' );
define( 'LP_PLUGIN_URL', trailingslashit( plugins_url( '/', LP_PLUGIN_FILE ) ) );
define( 'LP_JS_URL', LP_PLUGIN_URL . 'assets/js/' );
define( 'LP_CSS_URL', LP_PLUGIN_URL . 'assets/css/' );

// Log path
define( 'LP_LOG_PATH', $upload_dir['basedir'] . '/learning-online-logs/' );

// Turn on/off cart
define( 'LP_ENABLE_CART', false );

// Cache group id
define( 'LP_SESSION_CACHE_GROUP', 'learning_online_session_id' );

// Table prefix
define( 'LP_TABLE_PREFIX', 'learningonline_' );

// Define constants for custom post types
define( 'LP_COURSE_CPT', 'lp_course' );
define( 'LP_LESSON_CPT', 'lp_lesson' );
define( 'LP_QUESTION_CPT', 'lp_question' );
define( 'LP_QUIZ_CPT', 'lp_quiz' );
define( 'LP_ORDER_CPT', 'lp_order' );

// Role of user who is a teacher
define( 'LP_TEACHER_ROLE', 'lp_teacher' );

// Turn debug mode on/off
define( 'LP_DEBUG', true );

// Options
define( 'LP_USE_ATTRIBUTES', false );
define( 'LP_WIDGET_PATH', LP_PLUGIN_PATH . 'inc/widgets' );
define( 'LP_WIDGET_URL', LP_PLUGIN_URL . 'inc/widgets' );