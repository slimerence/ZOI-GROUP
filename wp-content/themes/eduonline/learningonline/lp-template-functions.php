<?php 


add_filter('learning_online_get_courses','lp_course', $args['posts_per_page'] = 2);

function jws_theme_get_op_full_wid(){
	if( isset( $_GET['layout'] ) && $_GET['layout']=='fullwidth' ) return true;
	global $jws_theme_options;
	$t_id = get_queried_object_id();
	$term_meta = get_option( "taxonomy_$t_id" );
	if( isset(  $term_meta['jws_theme_full_width'] ) )
		return $term_meta['jws_theme_full_width'];
	elseif( $jws_theme_options['jws_theme_archive_sidebar_pos_course'] == 'tb-sidebar-hidden' )
		return true;
}

if ( ! function_exists( 'jws_theme_course_sharing' ) ) {

	function jws_theme_course_sharing() {
		$course = LP()->global['course'];
		//$permalink = $course->post->guid;
		//$title = $course->post->post_title;
		
		$content = '<!-- Go to www.addthis.com/dashboard to customize your tools -->
			<div class="addthis_toolbox">
				<span class="tb-title-socials">'. esc_html__('SHARE: ','eduonline') .'</span>
				<div class="custom_images">
					<a class="addthis_button_facebook"><i class="fa fa-facebook"></i></a>
					<a class="addthis_button_twitter"><i class="fa fa-twitter"></i></a>
					<a class="addthis_button_googleplus"><i class="fa fa-google-plus"></i></a>
					<a class="addthis_button_pinterest_share"><i class="fa fa-pinterest"></i></a>
				</div>
			</div>';

		echo wp_kses_post($content);
	}
}

// relative post

add_filter( 'jws_theme_output_related_courses', 'jws_theme_course_related' );

if ( ! function_exists( 'jws_theme_course_related' ) ) {

	function jws_theme_course_related() {
		global $post;

		$custom_taxterms = wp_get_object_terms( $post->ID, 'course_category', array('fields' => 'ids') );
		
		$args = array(
			'post_type' => 'lp_course',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'rand',
			'tax_query' => array(
				array(
					'taxonomy' => 'course_category',
					'field' => 'id',
					'terms' => $custom_taxterms
				)
			),
			'post__not_in' => array ($post->ID),
		);
		$related_items = new WP_Query( $args );
		// loop over query
		if ($related_items->have_posts()) : ?>
			<div class="tb-course-related">
				<div class="tb-heading">
					<h3><?php echo esc_html__('Related Courses', 'eduonline'); ?></h3>
				</div>
				<div class="tb-blog-carousel tb-blog-carousel4">
					<div class="owl-carousel course-same-height">
						
						<?php while ( $related_items->have_posts() ) : $related_items->the_post(); ?>
							<div class="tb-course-item">
								<?php learning_online_get_template('loop/course/loop-course-item.php'); ?>
							</div>
						<?php endwhile; wp_reset_postdata(); ?>
				
					</div>
				</div>
			</div>
		<?php
		endif;


	}
}

// custom course tabs

if ( !function_exists( 'learning_online_custom_course_tabs' ) ) {
	/*
	 * Output course tabs
	 */

	function learning_online_custom_course_tabs() {
		learning_online_get_template( 'single-course/tabs/tabs.php' );
	}
}

