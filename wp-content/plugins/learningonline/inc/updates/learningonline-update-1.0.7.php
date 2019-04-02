<?php
defined( 'ABSPATH' ) || exit();

if ( LEARNING_ONLINE_UPDATE_DATABASE ) {
	global $wpdb;
        $table = $wpdb->prefix . 'learningonline_user_quizzes';
        if ( $wpdb->get_var("SHOW TABLES LIKE '{$table}'") === $table ) {
            $query = $wpdb->prepare( "
                    UPDATE {$wpdb->prefix}learningonline_user_quizzes uq
                    SET course_id = (
                            SELECT c.ID
                            FROM {$wpdb->posts} c
                            INNER JOIN {$wpdb->prefix}learningonline_sections ls ON ls.section_course_id = c.ID
                            INNER JOIN {$wpdb->prefix}learningonline_section_items lsi ON lsi.section_id = ls.section_id
                            WHERE lsi.item_id = uq.quiz_id
                    )
                    WHERE uq.course_id = %d OR uq.course_id = NULL
            ", 0 );

            $wpdb->query( $query );
        }

        $table = $wpdb->prefix . 'learningonline_user_course_items';
        if ( $wpdb->get_var("SHOW TABLES LIKE '{$table}'") === $table ) {
            //$wpdb->query( "DELETE FROM {$wpdb->prefix}learningonline_user_course_items" );
            learning_online_reset_auto_increment( "learningonline_user_course_items" );

            $query = $wpdb->prepare( "
                    INSERT INTO {$wpdb->prefix}learningonline_user_course_items
                    (
                            SELECT uq.*, FROM_UNIXTIME(uqm1.meta_value) as start_date, FROM_UNIXTIME(uqm2.meta_value) as start_date, %s, uqm3.meta_value as status
                            FROM {$wpdb->prefix}learningonline_user_quizzes uq
                            INNER JOIN {$wpdb->prefix}learningonline_user_quizmeta uqm1 ON uq.user_quiz_id = uqm1.learningonline_user_quiz_id AND uqm1.meta_key = %s
                            INNER JOIN {$wpdb->prefix}learningonline_user_quizmeta uqm2 ON uq.user_quiz_id = uqm2.learningonline_user_quiz_id AND uqm2.meta_key = %s
                            INNER JOIN {$wpdb->prefix}learningonline_user_quizmeta uqm3 ON uq.user_quiz_id = uqm3.learningonline_user_quiz_id AND uqm3.meta_key = %s
                    )
            ", 'lp_quiz', 'start', 'end', 'status' );
            $wpdb->query( $query );
            $query = $wpdb->prepare( "
                    INSERT INTO {$wpdb->prefix}learningonline_user_course_items(user_id, item_id, course_id, start_date, end_date, item_type, status)
                    SELECT user_id, lesson_id, course_id, if(start_time, start_time, %s), if(end_time, end_time, %s), if(item_type, item_type, %s), status
                    FROM {$wpdb->prefix}learningonline_user_lessons w;
            ", '0000-00-00 00:00:00', '0000-00-00 00:00:00', 'lp_lesson' );
            $wpdb->query( $query );
        }

        $table = $wpdb->prefix . 'learningonline_user_course_itemmeta';
        if ( $wpdb->get_var("SHOW TABLES LIKE '{$table}'") === $table ) {
            //$wpdb->query( "DELETE FROM {$wpdb->prefix}learningonline_user_course_itemmeta" );
            learning_online_reset_auto_increment( "learningonline_user_course_itemmeta" );
            $query = $wpdb->prepare( "
                    INSERT INTO {$wpdb->prefix}learningonline_user_course_itemmeta(learningonline_user_course_item_id, meta_key, meta_value)
                    SELECT learningonline_user_quiz_id, meta_key, meta_value
                    FROM {$wpdb->prefix}learningonline_user_quizmeta
                    WHERE meta_key <> %s AND meta_key <> %s AND meta_key <> %s
            ", 'start', 'end', 'status' );
            $wpdb->query( $query );
            learning_online_update_log( '1.0.7', array( 'time' => time() ) );
        }
}