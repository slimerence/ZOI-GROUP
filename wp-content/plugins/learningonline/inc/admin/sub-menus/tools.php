<?php
/**
 * Admin view for add-ons page display in admin under menu LearningOnline -> Add ons
 *
 * @author  JwsTheme
 * @package Admin/Views
 * @version 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_action( 'init', 'learning_online_tool_request_actions' );
if ( !function_exists( 'learning_online_tool_request_actions' ) ) {

	function learning_online_tool_request_actions() {
		$action = learning_online_get_request( 'action' );
		if ( !$action ) return;
		if ( current_user_can( 'manage_options' ) ) {
			switch ( $action ) {
				case 'learning-online-remove-data':
					learning_online_remove_data();
					break;
				case 'learning-online-remove-old-data':
					learning_online_remove_old_data();
					break;
				default:
					break;
			}
		} else {
			wp_die( __( 'Sorry, you are nto allowed to access this page.', 'learningonline' ) );
		}
	}

}

if ( !function_exists( 'learning_online_remove_data' ) ) {
	function learning_online_remove_data() {
		global $wpdb;
		$nonce = learning_online_get_request( 'remove-data-nonce' );
		if ( !wp_verify_nonce( $nonce, 'learning-online-remove-data' ) ) {
			return;
		}

		$tables = array(
			'learningonline_sections',
			'learningonline_section_items',
			'learningonline_review_logs',
			'learningonline_quiz_questions',
			'learningonline_question_answers',
			'learningonline_user_courses',
			'learningonline_user_lessons',
			'learningonline_user_quizmeta',
			'learningonline_user_quizzes',
			'learningonline_order_itemmeta',
			'learningonline_order_items'
		);


		# ----------------------------
		# drop all data in our tables
		# ----------------------------
		foreach ( $tables as $table ) {
			$table = $wpdb->prefix . $table;
			if ( $wpdb->get_var( "SHOW TABLES LIKE '{$table}'" ) === $table ) {
				$wpdb->query( "DELETE FROM {$table}" );
			}
		}


		# ----------------------------
		# Get id of learningonline posts
		# ----------------------------
		$query = "
							SELECT p.ID
							FROM {$wpdb->posts} p
							WHERE p.post_type IN ('lp_course', 'lp_lesson', 'lp_quiz', 'lp_question', 'lp_order', 'lp_cert')
						";
		$ids   = $wpdb->get_col( $query );

		// delete all custom post types and meta data
		if ( !empty( $ids ) ) {
			# REMOVE post and post meta
			$q = $wpdb->prepare( "
								DELETE FROM p, pm
								USING {$wpdb->posts} AS p LEFT JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id AND p.post_type IN('lp_course', 'lp_lesson', 'lp_quiz', 'lp_question', 'lp_order', 'lp_cert')
								WHERE %d AND p.ID IN (" . join( ',', $ids ) . ");
						", 1 );
			$wpdb->query( $q );

			$wpdb->query(
				$wpdb->prepare( "
										DELETE FROM {$wpdb->postmeta} WHERE meta_key = %s
								", '_learning_online_upgraded' )
			);
		}

		# REMOVE TERMS
		# 1 REMOVE term_relationships of posts
		$q = "
						DELETE FROM `tr`
							USING {$wpdb->term_relationships} AS `tr` INNER JOIN {$wpdb->term_taxonomy} AS `tt` ON `tr`.`term_taxonomy_id`=`tt`.`term_taxonomy_id`
						WHERE `tt`.`taxonomy` IN ('course_tag', 'course_category')
				";
		$wpdb->query( $q );

		# 2 Remove categories and tags
		$q = "
					DELETE
					FROM tt, t
						USING {$wpdb->term_taxonomy} AS tt
							INNER JOIN
						{$wpdb->terms} AS t ON tt.term_id = t.term_id 
					WHERE
						tt.taxonomy IN('course_category','course_tag')";
		$wpdb->query( $q );

		# END REMOVE TERMS


		# DELETE all options
		$q = $wpdb->prepare( "
						DELETE FROM {$wpdb->options}
						WHERE
								option_name LIKE %s
								OR option_name LIKE %s;
				", '%' . $wpdb->esc_like( 'learning_online' ) . '%', '%' . $wpdb->esc_like( 'learningonline' ) . '%' );
		$wpdb->query( $q );
		delete_option( 'learningonline_db_version' );
		delete_option( 'learningonline_version' );

		LP_Admin_Notice::add( __( 'All courses, lessons, quizzes and questions have been removed', 'learningonline' ), 'updated', '', true );
		wp_redirect( admin_url( 'admin.php?page=learning-online-tools&learning-online-remove-data=1' ) );
		exit();
	}
}

if ( !function_exists( 'learning_online_remove_old_data' ) ) {

	function learning_online_remove_old_data() {
		$nonce = learning_online_get_request( 'remove-old-data-nonce' );
		if ( !wp_verify_nonce( $nonce, 'learning-online-remove-old-data' ) ) {
			return;
		}
		global $wpdb;
		$query = $wpdb->prepare( "SELECT ID FROM {$wpdb->posts} WHERE post_type IN ( %s, %s, %s, %s, %s, %s )", 'lpr_course', 'lpr_lesson', 'lpr_quiz', 'lpr_question', 'lpr_order', 'lpr_certificate' );
		// delete all custom post types and meta data
		if ( $ids = $wpdb->get_col( $query ) ) {
			$object_terms = array();
			foreach ( $ids as $post_id ) {
				// get all terms
				$terms = wp_get_object_terms( $post_id, array( 'course_tag', 'course_category' ) );
				if ( $terms ) {
					foreach ( $terms as $term ) {
						$object_terms[$term->term_id] = $term->term_id;
					}
				}
			}

			$wpdb->query(
				$wpdb->prepare( "
					DELETE FROM p, pm
					USING {$wpdb->posts} AS p INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id AND p.post_type IN('lpr_course', 'lpr_lesson', 'lpr_quiz', 'lpr_question', 'lpr_order', 'lpr_certificate')
					WHERE %d AND p.ID IN (" . join( ',', $ids ) . ")
				", 1 )
			);

			if ( $object_terms ) {
				$deleted_terms = array();
				if ( $object_terms ) {
					foreach ( $object_terms as $term_id => $taxonomy ) {
						wp_delete_term( $term_id, $taxonomy );
						$deleted_terms[$term_id] = $taxonomy;
					}
				}
			}
		}
		// delete all options
		$wpdb->query(
			$wpdb->prepare( "
				DELETE FROM {$wpdb->options}
				WHERE
					option_name LIKE %s
					OR option_name LIKE %s
			", '%' . $wpdb->esc_like( '_lpr_' ) . '%', $wpdb->esc_like( 'lpr_' ) . '%' )
		);

		// delete all user meta
		$wpdb->query(
			$wpdb->prepare( "
				DELETE FROM {$wpdb->usermeta}
				WHERE
					meta_key LIKE %s
					OR meta_key LIKE %s
			", '%' . $wpdb->esc_like( 'lpr_' ) . '%', $wpdb->esc_like( 'lpr_' ) . '%' )
		);

		LP_Admin_Notice::add( __( 'Outdated data from version less than 1.0 have been removed', 'learningonline' ), 'updated', '', true );
		//flush_rewrite_rules();
//            header('Location: '.admin_url( 'admin.php?page=learning-online-tools' ));
		wp_redirect( admin_url( 'admin.php?page=learning-online-tools' ) );
		exit();
	}
}

function learning_online_tools_subtabs() {
	$default_tabs = array(
		'database'  => __( 'Database', 'learningonline' ),
		'templates' => __( 'Templates', 'learningonline' )
	);
	return apply_filters( 'learning_online_tools_subtabs', $default_tabs );
}

function learning_online_tools_page_database() {
	?>
	<!--
	<div class="card">
		<h2><?php _e( 'Repair Database', 'learningonline' ); ?></h2>
		<p><?php _e( 'Remove unused rows from database tables. Be carefully backup your database before doing this action.', 'learningonline' ); ?></p>
		<p class="tools-button">
			<button type="button" class="button"><?php esc_html_e( 'Repair', 'learningonline' ); ?></button>
		</p>
	</div>-->
	<div class="card">
		<h2><?php _e( 'Upgrade Courses', 'learningonline' ); ?></h2>
		<p><?php _e( 'Upgrade courses, lessons, quizzes and questions from version less than 1.0.', 'learningonline' ); ?></p>
		<div class="learning-online-message">
			<p><?php _e( 'Use this action to force system to upgrade outdated data to latest version.', 'learningonline' ); ?></p>
		</div>
		<div class="learning-online-message lp-error">
			<p><?php _e( 'All courses will be upgraded whether you have done this action in the past. So please remove all courses before you upgrade to prevent duplicated courses.', 'learningonline' ); ?></p>
		</div>
		<p class="tools-button">
			<a class="button" href="<?php echo wp_nonce_url( admin_url( 'options-general.php?page=learning_online_upgrade_from_09&force=true' ), 'learning-online-upgrade-09' ); ?>"><?php esc_html_e( 'Upgrade', 'learningonline' ); ?></a>
		</p>
	</div>
	<div class="card">
		<h2><?php _e( 'Remove current Data', 'learningonline' ); ?></h2>
		<p><?php _e( 'Remove all courses, lessons, quizzes and questions', 'learningonline' ); ?></p>
		<form method="post" name="learning-online-form-remove-data">
			<div class="learning-online-message lp-error">
				<p><?php _e( 'Be careful before using this action!', 'learningonline' ); ?></p>
			</div>
			<label class="hide-if-js">
				<input type="checkbox" name="action" value="learning-online-remove-data" />
				<?php _e( 'Check this box and click this button again to confirm.', 'learningonline' ); ?>
			</label>
			<p class="tools-button">
				<button class="button button-fade"><?php esc_html_e( 'Remove', 'learningonline' ); ?></button>
			</p>
			<?php wp_nonce_field( 'learning-online-remove-data', 'remove-data-nonce' ); ?>
		</form>
	</div>
	<div class="card">
		<h2><?php _e( 'Remove outdated Data', 'learningonline' ); ?></h2>
		<p><?php _e( 'Remove all courses, lessons, quizzes and questions from version less than 1.0.', 'learningonline' ); ?></p>
		<form method="post" name="learning-online-form-remove-data">
			<div class="learning-online-message lp-error">
				<p><?php _e( 'Be careful before using this action! Only use this action in case all outdated data has been upgraded.', 'learningonline' ); ?></p>
			</div>
			<label class="hide-if-js">
				<input type="checkbox" name="action" value="learning-online-remove-old-data" />
				<?php _e( 'Check this box and click this button again to confirm.', 'learningonline' ); ?>
			</label>
			<p class="tools-button">
				<button class="button button-fade"><?php esc_html_e( 'Remove', 'learningonline' ); ?></button>
			</p>
			<?php wp_nonce_field( 'learning-online-remove-old-data', 'remove-old-data-nonce' ); ?>

		</form>
	</div>
	<?php
}

/**
 * Sort overrides templates are outdated first
 *
 * @param $a
 * @param $b
 *
 * @return int
 */
