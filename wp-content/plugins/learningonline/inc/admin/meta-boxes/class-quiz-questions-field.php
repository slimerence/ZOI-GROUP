<?php

// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;
/**
 * Class RWMB_Quiz_Questions_Field
 *
 * @author  JwsTheme
 * @package LearningOnline/Classes
 * @version 1.0
 * @extend  RWMB_Field
 */
if ( !class_exists( 'RWMB_Quiz_Questions_Field' ) ) {

	class RWMB_Quiz_Questions_Field extends RWMB_Field {
		/**
		 * Construct
		 */
		public function __construct() {

		}

		public static function admin_enqueue_scripts() {
			/*$q = new LP_Question();
			$q->admin_script();*/
			LP_Assets::enqueue_style( 'select2', RWMB_CSS_URL . 'select2/select2.css' );
			LP_Assets::enqueue_script( 'select2', RWMB_JS_URL . 'select2/select2.min.js' );
			LP_Assets::enqueue_script( 'learning-online-mb-quiz' );
			LP_Assets::enqueue_script( 'learning-online-modal-search-items' );

		}

		public static function add_actions() {
			// Do same actions as file field
			parent::add_actions();

			add_action( 'wp_ajax_lpr_quiz_question_add', array( __CLASS__, 'quiz_question_add' ) );
			add_action( 'wp_ajax_lpr_quiz_question_remove', array( __CLASS__, 'quiz_question_remove' ) );
		}

		public static function quiz_question_remove() {
			$question_id = isset( $_REQUEST['question_id'] ) ? $_REQUEST['question_id'] : null;
			$quiz_id     = isset( $_REQUEST['quiz_id'] ) ? $_REQUEST['quiz_id'] : null;

			$questions = get_post_meta( $quiz_id, '_lpr_quiz_questions', true );
			if ( isset( $questions[$question_id] ) ) {
				unset( $questions[$question_id] );
				update_post_meta( $quiz_id, '_lpr_quiz_questions', $questions );
			}
			die();
		}

		public static function quiz_question_add() {
			$type        = isset( $_REQUEST['type'] ) ? $_REQUEST['type'] : null;
			$text        = isset( $_REQUEST['text'] ) ? $_REQUEST['text'] : null;
			$question_id = isset( $_REQUEST['question_id'] ) ? $_REQUEST['question_id'] : null;
			$question    = LP_Question::instance( $question_id ? $question_id : $type );
			$json        = array(
				'success' => false
			);
			if ( $question ) {
				if ( !$question_id ) {
					$question->set( 'post_title', $text ? $text : 'Your question text here' );
					$question->set( 'post_type', LP_QUESTION_CPT );
					$question->set( 'post_status', 'publish' );
				}


				if ( ( $question_id = $question->store() ) && isset( $_POST['quiz_id'] ) && ( $quiz_id = $_POST['quiz_id'] ) ) {
					$quiz_questions               = (array) get_post_meta( $quiz_id, '_lpr_quiz_questions', true );
					$quiz_questions[$question_id] = array( 'toggle' => 0 );
					update_post_meta( $quiz_id, '_lpr_quiz_questions', $quiz_questions );
				}
				ob_start();
				$question->admin_interface();
				$json['html']     = ob_get_clean();
				$json['success']  = true;
				$json['question'] = get_post( $question_id );
			} else {
				$json['msg'] = __( 'Can not create a question', 'learningonline' );
			}
			wp_send_json( $json );
			die();
		}

		public static function save_quiz_questions( $post_id ) {
			learning_online_debug($_POST);
			die();
			static $has_updated;
			$questions = isset( $_POST[LP_QUESTION_CPT] ) ? $_POST[LP_QUESTION_CPT] : null;
			if ( !$questions ) return;
			$postmeta = array();

			// prevent infinite loop with save_post action
			if ( $has_updated ) return;
			$has_updated = true;

			foreach ( $questions as $question_id => $options ) {
				$question = LP_Question::instance( $question_id );
				if ( $question ) {
					$question_id = $question->save_post_action();
					if ( $question_id ) {
						$postmeta[$question_id] = array( 'toggle' => $options['toggle'] );
						if ( !empty( $options['type'] ) ) {
							$post_data         = get_post_meta( $question_id, '_lpr_question', true );
							$post_data['type'] = $options['type'];
							update_post_meta( $question_id, '_lpr_question', $post_data );
						}
					}
				}
			}

			update_post_meta( $post_id, '_lpr_quiz_questions', $postmeta );
		}

		public static function html( $meta, $field ) {
			ob_start();
			$view = learning_online_get_admin_view( 'meta-boxes/quiz/questions.php' );
			include $view;
			return ob_get_clean();
		}

		public static function save( $new, $old, $post_id, $field ) {
			global $wpdb, $post;
			//LP_Debug::instance()->add( __CLASS__ . '::' . __FUNCTION__ . '(' . join( ',', func_get_args() ) . ')' );
			$questions = learning_online_get_request( 'learning_online_question' );
			/*if( $all_questions = LP_Quiz::get_quiz( $post->ID )->get_questions() ){
				$all_questions = array_keys( $all_questions );
			}*/
			// Get all ids of questions stored
			$remove_ids = $wpdb->get_col(
				$wpdb->prepare("
					SELECT question_id
					FROM {$wpdb->prefix}learningonline_quiz_questions
					WHERE quiz_id = %d
				", $post->ID )
			);

			// delete all questions stored
			$query = $wpdb->prepare("
				DELETE
				FROM {$wpdb->prefix}learningonline_quiz_questions
				WHERE quiz_id = %d
			", $post->ID, 1 );
			$wpdb->query( $query );
			learning_online_reset_auto_increment( 'learningonline_quiz_questions' );
			do_action( 'learning_online_remove_quiz_questions', $remove_ids, $post->ID );
			if( ! $questions ){
				return;
			}
			$titles = learning_online_get_request( 'learning-online-question-name' );
			$values = array();
			$order = 1;

			// update the title of questions and save all data
			foreach( $questions as $id => $data ){
				$question = LP_Question_Factory::get_question($id );
				if( ! empty( $titles[ $id ] ) ){
					$wpdb->update(
						$wpdb->posts,
						array(
							'post_title' => stripslashes( $titles[ $id ] )
						),
						array(
							'ID' => $id
						),
						array( '%s' )
					);
				}
				$question->save( $data );


				$insert_data = apply_filters(
					'learning_online_quiz_question_insert_data',
					array(
						'question_id' => $id,
						'quiz_id'	=> $post->ID,
						'params'	=> ''
					)
				);
				$values[] = $wpdb->prepare( "(%d, %d, %s, %d)", $insert_data['quiz_id'], $insert_data['question_id'], isset( $insert_data['param'] ) ? $insert_data['param'] : '', $order++ );
			}

			$query = "
				INSERT INTO {$wpdb->learningonline_quiz_questions}(`quiz_id`, `question_id`, `params`, `question_order`)
				VALUES " . join(',', $values) . "
			";
			$wpdb->query( $query );
			do_action( 'learning_online_insert_quiz_questions', $questions, $post->ID );
		}
	}

	//add_action( 'save_post', array( 'RWMB_Quiz_Questions_Field', 'save_quiz_questions' ), 1000000 );
}