if ( !function_exists( '_learning_online_custom_course_tabs' ) ) {

	/**
	 * Add default tabs to course
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	function _learning_online_custom_course_tabs( $tabs = array() ) {

		$course = LP()->global['course'];

		$user   = learning_online_get_current_user();

		$defaults = array();
		
		// Description tab - shows product content
		if ( $course->post->post_content ) {
			$defaults['overview'] = array(
				'title'    => __( 'Course information', 'eduonline' ),
				'priority' => 10,
				'callback' => 'learning_online_course_overview_tab'
			);
		}

		/*// Curriculum
		$defaults['curriculum'] = array(
			'title'    => __( 'Lessons', 'eduonline' ),
			'priority' => 30,
			'callback' => 'learning_online_course_curriculum_tab'
		);
		// Reviews
		
		$defaults['reviews'] = array(
			'title'    => __( 'Reviews', 'eduonline' ),
			'priority' => 50,
			'callback' => 'learning_online_course_reviews_tab'
		); 
		
		// Trailer
		
		$defaults['trailer'] = array(
			'title'    => __( 'Trailer', 'eduonline' ),
			'priority' => 50,
			'callback' => 'learning_online_course_trailer_tab'
		); 
		*/

        $defaults['work'] = array(
            'title'    => __( 'Work Placement Program', 'eduonline' ),
            'priority' => 20,
            'callback' => 'learning_online_course_work_tab'
        );

        $defaults['path'] = array(
            'title'    => __( 'Pathways', 'eduonline' ),
            'priority' => 30,
            'callback' => 'learning_online_course_path_tab'
        );

        $defaults['fee'] = array(
            'title'    => __( 'Course Fees', 'eduonline' ),
            'priority' => 40,
            'callback' => 'learning_online_course_fee_tab'
        );

        $defaults['stats'] = array(
            'title'    => __( 'Industry Stats', 'eduonline' ),
            'priority' => 50,
            'callback' => 'learning_online_course_stats_tab'
        );

        /**
		 * Active Curriculum tab if user has enrolled course
		 */
		if ( $user->has_course_status( $course->id, array( 'enrolled' ) ) ) {
			$defaults['curriculum']['active'] = true;
		}

		$tabs = array_merge( $tabs, $defaults );

		return $tabs;
	}
}

if ( !function_exists( 'learning_online_course_reviews_tab' ) ) {
	/**
	 * Output course curriculum
	 *
	 * @since 1.1
	 */
	function learning_online_course_reviews_tab() {
		learning_online_get_template( 'single-course/tabs/reviews.php' );
	}
}


if ( !function_exists( 'learning_online_course_trailer_tab' ) ) {
	/**
	 * Output course curriculum
	 *
	 * @since 1.1
	 */
	function learning_online_course_trailer_tab() {
		learning_online_get_template( 'single-course/tabs/trailer.php' );
	}
}

if ( !function_exists( 'learning_online_course_work_tab' ) ) {
    /**
     * Output course curriculum
     *
     * @since 1.1
     */
    function learning_online_course_work_tab() {
        learning_online_get_template( 'single-course/tabs/work.php' );
    }
}
if ( !function_exists( 'learning_online_course_path_tab' ) ) {
    /**
     * Output course curriculum
     *
     * @since 1.1
     */
    function learning_online_course_path_tab() {
        learning_online_get_template( 'single-course/tabs/path.php' );
    }
}

if ( !function_exists( 'learning_online_course_fee_tab' ) ) {
    /**
     * Output course curriculum
     *
     * @since 1.1
     */
    function learning_online_course_fee_tab() {
        learning_online_get_template( 'single-course/tabs/fee.php' );
    }
}

if ( !function_exists( 'learning_online_course_stats_tab' ) ) {
    /**
     * Output course curriculum
     *
     * @since 1.1
     */
    function learning_online_course_stats_tab() {
        learning_online_get_template( 'single-course/tabs/stats.php' );
    }
}

function jws_theme_sort_by_page($count) {
	global $jws_theme_options;

 $count = 9;
 if (isset($_GET['jws_theme_sortby'])) {
  $count = $_GET['jws_theme_sortby'];
 }else{
 	$count  = LP()->settings->get( 'profile_courses_limit', 10 );
 }
 // else normal page load and no cookie
 return $count;
}
//add_filter('learning_online_get_courses','jws_theme_sort_by_page', 15);



if ( !function_exists( 'course_page_title' ) ) {

	/**
	 * course_page_title function.
	 *
	 * @param  boolean $echo
	 *
	 * @return string
	 */
	function course_page_title( $echo = true ) {

		if ( is_search() ) {
			$page_title = sprintf( __( 'Search Results: &ldquo;%s&rdquo;', 'eduonline' ), get_search_query() );

			if ( get_query_var( 'paged' ) )
				$page_title .= sprintf( __( '&nbsp;&ndash; Page %s', 'eduonline' ), get_query_var( 'paged' ) );

		} elseif ( is_tax() ) {
			$page_title = single_term_title( "", false );

		} else {
			if(is_single()){
				$page_title = the_title();
			}
			else{
				$courses_page_id = learning_online_get_page_id( 'courses' );
				//var_dump($courses_page_id);
				$page_title      = get_the_title( $courses_page_id );
				//var_dump($page_title);
			}
		}

		$page_title = apply_filters( 'learning_online_page_title', $page_title );

		if ( $echo )
			echo $page_title;
		else
			return $page_title;
	}
}