function _learning_online_sort_templates( $a, $b ) {
	if ( $a[3] && $b[3] ) {
		return 0;
	}
	if ( $a[3] ) {
		return - 1;
	}
	if ( $b[3] ) {
		return 1;
	}
	return 0;
}

function _learning_online_get_theme_name( $folder ) {
	$theme = wp_get_theme( $folder );
	return !empty( $theme['Name'] ) ? $theme['Name'] : '';
}

function learning_online_tools_page_templates() {
	$templates = learning_online_get_theme_templates();
	$theme     = wp_get_theme();
	usort( $templates, '_learning_online_sort_templates' );

	$template_dir       = get_template_directory();
	$stylesheet_dir     = get_stylesheet_directory();
	$child_theme_folder = '';
	$theme_folder       = '';
	if ( $template_dir != $stylesheet_dir ) {
		$child_theme_folder = basename( $stylesheet_dir );
		$theme_folder       = basename( $template_dir );
	}
	?>
	<table class="lp-template-overrides widefat" cellspacing="0">
		<thead>
		<tr>
			<th colspan="3">
				<h4><?php printf( __( 'Override Templates (%s)', 'learningonline' ), esc_html( $theme['Name'] ) ); ?></h4>
			</th>
		</tr>
		</thead>
		<tbody id="learning-online-template-files">
		<?php if ( $templates ): ?>
			<tr>
				<th>
					<?php _e( 'File', 'learningonline' ); ?>
					<p>
						<a href="" class="learning-online-filter-template current" data-template=""><?php _e( 'All', 'learningonline' ); ?></a>
						<?php if ( $theme_folder && $child_theme_folder ) { ?>
							<a href="" class="learning-online-filter-template" data-template="<?php echo esc_attr( $theme_folder ); ?>"><?php echo _learning_online_get_theme_name( $theme_folder ); ?></a>
							<a href="" class="learning-online-filter-template" data-template="<?php echo esc_attr( $child_theme_folder ); ?>"><?php echo _learning_online_get_theme_name( $child_theme_folder ); ?></a>
						<?php } ?>
						<a href="" class="learning-online-filter-template" data-outdated="yes"><?php _e( 'Outdated', 'learningonline' ); ?></a>
					</p>
				</th>
				<th>
					<?php _e( 'Version', 'learningonline' ); ?>
				</th>
				<th><?php _e( 'Core version', 'learningonline' ); ?></th>
			</tr>
			<?php foreach ( $templates as $template ): ?>
				<?php
				$template_folder = '';
				if ( $child_theme_folder && strpos( $template[0], $child_theme_folder ) !== false ) {
					$template_folder = $child_theme_folder;
				} else {
					$template_folder = $theme_folder;
				}
				?>

				<tr data-template="<?php echo esc_attr( $template_folder ); ?>" <?php if ( $template[3] ) {
					echo 'data-outdated="yes"';
				} ?> class="template-row">
					<td class="lp-template-file"><code><?php echo $template[0]; ?></code></td>
					<td class="lp-template-version<?php echo $template[3] ? ' outdated' : ( $template[1] == '-' && $template[2] == '-' ? '' : ' up-to-date' ); ?>">
						<span><?php echo $template[1]; ?></span>
					</td>
					<td class="lp-core-version"><span><?php echo $template[2]; ?></span></td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
		<tr id="learning-online-no-templates" class="<?php echo $templates ? 'hide-if-js' : ''; ?>">
			<td colspan="3">
				<p><?php _e( 'There is no template file has overwritten', 'learningonline' ); ?></p>
			</td>
		</tr>
		</tbody>
	</table>
	<script type="text/javascript">
		jQuery(function ($) {
			$(document).on('click', '.learning-online-filter-template', function () {
				var $link = $(this),
					template = $link.data('template'),
					outdated = $link.data('outdated');
				if ($link.hasClass('current')) {
					return;
				}
				$link.addClass('current').siblings('a').removeClass('current');
				if (!template) {
					if (!outdated) {
						$('#learning-online-template-files tr[data-template]').removeClass('hide-if-js');
					} else {
						$('#learning-online-template-files tr[data-template]').map(function () {
							$(this).toggleClass('hide-if-js', $(this).data('outdated') != outdated);
						})
					}
				} else {
					$('#learning-online-template-files tr[data-template]').map(function () {
						$(this).toggleClass('hide-if-js', $(this).data('template') != template);
					})
				}
				$('#learning-online-no-templates').toggleClass('hide-if-js', !!$('#learning-online-template-files tr.template-row:not(.hide-if-js):first').length)
				return false;
			})
		})
	</script>
	<?php
}


