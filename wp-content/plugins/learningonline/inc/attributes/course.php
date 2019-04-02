<?php

/**
 * Add attributes feature for course
 *
 * @since 2.1.4
 */
if ( !class_exists( 'LP_Course_Attributes' ) ) {
	/**
	 * Class LP_Course_Attributes
	 */
	class LP_Course_Attributes {
		/**
		 * @var string
		 */
		private $_tax = '';

		/**
		 * @var bool
		 */
		private $_screen = false;

		/**
		 * @var null
		 */
		private $_attribute_terms = null;

		/**
		 * LP_Course_Attributes constructor.
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'register' ), 10 );
			add_action( 'load-edit-tags.php', array( $this, 'ready' ) );
			add_action( 'pre_delete_term', array( $this, 'pre_delete_term' ), 10, 2 );
			add_action( 'delete_term', array( $this, 'delete_terms' ), 10, 5 );

			add_filter( 'learning_online_admin_tabs_info', array( $this, 'admin_tab' ) );
			add_filter( "course_attribute_row_actions", array( $this, 'row_actions' ), 10, 2 );
			add_filter( 'terms_clauses', array( $this, 'term_clauses' ), 10, 3 );
			add_filter( 'learning_online_admin_tabs_on_pages', array( $this, 'admin_tabs_pages' ) );

			add_filter( 'learning_online_lp_course_tabs', array( $this, 'course_attributes_tab' ) );
			add_action( 'learning_online_admin_load_scripts', array( $this, 'admin_scripts' ) );

			LP_Request_Handler::register(
				array(
					array(
						'priority' => 100,
						'action'   => 'remove-course-attribute-terms',
						'callback' => array( $this, 'remove_terms' )
					),
					array(
						'action'   => 'add-attribute-to-course',
						'callback' => array( $this, 'add_attribute_to_course' )
					),
					array(
						'action'   => 'add-attribute-value',
						'callback' => array( $this, 'add_attribute_value' )
					),
					array(
						'action'   => 'save-attributes',
						'callback' => array( $this, 'save_attributes' )
					)
				)
			);
		}

		public function save_attributes( $course_id ) {
			$data       = learning_online_get_request( 'data' );
			$attributes = array();
			parse_str( $data, $attributes );
			if ( $attributes ) {
				$attributes = $attributes['course-attribute-values'];
				foreach ( $attributes as $taxonomy_id => $values ) {
					if ( !$values ) {
						continue;
					}
					$taxonomy = get_term( $taxonomy_id, LP_COURSE_ATTRIBUTE );
					wp_set_object_terms( $course_id, $values, LP_COURSE_ATTRIBUTE . '-' . $taxonomy->slug );
				}
			}
			die();
		}

		public function add_attribute_value( $course_id ) {

			if ( LP_COURSE_CPT != get_post_type( $course_id ) ) {
				return;
			}

			$taxonomy = learning_online_get_request( 'taxonomy' );
			$name     = learning_online_get_request( 'name' );
			$new      = learning_online_add_course_attribute_value( $name, $taxonomy );
			$response = array();
			if ( !is_wp_error( $new ) ) {
				$term             = get_term_by( 'term_taxonomy_id', $new['term_taxonomy_id'] );
				$response['slug'] = $term->slug;
				$response['name'] = $term->name;

				$response['result'] = 'success';
			} elseif ( !$new ) {
				$response['result'] = 'error';
				$response['error']  = __( 'Unknown error', 'learningonline' );
			} else {
				$response['result'] = 'error';
				$response['error']  = $new->get_error_messages();
			}
			learning_online_send_json( $response );
			die();
		}

		public function add_attribute_to_course( $course_id ) {
			$taxonomy = learning_online_get_request( 'taxonomy' );

			if ( LP_COURSE_CPT != get_post_type( $course_id ) ) {
				return;
			}

			if ( $attribute = learning_online_add_attribute_to_course( $course_id, $taxonomy ) ) {
				$postId = $course_id;
				include learning_online_get_admin_view( 'meta-boxes/course/html-course-attribute' );
			}

			die();
		}

		public function admin_scripts() {
			LP_Assets::enqueue_script( 'learning-online-course-attributes' );
			LP_Assets::enqueue_script( 'select2' );
			LP_Assets::enqueue_style( 'learning-online-course-attributes' );
			LP_Assets::enqueue_style( 'learning-online-statistics-select2' );

		}

		public function course_attributes_tab( $tabs ) {
			$tabs['attributes'] = array(
				'title'    => __( 'Attributes', 'learningonline' ),
				'callback' => array( $this, 'course_attributes' )
			);
			return $tabs;
		}

		public function course_attributes() {
			include learning_online_admin_view( 'meta-boxes/course/attributes' );
		}

		public function remove_terms( $attribute ) {
			if ( learning_online_delete_attribute_terms( $attribute ) ) {
				learning_online_add_notice( 'Deleted attribute terms', 'learningonline' );
			}
			wp_redirect( remove_query_arg( 'remove-course-attribute-terms' ) );
		}

		/**
		 * @param int     $term
		 * @param int     $tt_id
		 * @param string  $taxonomy
		 * @param WP_Term $deleted_term
		 * @param array   $object_ids
		 *
		 * @return array|bool
		 */
		public function delete_terms( $term, $tt_id, $taxonomy, $deleted_term, $object_ids ) {
			if ( LP_COURSE_ATTRIBUTE != $taxonomy ) {
				return false;
			}
			return learning_online_delete_attribute_terms( $deleted_term->slug );
		}

		public function pre_delete_term( $term, $taxonomy ) {

		}

		/**
		 *
		 */
		public function ready() {
			if ( !empty( $_REQUEST['taxonomy'] ) && strpos( $_REQUEST['taxonomy'], LP_COURSE_ATTRIBUTE ) !== false ) {
				$this->_tax    = $_REQUEST['taxonomy'];
				$this->_screen = get_current_screen();
				if ( $this->_screen->id == 'edit-' . LP_COURSE_ATTRIBUTE ) {
					add_filter( "manage_{$this->_screen->id}_columns", array( $this, 'columns' ) );
					add_filter( "manage_{$this->_tax}_custom_column", array( $this, 'column' ), 10, 3 );
				}
			}
		}

		/**
		 * @param $content
		 * @param $column_name
		 * @param $term_id
		 *
		 * @return string
		 */
		public function column( $content, $column_name, $term_id ) {
			if ( $column_name == 'terms' ) {
				$attribute = get_term( $term_id );

				if ( $terms = learning_online_get_attribute_terms( $term_id ) ) {
					$term_labels = array();
					foreach ( $terms as $term ) {
						$term_labels[] = sprintf( '<a href="%s">%s</a>', get_edit_term_link( $term->term_id, $term->taxonomy, LP_COURSE_CPT ), $term->name );
					}
					$content = join( ', ', $term_labels );

				} else {
					$content .= __( 'No terms found.', 'learningonline' );
				}
				$content .= '<div class="row-actions">' . $this->terms_row_actions( $attribute ) . '</div>';

			}
			return $content;
		}

		/**
		 * @param $tax
		 *
		 * @return string
		 */
		public function terms_row_actions( $tax ) {
			$uri           = wp_doing_ajax() ? wp_get_referer() : $_SERVER['REQUEST_URI'];
			$edit_link     = add_query_arg(
				'wp_http_referer',
				urlencode( wp_unslash( $uri ) ),
				add_query_arg( array( 'taxonomy' => LP_COURSE_ATTRIBUTE . '-' . $tax->slug, 'post_type' => LP_COURSE_CPT ), admin_url( 'term.php' ) )
			);
			$terms_actions = array(
				'edit'   => sprintf(
					'<a href="%s" aria-label="%s" >%s </a > ',
					esc_url( $edit_link ),
					esc_attr( sprintf( __( 'Edit &#8220;%s&#8221;' ), $tax->name ) ),
					__( 'Edit', 'learningonline' )
				),
				'delete' => sprintf(
					'<a href="%s" aria-label="%s" >%s </a > ',
					esc_url( add_query_arg( 'remove-course-attribute-terms', $tax->term_id ) ),
					'',
					__( 'Clear', 'learningonline' )
				)
			);
			return join( ' | ', $terms_actions );
		}

		/**
		 * @param $columns
		 *
		 * @return mixed
		 */
		public function columns( $columns ) {
			if ( $this->_tax == LP_COURSE_ATTRIBUTE && !empty( $columns['posts'] ) ) {
				unset( $columns['posts'] );
			}
			$columns['terms'] = __( 'Terms', 'learningonline' );
			return $columns;
		}

		/**
		 * @param $pages
		 *
		 * @return array
		 */
		public function admin_tabs_pages( $pages ) {
			if ( !empty( $_REQUEST['taxonomy'] ) && strpos( $_REQUEST['taxonomy'], LP_COURSE_ATTRIBUTE ) !== false ) {
				$screen_id = get_current_screen()->id;
				$pages[]   = $screen_id;
			}
			return $pages;
		}

		/**
		 * @param $a
		 * @param $b
		 * @param $c
		 *
		 * @return mixed
		 */
		public function term_clauses( $a, $b, $c ) {
			//print_r( func_get_args() );
			return $a;
		}

		/**
		 * @param $tabs
		 *
		 * @return array
		 */
		public function admin_tab( $tabs ) {
			if ( !empty( $_REQUEST['taxonomy'] ) && strpos( $_REQUEST['taxonomy'], LP_COURSE_ATTRIBUTE ) !== false ) {
				$screen_id = get_current_screen()->id;
			} else {
				$screen_id = 'edit-' . LP_COURSE_ATTRIBUTE;
			}
			$tabs[] = array(
				"link" => "edit-tags.php?taxonomy=" . LP_COURSE_ATTRIBUTE . "&post_type=lp_course",
				"name" => __( "Attributes", "learningonline" ),
				"id"   => $screen_id,
			);
			return $tabs;
		}

		public function register() {
			register_taxonomy(
				LP_COURSE_ATTRIBUTE,
				array( 'lp_course' ),
				array(
					'label'        => __( 'Attribute', 'learningonline' ),
					'labels'       => array(
						'name'          => __( 'Attributes', 'learningonline' ),
						'singular_name' => __( 'Attribute', 'learningonline' ),
						'menu_name'     => __( 'Attributes', 'learningonline' ),
						'add_new_item'  => __( 'Add New Attribute', 'learningonline' ),
						'all_items'     => __( 'All Attributes', 'learningonline' )
					),
					'show_ui'      => true,
					'query_var'    => true,
					'show_in_menu' => 'learning_online',
					'public'       => false,
					'rewrite'      => array(
						'slug'         => LP_COURSE_ATTRIBUTE,//empty( $permalinks['category_base'] ) ? _x( 'product - category', 'slug', 'woocommerce' ) : $permalinks['category_base'],
						'with_front'   => false,
						'hierarchical' => true,
					),
				)
			);

			if ( $attributes = learning_online_get_attributes() ) {
				foreach ( $attributes as $attribute ) {
					$this->_register_custom_attribute( $attribute );
				}
			}
		}

		/**
		 * @param $actions
		 * @param $tag
		 *
		 * @return mixed
		 */
		public function row_actions( $actions, $tag ) {

			return $actions;
		}

		/**
		 * @param $attribute
		 */
		private function _register_custom_attribute( $attribute ) {
			$name          = $attribute->name;
			$singular_name = $attribute->name;
			$tax_data      = array(
				'hierarchical'          => true,
				'update_count_callback' => '_update_post_term_count',
				'labels'                => array(
					'name'              => $name,
					'singular_name'     => $singular_name,
					'search_items'      => sprintf( __( 'Search Course %s', 'learningonline' ), $name ),
					'all_items'         => sprintf( __( 'All Course %s', 'learningonline' ), $name ),
					'parent_item'       => sprintf( __( 'Parent Course %s', 'learningonline' ), $singular_name ),
					'parent_item_colon' => sprintf( __( 'Parent Course %s:', 'learningonline' ), $singular_name ),
					'edit_item'         => sprintf( __( 'Edit Course %s', 'learningonline' ), $singular_name ),
					'update_item'       => sprintf( __( 'Update Course %s', 'learningonline' ), $singular_name ),
					'add_new_item'      => sprintf( __( 'Add New Course %s', 'learningonline' ), $singular_name ),
					'new_item_name'     => sprintf( __( 'New Course %s', 'learningonline' ), $singular_name ),
					'not_found'         => sprintf( __( 'No &quot;Course %s&quot; found', 'learningonline' ), $singular_name ),
				),
				'show_ui'               => true,
				'show_in_quick_edit'    => false,
				'show_in_menu'          => false,
				'show_in_nav_menus'     => false,
				'meta_box_cb'           => false,
				'query_var'             => false,
				'rewrite'               => false,
				'sort'                  => false,
				'public'                => false,
				'show_in_nav_menus'     => false/*,
				'capabilities'          => array(
					'manage_terms' => 'manage_lp_course_terms',
					'edit_terms'   => 'edit_lp_course_terms',
					'delete_terms' => 'delete_lp_course_terms',
					'assign_terms' => 'assign_lp_course_terms',
				)*/
			);

			$tax_data['rewrite'] = array(
				'slug'         => $attribute->slug,// empty( $permalinks['attribute_base'] ) ? '' : trailingslashit( $permalinks['attribute_base'] ) . sanitize_title( $tax->attribute_name ),
				'with_front'   => false,
				'hierarchical' => true
			);

			register_taxonomy(
				sprintf( '%s-%s', LP_COURSE_ATTRIBUTE, $attribute->slug ),
				apply_filters( 'learning_online_course_attribute_object_' . $attribute->slug, array( 'lp_course' ) ),
				apply_filters( 'learning_online_course_attribute_args_' . $attribute->slug, $tax_data )
			);

		}
	}
}
return new LP_Course_Attributes();