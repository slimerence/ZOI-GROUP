<?php
// hotfix
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( !class_exists( 'LP_Question_Post_Type' ) ) {
	// class LP_Question_Post_Type
	class LP_Question_Post_Type extends LP_Abstract_Post_Type {
		/**
		 * @var null
		 */
		protected static $_instance = null;

		/**
		 * LP_Question_Post_Type constructor.
		 *
		 * @param $post_type
		 * @param mixed
		 */
		public function __construct( $post_type, $args = '' ) {
			add_action( 'admin_head', array( $this, 'init' ) );
			add_action( 'init', array( $this, 'init_question' ) );
			parent::__construct( $post_type, $args );

		}

		public function init_question() {
			if ( !empty( $_REQUEST['post'] ) && get_post_type( $_REQUEST['post'] ) == LP_QUESTION_CPT ) {
				$q = _learning_online_setup_question( array( $_REQUEST['post'] ) );
			}
		}

		public function init() {
			global $pagenow, $post_type;
			$hidden = get_user_meta( get_current_user_id(), 'manageedit-lp_questioncolumnshidden', true );
			if ( !is_array( $hidden ) && empty( $hidden ) ) {
				update_user_meta( get_current_user_id(), 'manageedit-lp_questioncolumnshidden', array( 'taxonomy-question-tag' ) );
			}
		}

		/**
		 * Delete all answers assign to question being deleted
		 *
		 * @param $post_id
		 */
		public function delete_question_answers( $post_id ) {
			global $wpdb;
			$query = $wpdb->prepare( "
				DELETE FROM {$wpdb->prefix}learningonline_question_answers
				WHERE question_id = %d
			", $post_id );
			$wpdb->query( $query );
			learning_online_reset_auto_increment( 'learningonline_question_answers' );

			// also, delete question from quiz
			$wpdb->query(
				$wpdb->prepare( "
					DELETE FROM {$wpdb->prefix}learningonline_quiz_questions
					WHERE question_id = %d
				", $post_id )
			);
			learning_online_reset_auto_increment( 'learningonline_quiz_questions' );
		}

		/**
		 * Register question post type
		 */
		public function register() {
			register_taxonomy( 'question_tag', array( LP_QUESTION_CPT ),
				array(
					'labels'            => array(
						'name'          => __( 'Question Tag', 'learningonline' ),
						'menu_name'     => __( 'Tag', 'learningonline' ),
						'singular_name' => __( 'Tag', 'learningonline' ),
						'add_new_item'  => __( 'Add New Tag', 'learningonline' ),
						'all_items'     => __( 'All Tags', 'learningonline' )
					),
					'public'            => true,
					'hierarchical'      => false,
					'show_ui'           => true,
					'show_admin_column' => 'true',
					'show_in_nav_menus' => true,
					'rewrite'           => array(
						'slug'         => 'question-tag',
						'hierarchical' => false,
						'with_front'   => false
					),
				)
			);
			add_post_type_support( 'question', 'comments' );
			return array(
				'labels'             => array(
					'name'               => __( 'Question Bank', 'learningonline' ),
					'menu_name'          => __( 'Question Bank', 'learningonline' ),
					'singular_name'      => __( 'Question', 'learningonline' ),
					'all_items'          => __( 'Questions', 'learningonline' ),
					'view_item'          => __( 'View Question', 'learningonline' ),
					'add_new_item'       => __( 'Add New Question', 'learningonline' ),
					'add_new'            => __( 'Add New', 'learningonline' ),
					'edit_item'          => __( 'Edit Question', 'learningonline' ),
					'update_item'        => __( 'Update Question', 'learningonline' ),
					'search_items'       => __( 'Search Questions', 'learningonline' ),
					'not_found'          => __( 'No questions found', 'learningonline' ),
					'not_found_in_trash' => __( 'No questions found in trash', 'learningonline' ),
				),
				'public'             => false, // disable access directly via permalink url
				'publicly_queryable' => false,
				'show_ui'            => true,
				'has_archive'        => false,
				'capability_type'    => LP_LESSON_CPT,
				'map_meta_cap'       => true,
				'show_in_menu'       => 'learning_online',
				'show_in_admin_bar'  => true,
				'show_in_nav_menus'  => true,
				'supports'           => array( 'title', 'editor', 'revisions' ),
				'hierarchical'       => true,
				'rewrite'            => array( 'slug' => 'questions', 'hierarchical' => true, 'with_front' => false )
			);
		}

		public function add_meta_boxes() {

			new RW_Meta_Box(
				array(
					'id'     => 'question_answer',
					'title'  => __( 'Answer', 'learningonline' ),
					'pages'  => array( LP_QUESTION_CPT ),
					'fields' => array(
						array(
							'name' => '',
							'id'   => "_lp_question_answer",
							'type' => 'question'
						)
					)
				)
			);

			$meta_box = self::settings_meta_box();
			new RW_Meta_Box( $meta_box );
			parent::add_meta_boxes();
		}

		public static function settings_meta_box() {
			$prefix   = '_lp_';
			$meta_box = array(
				'id'     => 'question_settings',
				'title'  => __( 'Settings', 'learningonline' ),
				'pages'  => array( LP_QUESTION_CPT ),
				'fields' => array(
					array(
						'name'  => __( 'Mark for this question', 'learningonline' ),
						'id'    => "{$prefix}mark",
						'type'  => 'number',
						'clone' => false,
						'desc'  => __( 'Mark for choosing the right answer.', 'learningonline' ),
						'min'   => 1,
						'std'   => 1
					),
					array(
						'name' => __( 'Question explanation', 'learningonline' ),
						'id'   => "{$prefix}explanation",
						'type' => 'textarea',
						'desc' => __( 'Explain why an option is true and other is false. The text will be shown when user click on \'Check answer\' button.', 'learningonline' ),
						'std'  => null
					),
					array(
						'name' => __( 'Question hint', 'learningonline' ),
						'id'   => "{$prefix}hint",
						'type' => 'textarea',
						'desc' => __( 'Instruction for user to select the right answer. The text will be shown when user clicking \'Hint\' button.', 'learningonline' ),
						'std'  => null
					)
				)
			);

			return apply_filters( 'learning_online_question_meta_box_args', $meta_box );
		}

		/**
		 * Enqueue scripts
		 */
		public function admin_scripts() {
			if ( !in_array( get_post_type(), array( LP_QUESTION_CPT ) ) ) return;
			ob_start();
			?>
			<script>
				var form = $('#post');
				form.submit(function (evt) {
					var $title = $('#title'),
						is_error = false;
					if (0 == $title.val().length) {
						alert('<?php _e( 'Please enter the title of the question.', 'learningonline' );?>');
						$title.focus();
						is_error = true;
					} else if ($('.lpr-question-types').length && ( 0 == $('.lpr-question-types').val().length )) {
						alert('<?php _e( 'Please enter question type.', 'learningonline' );?>');
						$('.lpr-question-types').focus();
						is_error = true;
					}
					if (is_error) {
						evt.preventDefault();
						return false;
					}
				});
			</script>
			<?php
			$script = ob_get_clean();
			$script = preg_replace( '!</?script>!', '', $script );
			learning_online_enqueue_script( $script );
			ob_start();
			?>
			<script type="text/html" id="tmpl-form-quick-add-question">
				<div id="lpr-form-quick-add-question" class="lpr-quick-add-form">
					<input type="text">
					<select class="lpr-question-types lpr-select2" name="lpr_question[type]" id="lpr-quiz-question-type">
						<?php if ( $questions = learning_online_question_types() ): ?>
							<?php foreach ( $questions as $type => $name ): ?>
								<option value="<?php echo $type; ?>"><?php echo $name; ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
					<button class="button" data-action="add" type="button"><?php _e( 'Add [Enter]', 'learningonline' ); ?></button>
					<button data-action="cancel" class="button" type="button"><?php _e( 'Cancel [ESC]', 'learningonline' ); ?></button>
					<span class="lpr-ajaxload">...</span>
				</div>
			</script>
			<?php
			$js_template = ob_get_clean();
			learning_online_enqueue_script( $js_template, true );
		}

		/**
		 * Add columns to admin manage question page
		 *
		 * @param  array $columns
		 *
		 * @return array
		 */
		public function columns_head( $columns ) {
			$pos         = array_search( 'title', array_keys( $columns ) );
			$new_columns = array(
				'author' => __( 'Author', 'learningonline' ),
				LP_QUIZ_CPT => __( 'Quiz', 'learningonline' ),
				'type'      => __( 'Type', 'learningonline' )
			);

			if ( false !== $pos && !array_key_exists( LP_QUIZ_CPT, $columns ) ) {
				$columns = array_merge(
					array_slice( $columns, 0, $pos + 1 ),
					$new_columns,
					array_slice( $columns, $pos + 1 )
				);
			}

			$user = wp_get_current_user();
			if ( in_array( LP_TEACHER_ROLE, $user->roles ) ) {
				unset( $columns['author'] );
			}
			return $columns;
		}

		/**
		 * Displaying the content of extra columns
		 *
		 * @param $name
		 * @param $post_id
		 */
		public function columns_content( $name, $post_id = 0 ) {
			switch ( $name ) {
				case LP_QUIZ_CPT:
					$quizzes = learning_online_get_question_quizzes( $post_id );
					if ( $quizzes ) {
						foreach ( $quizzes as $quiz ) {
							echo '<div><a href="' . esc_url( add_query_arg( array( 'filter_quiz' => $quiz->ID ) ) ) . '">' . get_the_title( $quiz->ID ) . '</a>';
							echo '<div class="row-actions">';
							printf( '<a href="%s">%s</a>', admin_url( sprintf( 'post.php?post=%d&action=edit', $quiz->ID ) ), __( 'Edit', 'learningonline' ) );
							echo "&nbsp;|&nbsp;";
							printf( '<a href="%s">%s</a>', get_the_permalink( $quiz->ID ), __( 'View', 'learningonline' ) );
							echo "&nbsp;|&nbsp;";
							if ( $quiz_id = learning_online_get_request( 'filter_quiz' ) ) {
								printf( '<a href="%s">%s</a>', remove_query_arg( 'filter_quiz' ), __( 'Remove Filter', 'learningonline' ) );
							} else {
								printf( '<a href="%s">%s</a>', add_query_arg( 'filter_quiz', $quiz->ID ), __( 'Filter', 'learningonline' ) );
							}
							echo '</div></div>';
						}

					} else {
						_e( 'Not assigned yet', 'learningonline' );
					}

					break;
				case 'type':
					echo learning_online_question_name_from_slug( get_post_meta( $post_id, '_lp_type', true ) );
			}
		}

		/**
		 * @param $join
		 *
		 * @return string
		 */
		public function posts_join_paged( $join ) {
			if ( !$this->_is_archive() ) {
				return $join;
			}
			global $wpdb;
			if ( $quiz_id = $this->_filter_quiz() || ( $this->_get_orderby() == 'quiz-name' ) ) {
				$join .= " LEFT JOIN {$wpdb->prefix}learningonline_quiz_questions qq ON {$wpdb->posts}.ID = qq.question_id";
				$join .= " LEFT JOIN {$wpdb->posts} q ON q.ID = qq.quiz_id";
			}
			return $join;
		}

		/**
		 * @param $where
		 *
		 * @return mixed|string
		 */
		public function posts_where_paged( $where ) {

			if ( !$this->_is_archive() ) {
				return $where;
			}

			global $wpdb;
			if ( $quiz_id = $this->_filter_quiz() ) {
				$where .= $wpdb->prepare( " AND (q.ID = %d)", $quiz_id );
			}
			return $where;
			if ( isset( $_GET['s'] ) ) {
				$s = $_GET['s'];
				if ( !empty( $s ) ) {
					$where = preg_replace(
						"/\.post_content\s+LIKE\s*(\'[^\']+\')\s*\)/",
						" .post_content LIKE '%$s%' ) OR ({$wpdb->posts}.post_title LIKE '%$s%' )", $where
					);
				}
			}

			return $where;
		}

		/**
		 * @param $order_by_statement
		 *
		 * @return string
		 */
		public function posts_orderby( $order_by_statement ) {
			if ( !$this->_is_archive() ) {
				return $order_by_statement;
			}
			if ( isset ( $_GET['orderby'] ) && isset ( $_GET['order'] ) ) {
				switch ( $_GET['orderby'] ) {
					case 'quiz-name':
						$order_by_statement = "q.post_title {$_GET['order']}";
						break;
				}
			}
			return $order_by_statement;
		}

		/**
		 * @param $columns
		 *
		 * @return mixed
		 */
		public function sortable_columns( $columns ) {
			$columns['author'] = 'author';
			$columns[LP_QUIZ_CPT] = 'quiz-name';
			return $columns;
		}

		public function admin_styles() {
		}

		public function admin_params() {

		}

		public function save() {
			//$this->save_post();
		}

		private function _is_archive() {
			global $pagenow, $post_type;
			if ( !is_admin() || ( $pagenow != 'edit.php' ) || ( LP_QUESTION_CPT != $post_type ) ) {
				return false;
			}
			return true;
		}

		private function _filter_quiz() {
			return !empty( $_REQUEST['filter_quiz'] ) ? absint( $_REQUEST['filter_quiz'] ) : false;
		}

		private function _get_orderby() {
			return isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : '';
		}

		public static function instance() {
			if ( !self::$_instance ) {
				$args            = array(
					'default_meta' => array(
						'_lp_mark' => 1,
						'_lp_type' => 'true_or_false'
					)
				);
				self::$_instance = new self( LP_QUESTION_CPT, $args );
			}
			return self::$_instance;
		}
	} // end LP_Question_Post_Type
	$question_post_type = LP_Question_Post_Type::instance();
}