/**
 * Add-on page
 */
function learning_online_tools_page() {
	$subtabs = learning_online_tools_subtabs();
	$subtab  = !empty( $_REQUEST['tab'] ) ? $_REQUEST['tab'] : '';
	if ( !$subtab ) {
		$tab_keys = array_keys( $subtabs );
		$subtab   = reset( $tab_keys );
	}
	?>
	<div id="learning-online-tools-wrap" class="wrap">
		<!-- <h2><?php echo __( 'LearningOnline Tools', 'learningonline' ); ?></h2>-->
		<h2 class="nav-tab-wrapper">
			<?php foreach ( $subtabs as $slug => $title ): ?>
				<?php
				// If title is an array, the first arg is title
				if ( is_array( $title ) ) {
					$title = $title[0];
				}
				?>
				<a class="nav-tab<?php echo $slug == $subtab ? ' nav-tab-active' : ''; ?>" href="?page=learning-online-tools&tab=<?php echo $slug; ?>"><?php echo $title; ?></a>
			<?php endforeach; ?>
		</h2>
		<?php
		if ( is_callable( 'learning_online_tools_page_' . $subtab ) ) {
			call_user_func( 'learning_online_tools_page_' . $subtab, $subtab, $subtabs[$subtab] );
		} else {
			do_action( 'learning_online_tools_page_' . $subtab, $subtab, $subtabs[$subtab] );
		}
		?>
	</div>
	<script type="text/javascript">
		jQuery(function ($) {
			$('form[name="learning-online-form-remove-data"]').on('submit', function () {
				var $form = $(this),
					$check = $form.find('input[name="action"]');
				if (!$form.find('input[name="action"]').is(':checked')) {
					$check.parent().removeClass('hide-if-js');
					return false;
				}
			});


		})
	</script>
	<?php
}
