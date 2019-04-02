<?php
/**
 * Handles taxonomies in admin
 *
 * @class    LP_Admin_Taxonomies
 * @version  2.3.10
 * @package  LearningOnline/Admin
 * @category Class
 * @author   JWS Themes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * LP_Admin_Taxonomies class.
 */
class LP_Admin_Taxonomies {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Category/term ordering
		add_action( 'create_term', array( $this, 'create_term' ), 5, 3 );
		add_action( 'delete_term', array( $this, 'delete_term' ), 5 );

		// Add form
		add_action( 'course_category_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'course_category_edit_form_fields', array( $this, 'edit_category_fields' ), 10 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );

		// Add columns
		add_filter( 'manage_edit-course_category_columns', array( $this, 'course_category_columns' ) );
		add_filter( 'manage_course_category_custom_column', array( $this, 'course_category_column' ), 10, 3 );

		// Taxonomy page descriptions
		add_action( 'course_category_pre_add_form', array( $this, 'course_category_description' ) );

		// Maintain hierarchy of terms
		add_filter( 'wp_terms_checklist_args', array( $this, 'disable_checked_ontop' ) );
	}

	/**
	 * Order term when created (put in position 0).
	 *
	 * @param mixed $term_id
	 * @param mixed $tt_id
	 * @param string $taxonomy
	 */
	public function create_term( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( 'course_category' != $taxonomy && ! taxonomy_is_course_attribute( $taxonomy ) ) {
			return;
		}

		$meta_name = taxonomy_is_course_attribute( $taxonomy ) ? 'order_' . esc_attr( $taxonomy ) : 'order';
		//var_dump($meta_name);
		//$message = "wrong answer";
		//echo "<script type='text/javascript'>alert('$meta_name');</script>";

		update_learningonline_term_meta( $term_id, $meta_name, 0 );
	}

	/**
	 * When a term is deleted, delete its meta.
	 *
	 * @param mixed $term_id
	 */
	public function delete_term( $term_id ) {
		global $wpdb;

		$term_id = absint( $term_id );

		if ( $term_id && get_option( 'db_version' ) < 34370 ) {
			$wpdb->delete( $wpdb->course_termmeta, array( 'course_term_id' => $term_id ), array( '%d' ) );
		}
	}

	/**
	 * Category thumbnail fields.
	 */
	public function add_category_fields() {
		?>
		<div class="form-field term-display-type-wrap">
			<label for="display_type"><?php _e( 'Display type', 'learningonline' ); ?></label>
			<select id="display_type" name="display_type" class="postform">
				<option value=""><?php _e( 'Default', 'learningonline' ); ?></option>
				<option value="courses"><?php _e( 'Courses', 'learningonline' ); ?></option>
				<option value="subcategories"><?php _e( 'Subcategories', 'learningonline' ); ?></option>
				<option value="both"><?php _e( 'Both', 'learningonline' ); ?></option>
			</select>
		</div>
		<div class="form-field term-thumbnail-wrap">
			<label><?php _e( 'Thumbnail', 'learningonline' ); ?></label>
			<div id="course_category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( lp_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="course_category_thumbnail_id" name="course_category_thumbnail_id" />
				<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'learningonline' ); ?></button>
				<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'learningonline' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( ! jQuery( '#course_category_thumbnail_id' ).val() ) {
					jQuery( '.remove_image_button' ).hide();
				}

				// Uploading files
				var file_frame;

				jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_frame ) {
						file_frame.open();
						return;
					}

					// Create the media frame.
					file_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( "Choose an image", "learningonline" ); ?>',
						button: {
							text: '<?php _e( "Use image", "learningonline" ); ?>'
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_frame.on( 'select', function() {
						var attachment = file_frame.state().get( 'selection' ).first().toJSON();

						jQuery( '#course_category_thumbnail_id' ).val( attachment.id );
						jQuery( '#course_category_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
						jQuery( '.remove_image_button' ).show();
					});

					// Finally, open the modal.
					file_frame.open();
				});

				jQuery( document ).on( 'click', '.remove_image_button', function() {
					jQuery( '#course_category_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( lp_placeholder_img_src() ); ?>' );
					jQuery( '#course_category_thumbnail_id' ).val( '' );
					jQuery( '.remove_image_button' ).hide();
					return false;
				});

				jQuery( document ).ajaxComplete( function( event, request, options ) {
					if ( request && 4 === request.readyState && 200 === request.status
						&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

						var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
						if ( ! res || res.errors ) {
							return;
						}
						// Clear Thumbnail fields on submit
						jQuery( '#course_category_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( lp_placeholder_img_src() ); ?>' );
						jQuery( '#course_category_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						// Clear Display type field on submit
						jQuery( '#display_type' ).val( '' );
						return;
					}
				} );

			</script>
			<div class="clear"></div>
		</div>
		<?php
	}

	/**
	 * Edit category thumbnail field.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public function edit_category_fields( $term ) {

		$display_type = get_learningonline_term_meta( $term->term_id, 'display_type', true );
		$thumbnail_id = absint( get_learningonline_term_meta( $term->term_id, 'thumbnail_id', true ) );

		if ( $thumbnail_id ) {
			$image = wp_get_attachment_thumb_url( $thumbnail_id );
		} else {
			$image = lp_placeholder_img_src();
		}
		?>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Display type', 'learningonline' ); ?></label></th>
			<td>
				<select id="display_type" name="display_type" class="postform">
					<option value="" <?php selected( '', $display_type ); ?>><?php _e( 'Default', 'learningonline' ); ?></option>
					<option value="courses" <?php selected( 'courses', $display_type ); ?>><?php _e( 'Courses', 'learningonline' ); ?></option>
					<option value="subcategories" <?php selected( 'subcategories', $display_type ); ?>><?php _e( 'Subcategories', 'learningonline' ); ?></option>
					<option value="both" <?php selected( 'both', $display_type ); ?>><?php _e( 'Both', 'learningonline' ); ?></option>
				</select>
			</td>
		</tr>
		<tr class="form-field">
			<th scope="row" valign="top"><label><?php _e( 'Thumbnail', 'learningonline' ); ?></label></th>
			<td>
				<div id="course_category_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="course_category_thumbnail_id" name="course_category_thumbnail_id" value="<?php echo $thumbnail_id; ?>" />
					<button type="button" class="upload_image_button button"><?php _e( 'Upload/Add image', 'learningonline' ); ?></button>
					<button type="button" class="remove_image_button button"><?php _e( 'Remove image', 'learningonline' ); ?></button>
				</div>
				<script type="text/javascript">

					// Only show the "remove image" button when needed
					if ( '0' === jQuery( '#course_category_thumbnail_id' ).val() ) {
						jQuery( '.remove_image_button' ).hide();
					}

					// Uploading files
					var file_frame;

					jQuery( document ).on( 'click', '.upload_image_button', function( event ) {

						event.preventDefault();

						// If the media frame already exists, reopen it.
						if ( file_frame ) {
							file_frame.open();
							return;
						}

						// Create the media frame.
						file_frame = wp.media.frames.downloadable_file = wp.media({
							title: '<?php _e( "Choose an image", "learningonline" ); ?>',
							button: {
								text: '<?php _e( "Use image", "learningonline" ); ?>'
							},
							multiple: false
						});

						// When an image is selected, run a callback.
						file_frame.on( 'select', function() {
							var attachment = file_frame.state().get( 'selection' ).first().toJSON();
							console.log(attachment);
							jQuery( '#course_category_thumbnail_id' ).val( attachment.id );
							jQuery( '#course_category_thumbnail' ).find( 'img' ).attr( 'src', attachment.url );
							jQuery( '.remove_image_button' ).show();
						});

						// Finally, open the modal.
						file_frame.open();
					});

					jQuery( document ).on( 'click', '.remove_image_button', function() {
						jQuery( '#course_category_thumbnail' ).find( 'img' ).attr( 'src', '<?php echo esc_js( lp_placeholder_img_src() ); ?>' );
						jQuery( '#course_category_thumbnail_id' ).val( '' );
						jQuery( '.remove_image_button' ).hide();
						return false;
					});

				</script>
				<div class="clear"></div>
			</td>
		</tr>
		<?php
	}

	/**
	 * save_category_fields function.
	 *
	 * @param mixed $term_id Term ID being saved
	 * @param mixed $tt_id
	 * @param string $taxonomy
	 */
	public function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['display_type'] ) && 'course_category' === $taxonomy ) {
			update_learningonline_term_meta( $term_id, 'display_type', esc_attr( $_POST['display_type'] ) );
		}
		if ( isset( $_POST['course_category_thumbnail_id'] ) && 'course_category' === $taxonomy ) {
			update_learningonline_term_meta( $term_id, 'thumbnail_id', absint( $_POST['course_category_thumbnail_id'] ) );
		}
	}

	/**
	 * Description for course_category page to aid users.
	 */
	public function course_category_description() {
		echo wpautop( __( 'Course categories for your store can be managed here. To change the order of categories on the front-end you can drag and drop to sort them. To see more categories listed click the "screen options" link at the top of the page.', 'learningonline' ) );
	}

	/**
	 * Description for shipping class page to aid users.
	 */
	public function course_attribute_description() {
		echo wpautop( __( 'Attribute terms can be assigned to courses and variations.<br/><br/><b>Note</b>: Deleting a term will remove it from all courses and variations to which it has been assigned. Recreating a term will not automatically assign it back to courses.', 'learningonline' ) );
	}

	/**
	 * Thumbnail column added to category admin.
	 *
	 * @param mixed $columns
	 * @return array
	 */
	public function course_category_columns( $columns ) {
		$new_columns = array();

		if ( isset( $columns['cb'] ) ) {
			$new_columns['cb'] = $columns['cb'];
			unset( $columns['cb'] );
		}

		$new_columns['thumb'] = __( 'Image', 'learningonline' );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * Thumbnail column value added to category admin.
	 *
	 * @param string $columns
	 * @param string $column
	 * @param int $id
	 * @return array
	 */
	public function course_category_column( $columns, $column, $id ) {

		if ( 'thumb' == $column ) {

			$thumbnail_id = get_learningonline_term_meta( $id, 'thumbnail_id', true );

			if ( $thumbnail_id ) {
				$image = wp_get_attachment_thumb_url( $thumbnail_id );
			} else {
				$image = lp_placeholder_img_src();
			}

			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			$columns .= '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Thumbnail', 'learningonline' ) . '" class="wp-post-image" height="48" width="48" />';

		}

		return $columns;
	}

	/**
	 * Maintain term hierarchy when editing a course.
	 *
	 * @param  array $args
	 * @return array
	 */
	public function disable_checked_ontop( $args ) {
		if ( ! empty( $args['taxonomy'] ) && 'course_category' === $args['taxonomy'] ) {
			$args['checked_ontop'] = false;
		}
		return $args;
	}
}

new LP_Admin_Taxonomies();
