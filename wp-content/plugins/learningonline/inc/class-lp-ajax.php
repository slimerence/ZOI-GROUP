<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'LP_AJAX' ) ) {
	/**
	 * Class LP_AJAX
	 */
	class LP_AJAX {
		/**
		 * Init common ajax events
		 */
		public static function init () {
			$ajaxEvents = array(
				'load_quiz_question'  => true,
				'load_prev_question'  => false,
				'load_next_question'  => false,
				'finish_quiz'         => true,
				'retake_quiz'         => true, // anonymous user can retake quiz
				'take_free_course'    => false,
				'load_lesson_content' => false,
				'load_next_lesson'    => false,
				'load_prev_lesson'    => false,
				'finish_course'       => false,
				'not_going'           => false,
				'take_course'         => true,
				'start_quiz'          => true,
				'fetch_question'      => true,
				'upload-user-avatar'  => false
			);

			foreach ( $ajaxEvents as $ajax_event => $nopriv ) {
				$ajax_func = preg_replace( '/-/', '_', $ajax_event );
				add_action( 'wp_ajax_learningonline_' . $ajax_event, array( __CLASS__, $ajax_func ) );

				if ( $nopriv ) {
					add_action( 'wp_ajax_nopriv_learningonline_' . $ajax_event, array( __CLASS__, $ajax_func ) );
				}
			}

			LP_Request_Handler::register( 'lp-ajax', array( __CLASS__, 'do_ajax' ) );
		}

		/**
		 * Do ajax if there is a 'lp-ajax' in $_REQUEST
		 *
		 * @param $var
		 */
		public static function do_ajax ( $var ) {
			if ( ! defined( 'LP_DOING_AJAX' ) ) {
				define( 'LP_DOING_AJAX', true );
			}
			LP_Gateways::instance()->get_available_payment_gateways();
			$result   = false;
			$method   = preg_replace( '/[-]+/', '_', $var );
			$callback = array( __CLASS__, '_request_' . $method );
			if ( is_callable( $callback ) ) {
				$result = call_user_func( $callback );
			} elseif ( has_action( 'learning_online_ajax_handler_' . $var ) ) {
				do_action( 'learning_online_ajax_handler_' . $var );

				return;
			}
			if ( learning_online_get_request( 'format' ) == 'html' ) {
				return;
			}
			learning_online_send_json( $result );
		}

		public static function upload_user_avatar () {
			$file       = $_FILES['lp-upload-avatar'];
			$upload_dir = learning_online_user_profile_picture_upload_dir();

			add_filter( 'upload_dir', array( __CLASS__, '_user_avatar_upload_dir' ), 10000 );

			$result = wp_handle_upload( $file,
				array(
					'test_form' => false
				)
			);

			remove_filter( 'upload_dir', array( __CLASS__, '_user_avatar_upload_dir' ), 10000 );
			if ( is_array( $result ) ) {
				$result['name'] = $upload_dir['subdir'] . '/' . basename( $result['file'] );
				unset( $result['file'] );
			} else {
				$result = array(
					'error' => __( 'Upload profile avatar error.', 'learningonline' )
				);
			}
			learning_online_send_json( $result );
		}

		public static function _user_avatar_upload_dir ( $dir ) {
			$dir = learning_online_user_profile_picture_upload_dir();

			return $dir;
		}

		/**
		 * Become a teacher
		 */
		public static function _request_become_a_teacher () {
			$response = learning_online_process_become_a_teacher_form(
				array(
					'name'  => learning_online_get_request( 'bat_name' ),
					'email' => learning_online_get_request( 'bat_email' ),
					'phone' => learning_online_get_request( 'bat_phone' )
				)
			);
			learning_online_send_json( $response );
		}

		/**
		 * Checkout process
		 *
		 * @return array|mixed|void
		 */
		public static function _request_checkout () {
			return LP()->checkout->process_checkout_handler();
		}

		/**
		 * Enroll course
		 *
		 * @return bool
		 * @throws Exception
		 */
		public static function _request_enroll_course () {
			$course_id = learning_online_get_request( 'enroll-course' );
			if ( ! $course_id ) {
				throw new Exception( __( 'Invalid course', 'learningonline' ) );
			}
			$insert_id = LP()->user->enroll( $course_id );

			$response = array(
				'result'   => 'fail',
				'redirect' => apply_filters( 'learning_online_enroll_course_failure_redirect_url', get_the_permalink( $course_id ) )
			);

			if ( $insert_id ) {
				$response['result']   = 'success';
				$response['redirect'] = apply_filters( 'learning_online_enrolled_course_redirect_url', get_the_permalink( $course_id ) );
				$message              = apply_filters( 'learning_online_enrolled_course_message', sprintf( __( 'You have enrolled in this course <strong>%s</strong>', 'learningonline' ), get_the_title( $course_id ) ), $course_id, LP()->user->id );
				learning_online_add_message( $message );
			} else {
				$message = apply_filters( 'learning_online_enroll_course_failed_message', sprintf( __( 'Sorry! The course <strong>%s</strong> you want to enroll has failed! Please contact site\'s administrator for more information.', 'learningonline' ), get_the_title( $course_id ) ), $course_id, LP()->user->id );
				learning_online_add_message( $message, 'error' );
			}
			if ( learning_online_is_ajax() ) {
				learning_online_send_json( $response );
			}

			if ( $response['redirect'] ) {
				wp_redirect( $response['redirect'] );
				exit();
			}

			return false;
		}

		/**
		 * Request login in checkout process
		 *
		 * @return array
		 */
		public static function _request_checkout_login () {
			$result = array(
				'result' => 'success'
			);
			ob_start();
			if ( empty( $_REQUEST['user_login'] ) ) {
				$result['result'] = 'fail';
				learning_online_add_message( __( 'Please enter username', 'learningonline' ), 'error' );
			}
			if ( empty( $_REQUEST['user_password'] ) ) {
				$result['result'] = 'fail';
				learning_online_add_message( __( 'Please enter password', 'learningonline' ), 'error' );
			}
			if ( $result['result'] == 'success' ) {
				$creds                  = array();
				$creds['user_login']    = $_REQUEST['user_login'];
				$creds['user_password'] = $_REQUEST['user_password'];
				$creds['remember']      = true;
				$user                   = wp_signon( $creds, false );
				if ( is_wp_error( $user ) ) {
					$result['result'] = 'fail';
					learning_online_add_message( $user->get_error_message(), 'error' );
				} else {
					$result['redirect'] = learning_online_get_page_link( 'checkout' );
				}
			}
			learning_online_print_notices();
			$messages = ob_get_clean();
			if ( $result['result'] == 'fail' ) {
				$result['messages'] = $messages;
			}

			return $result;
		}

		/**
		 * Request login in profile
		 */
		public static function _request_login () {
			$data_str = learning_online_get_request( 'data' );
			$data     = null;
			if ( $data_str ) {
				parse_str( $data_str, $data );
			}

			$user = wp_signon(
				array(
					'user_login'    => $data['log'],
					'user_password' => $data['pwd'],
					'remember'      => isset( $data['rememberme'] ) ? $data['rememberme'] : false,
				),
				is_ssl()
			);

			$error  = is_wp_error( $user );
			$return = array(
				'result'   => $error ? 'error' : 'success',
				'redirect' => ( ! $error && ! empty( $data['redirect_to'] ) ) ? $data['redirect_to'] : ''
			);
			if ( $error ) {
				$return['message'] = learning_online_get_message( $user->get_error_message() ? $user->get_error_message() : __( 'Please enter your username and/or password', 'learningonline' ) );
			} else {
				wp_set_current_user( $user->ID );
				$next = learning_online_get_request( 'next' );
				if ( $next == 'enroll-course' ) {
					$user     = new LP_User( $user->ID );
					$checkout = false;
					if ( $cart_items = LP()->cart->get_items() ) {
						foreach ( $cart_items as $item ) {
							if ( $user->has_enrolled_course( $item['item_id'] ) ) {
								$checkout = $item['item_id'];
							} elseif ( $user->has_purchased_course( $item['item_id'] ) ) {
								$checkout = $item['item_id'];
								$user->enroll( $item['item_id'] );
							}
							if ( $checkout ) {
								LP()->cart->remove_item( $checkout );
								$return['redirect'] = get_the_permalink( $checkout );
								learning_online_add_message( sprintf( __( 'Welcome back, %s. You\'ve already enrolled this course', 'learningonline' ), $user->user->display_name ) );
								break;
							}
						}
					}
					if ( $checkout === false ) {
						add_filter( 'learning_online_checkout_success_result', '_learning_online_checkout_auto_enroll_free_course', 10, 2 );
						$checkout = LP()->checkout()->process_checkout();
					} else {
					}

					return;
				}
				$return['message'] = learning_online_get_message( sprintf( __( 'Welcome back, %s! Redirecting...', 'learningonline' ), learning_online_get_profile_display_name( $user ) ) );
			}
			learning_online_send_json( $return );
		}

		/**
		 * Request add-to-cart a course
		 */
		public static function _request_add_to_cart () {
			$cart      = learning_online_get_cart();
			$course_id = learning_online_get_request( 'purchase-course' );

			$cart->add_to_cart( $course_id );
			$return = array(
				'result'   => 'success',
				'redirect' => learning_online_get_checkout_url()
			);
			if ( learning_online_is_ajax() ) {
				learning_online_send_json( $return );
			} else {
				wp_redirect( $return['redirect'] );
			}
		}

		/**
		 * Request finish course
		 */
		public static function _request_finish_course () {
			$nonce     = learning_online_get_request( 'security' );
			$course_id = absint( learning_online_get_request( 'id' ) );
			$user      = learning_online_get_current_user();

			$course = LP_Course::get_course( $course_id );

			$nonce_action = sprintf( 'learning-online-finish-course-%d-%d', $course_id, $user->id );
			if ( ! $user->id || ! $course || ! wp_verify_nonce( $nonce, $nonce_action ) ) {
				wp_die( __( 'Access denied!', 'learningonline' ) );
			}

			$finished = $user->finish_course( $course_id );

			$response = array();

			if ( $finished ) {
				learning_online_add_message( sprintf( __( 'You have finished this course "%s"', 'learningonline' ), $course->get_title() ) );
				$response['redirect'] = get_the_permalink( $course_id );

				$response['result'] = 'success';
			} else {
				$response['message'] = __( 'Error! You cannot finish this course. Please contact your administrator for more information.', 'learningonline' );
				$response['result']  = 'error';
			}

			learning_online_send_json( $response );
		}

		/**
		 * Request complete an item
		 */
		public static function _request_complete_item () {
			$user      = learning_online_get_current_user();
			$id        = learning_online_get_request( 'id' );
			$course_id = ! empty( $_REQUEST['course_id'] ) ? $_REQUEST['course_id'] : get_the_ID();
			$type      = learning_online_get_request( 'type' );
			$security  = learning_online_get_request( 'security' );
			$response  = array();
			if ( ! wp_verify_nonce( $security, sprintf( 'complete-item-%d-%d-%d', $user->id, $course_id, $id ) ) ) {
				$response['result']  = 'fail';
				$response['message'] = __( 'Bad request!', 'learningonline' );
			} else {
				if ( $type == 'lp_lesson' ) {
					$results = $user->complete_lesson( $id, $course_id );

					if ( is_wp_error( $results ) ) {
						learning_online_add_message( __( 'Error while completing lesson.', 'learningonline' ) );
					} elseif ( $results !== false ) {

						$message   = __( 'You have completed lesson', 'learningonline' );
						$auto_next = LP()->settings->get( 'auto_redirect_next_lesson' );
						$time      = LP()->settings->get( 'auto_redirect_time' );
						$time      = absint( $time );

						if ( $auto_next === 'yes' ) {
							ob_start();
							?>
							<script type="text/javascript">

								'use strict';

								(function ($) {

									$(document).ready(function () {

										var $nextItem = $('.button-load-item', '#lp-navigation .nav-next'),
											$message = $('.learning-online-auto-redirect-next-item'),
											time = <?php echo esc_js( $time ); ?>;

										if ($nextItem.length) {

											time = !parseInt(time) ? 0 : parseInt(time);

											if (!time) {
												$nextItem.trigger('click');
											}
											else {
												if ($message.length) {

													$message.addClass('active');

													var $count = $('.learning-online-countdown', $message),
														interval = setInterval(function () {

															if (time <= 1) {
																clearInterval(interval);
																$nextItem.trigger('click');
															}
															else {
																$count.text(--time);
															}

														}, 1000);

													$('.learningonline-dismiss-notice', $message).on('click', function () {

														clearInterval(interval);

														$message.hide(200, function () {
															$(this).remove();
														});

													});
												}
											}

										}
									});

								})(jQuery);
							</script>
							<?php
							$message .= ob_get_contents();
							ob_get_clean();
						}
						learning_online_add_message( $message );

					}

				} else {
					do_action( 'learning_online_user_request_complete_item', $_REQUEST );
				}
			}
			wp_redirect( learning_online_get_current_url() );
			die();
		}

		/**
		 * Request load item content
		 */
		public static function _request_load_item () {
			global $wpdb;
			$user      = learning_online_get_current_user();
			$item_id   = learning_online_get_request( 'id' );
			$course_id = get_the_ID();
			// Ensure that user can view course item
			$can_view_item = $user->can( 'view-item', $item_id, $course_id );
			if ( $can_view_item ) {
				// Update user item if it's not updated
				if ( ! $user->get_item_status( $item_id, $course_id ) ) {
					$item_type = learning_online_get_request( 'type' );
					if ( ! $item_type ) {
						$item_type = get_post_type( $item_id );
					}
					if ( apply_filters( 'learning_online_insert_user_item_data', true, $item_id, $course_id ) && $can_view_item != 'preview' ) {
						$insert = $wpdb->insert(
							$wpdb->prefix . 'learningonline_user_items',
							apply_filters(
								'learning_online_user_item_data',
								array(
									'user_id'    => get_current_user_id(),
									'item_id'    => learning_online_get_request( 'id' ),
									'item_type'  => $item_type,
									'start_time' => $item_type == 'lp_lesson' ? current_time( 'mysql' ) : '0000-00-00 00:00:00',
									'end_time'   => '0000-00-00 00:00:00',
									'status'     => $item_type == 'lp_lesson' ? 'started' : 'viewed',
									'ref_id'     => $course_id,
									'ref_type'   => 'lp_course',
									'parent_id'  => $user->get_course_history_id( $course_id )
								)
							),
							array(
								'%d',
								'%d',
								'%s',
								'%s',
								'%s',
								'%s',
								'%d',
								'%s'
							)
						);
						print_r( $wpdb );
						$user_item_id = $wpdb->insert_id;
					}
				}
				// display content item
				learning_online_get_template( 'single-course/content-item.php' );
			} else {
				// display message
				learning_online_get_template( 'singe-course/content-protected.php' );
			}
			die();
		}

		/**
		 * die();
		 * Student take course
		 * @return void
		 */
		public static function take_course () {
			$payment_method = ! empty( $_POST['payment_method'] ) ? $_POST['payment_method'] : '';
			$course_id      = ! empty( $_POST['course_id'] ) ? intval( $_POST['course_id'] ) : false;
			do_action( 'learning_online_take_course', $course_id, $payment_method );
		}

		/**
		 * Load quiz question
		 */
		public static function load_quiz_question () {
			$quiz_id     = ! empty( $_REQUEST['quiz_id'] ) ? absint( $_REQUEST['quiz_id'] ) : 0;
			$question_id = ! empty( $_REQUEST['question_id'] ) ? absint( $_REQUEST['question_id'] ) : 0;
			$user_id     = ! empty( $_REQUEST['user_id'] ) ? absint( $_REQUEST['user_id'] ) : 0;
			global $quiz;
			$quiz      = LP_Quiz::get_quiz( $quiz_id );
			LP()->quiz = $quiz;
			do_action( 'learning_online_load_quiz_question', $question_id, $quiz_id, $user_id );
			$user = learning_online_get_current_user();
			if ( $user->id != $user_id ) {
				learning_online_send_json(
					array(
						'result'  => 'error',
						'message' => __( 'Load question error. Try again!', 'learningonline' )
					)
				);
			}
			if ( ! $quiz_id || ! $question_id ) {
				learning_online_send_json(
					array(
						'result'  => 'error',
						'message' => __( 'Something is wrong. Try again!', 'learningonline' )
					)
				);
			}
			if ( $question = LP_Question_Factory::get_question( $question_id ) ) {
				$quiz->current_question = $question;

				ob_start();
				if ( $progress = $user->get_quiz_progress( $quiz->id ) ) {
					learning_online_update_user_quiz_meta( $progress->history_id, 'current_question', $question_id );
				}
				$question_answers = $user->get_question_answers( $quiz->id, $question_id );
				$question->render( array( 'answered' => $question_answers ) );

				$content = ob_get_clean();
				learning_online_send_json(
					apply_filters( 'learning_online_load_quiz_question_result_data', array(
							'result'    => 'success',
							'permalink' => learning_online_get_user_question_url( $quiz_id, $question_id ),
							'question'  => array(
								'content' => $content
							)
						)
					)
				);
			}
		}

		/**
		 * Finish quiz
		 */
		public static function finish_quiz () {
			$user    = learning_online_get_current_user();
			$quiz_id = learning_online_get_request( 'quiz_id' );
			$user->finish_quiz( $quiz_id );
			$response = array(
				'redirect' => get_the_permalink( $quiz_id )
			);
			learning_online_send_json( $response );
		}

		/**
		 *  Retake a quiz
		 */
		public static function retake_quiz () {
			die( __FUNCTION__ );
			// verify nonce
			if ( ! wp_verify_nonce( learning_online_get_request( 'nonce' ), 'retake-quiz' ) ) {
				learning_online_send_json(
					array(
						'result'  => 'fail',
						'message' => __( 'Something went wrong. Please try again!', 'learningonline' )
					)
				);
			}
			$quiz_id  = learning_online_get_request( 'quiz_id' );
			$user     = learning_online_get_current_user();
			$response = $user->retake_quiz( $quiz_id );
			learning_online_send_json( $response );
		}

		/**
		 * Load lesson content
		 */
		public static function load_lesson_content () {
			learning_online_debug( $_REQUEST );
			global $post;
			$lesson_id = $_POST['lesson_id'];
			$title     = get_the_title( $lesson_id );
			$post      = get_post( $lesson_id );
			$content   = $post->post_content;
			$content   = apply_filters( 'the_content', $content );
			printf(
				'<h3>%s</h3>
				%s
				<button class="complete-lesson-button">Complete Lesson</button>',
				$title,
				$content
			);
			die;
		}

		/**
		 * Complete lesson
		 */
		public static function complete_lesson () {
			$nonce        = learning_online_get_request( 'nonce' );
			$item_id      = learning_online_get_request( 'id' );
			$course_id    = learning_online_get_request( 'course_id' );
			$post         = get_post( $item_id );
			$user         = learning_online_get_current_user();
			$course       = LP_Course::get_course( $course_id );
			$response     = array(
				'result' => 'success'
			);
			$nonce_action = sprintf( 'learning-online-complete-%s-%d-%d-%d', $post->post_type, $post->ID, $course->id, $user->id );
			// security check
			if ( ! $post || ( $post && ! wp_verify_nonce( $nonce, $nonce_action ) ) ) {
				$response['result']  = 'error';
				$response['message'] = __( 'Error! Invalid lesson or security checked failure', 'learningonline' );
			}

			if ( $response['result'] == 'success' ) {
				$result = $user->complete_lesson( $item_id );
				if ( ! is_wp_error( $result ) ) {
					$can_finish                = $user->can_finish_course( $course_id );
					$response['button_text']   = '<span class="dashicons dashicons-yes"></span>' . __( 'Completed', 'learningonline' );
					$response['course_result'] = round( $result * 100, 0 );
					$response['can_finish']    = $can_finish;
					$response['next_item']     = $course->get_next_item( $item_id );

					ob_start();
					if ( $can_finish ) {
						learning_online_display_message( __( 'Congratulations! You have completed this lesson and you can finish course.', 'learningonline' ) );
					} else {
						learning_online_display_message( __( 'Congratulations! You have completed this lesson.', 'learningonline' ) );
					}
					$response['message'] = ob_get_clean();
				} else {
					ob_start();
					learning_online_display_message( $result->get_error_message() );
					$response['message'] = ob_get_clean();
					$response['result']  = 'fail';
				}
			}
			learning_online_send_json( $response );
		}

		/**
		 * Retake course action
		 */
		public static function _request_retake_course () {
			$security        = learning_online_get_request( 'security' );
			$course_id       = learning_online_get_request( 'course_id' );
			$user            = learning_online_get_current_user();
			$course          = LP_Course::get_course( $course_id );
			$response        = array(
				'result' => 'error'
			);
			$security_action = sprintf( 'learning-online-retake-course-%d-%d', $course->id, $user->id );
			// security check
			if ( ! wp_verify_nonce( $security, $security_action ) ) {
				$response['message'] = __( 'Error! Invalid lesson or security checked failure', 'learningonline' );
			} else {
				if ( $user->can( 'retake-course', $course_id ) ) {
					if ( ! $result = $user->retake_course( $course_id ) ) {
						$response['message'] = __( 'Error!', 'learningonline' );
					} else {
						learning_online_add_message( sprintf( __( 'You have retaken course "%s"', 'learningonline' ), $course->get_title() ) );
						$response['result']   = 'success';
						$response['redirect'] = apply_filters( 'learning_online_retake_course_redirect', add_query_arg( 'retaken-course', $course_id, get_the_permalink( $course_id ) ) );
					}
				} else {
					$result['message'] = __( 'Error! You can not retake course', 'learningonline' );
				}
			}
			learning_online_send_json( $response );
		}

		public static function start_quiz () {
			$quiz_id = ! empty( $_REQUEST['quiz_id'] ) ? absint( $_REQUEST['quiz_id'] ) : 0;
			if ( ! $quiz_id ) {
				learning_online_send_json(
					array(
						'result'  => 'error',
						'message' => __( 'The quiz ID is empty', 'learningonline' )
					)
				);
			}
			global $quiz;

			$quiz = LP_Quiz::get_quiz( $quiz_id );

			if ( ! $quiz->id || $quiz->id != $quiz_id ) {
				learning_online_send_json(
					array(
						'result'  => 'error',
						'message' => __( 'Something is wrong! Please try again', 'learningonline' )
					)
				);
			}
			$user = learning_online_get_current_user();
			if ( $quiz->is_require_enrollment() && $user->is( 'guest' ) ) {
				learning_online_send_json(
					array(
						'result'  => 'error',
						'message' => __( 'Please login to take this quiz', 'learningonline' )
					)
				);
			}
			$user->set_quiz( $quiz );

			switch ( strtolower( $user->get_quiz_status() ) ) {
				case 'completed':
					learning_online_send_json(
						array(
							'result'  => 'error',
							'message' => __( 'You have completed this quiz', 'learningonline' ),
							'data'    => $user->get_quiz_result()
						)
					);
					break;
				case 'started':
					learning_online_send_json(
						array(
							'result'  => 'error',
							'message' => __( 'You have started this quiz', 'learningonline' ),
							'data'    => array(
								'status' => $user->get_quiz_status()
							)
						)
					);
					break;
				default:
					$result           = $user->start_quiz();
					$current_question = ! empty( $result['current_question'] ) ? $result['current_question'] : $user->get_current_question_id( $quiz_id );
					learning_online_send_json(
						array(
							'result'           => 'success',
							'data'             => $result,
							'question_url'     => learning_online_get_user_question_url( $quiz_id, $current_question ),
							'question_content' => LP_Question_Factory::fetch_question_content( $current_question )
						)
					);
			}
			die();
		}
	}
}
// Call class
LP_AJAX::init();