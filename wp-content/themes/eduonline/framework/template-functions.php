<?php

if ( ! isset( $content_width ) ) $content_width = 900;
if ( is_singular() ) wp_enqueue_script( "comment-reply" );
if ( ! function_exists( 'jws_theme_theme_setup' ) ) {
	function jws_theme_theme_setup() {
		load_theme_textdomain( 'eduonline', get_template_directory() . '/languages' );
		// Add Custom Header.
		add_theme_support('custom-header');
		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );

		 
		 
		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'main_navigation'   => esc_html__( 'Primary Menu','eduonline' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery','status'
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'tbtheme_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'tbtheme_get_featured_posts',
			'max_posts' => 6,
		) );
		
		add_theme_support( "title-tag" );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		// Register a new image size
		add_image_size( 'eduonline-course-medium', 270, 237, true );
		add_image_size( 'eduonline-course-overlay', 296, 220, true );
		add_image_size( 'eduonline-blog-medium', 370, 195, true );
		add_image_size( 'eduonline-course-related', 370, 250, true );
		add_image_size( 'eduonline-testimonial-widget', 65, 65, true );
		
		add_image_size( 'portfolio-big-thumb', 570, 570, true );
		add_image_size( 'portfolio-vertical-thumb', 570, 420, true );
		add_image_size( 'portfolio-normal-thumb', 270, 270, true );
		
		add_image_size( 'portfolio-single-thumb', 770, 570, true );
		
		add_image_size( 'event-listing-thumb', 270, 200, true );
		add_image_size( 'event-single-thumb', 470, 350, true );
		
		if ( class_exists( 'LearningOnline' ) ) {
			$sizes = apply_filters( 'learning_online_image_sizes', array( 'single_course', 'course_thumbnail' ) );
			foreach ( $sizes as $image_size ) {
				$size_name = 'lp_'.$image_size;
				$size           = LP()->settings->get( $image_size . '_image_size', array() );
				$size['width']  = isset( $size['width'] ) ? $size['width'] : '300';
				$size['height'] = isset( $size['height'] ) ? $size['height'] : '300';
				
				add_image_size( $size_name, $size['width'], $size['height'], true);
			}
		}
	}
}
add_action( 'after_setup_theme', 'jws_theme_theme_setup' );
add_filter( 'post-format-status', 'jws_theme_avia_status_content_filter', 10, 1 );

function jws_theme_page_title(){
	global $jws_theme_options;
	
	$class = array();
	$class[] = 'title-bar';
	
	return jws_theme_get_content_title_bar($class);
}

function jws_theme_post_cate(){
	$taxonomy = 'category';
	$terms = get_the_terms( get_the_ID(), $taxonomy );
	$on_draught ="";		 
	if ( $terms && ! is_wp_error( $terms ) ) : 
	 
		$cate_item = array();
		foreach ( $terms as $term ) {
			$cate_item[] = sprintf(wp_kses_post(__('<a href="%1$s">%2$s</a>'),'eduonline'), esc_url( get_term_link( $term->slug, $taxonomy ) ), esc_html( $term->name )) ;
		}
							 
		$on_draught = join( "/ ", $cate_item );
		//echo join( ", ", $cate_item );
	endif;
	return $on_draught;
}

function jws_theme_get_template_popup($url){
	
	$template = '<div class="tb-overlay-bg"><div class="tb-overlay-container"><div class="tb-overlay-content content-lightbox"><div class="portfolio-lightbox"><img class="img-responsive" src="'.$url.'"><button title="Close (Esc)" type="button" class="tb-close"><i class="fa fa-times"></i></button></div></div></div></div>';
	return $template;
}
function jws_theme_get_content_title_bar($class, $outside=true){
	global $jws_theme_options;
	$header_layout = $jws_theme_options['jws_theme_header_layout'];
	$show_on_front = is_front_page() ? false : true;
	$active_page_title = (is_page()) ? jws_theme_get_object_id( 'jws_theme_page_title_bar' ) : 1;
	if( $active_page_title ) :
		if( $jws_theme_options['jws_theme_display_page_title'] ):
	?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-8 col-lg-7">
						<h3 class="page-title"><?php echo jws_theme_getPageTitle(); ?></h3>
					</div>
					<div class="col-sm-12 col-md-4 col-lg-5">
						<?php
							// include breadcrumb
							if( $show_on_front) jws_theme_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</div>
	<?php
		endif;
	endif;
	
}

function jws_theme_get_breadcrumb(){
	global $jws_theme_options;
	ob_start();
	if( $jws_theme_options['jws_theme_display_breadcrumb'] ):
			$delimiter = isset($jws_theme_options['jws_theme_page_breadcrumb_delimiter']) ? $jws_theme_options['jws_theme_page_breadcrumb_delimiter'] :  '/';
		?>
		<!-- Breadcumb -->
		<div class="tb-breadcrumb">
			<?php  echo jws_theme_page_breadcrumb( $delimiter ); ?>
		</div>
	<?php endif;

	echo ob_get_clean();
}

function jws_theme_get_search_mega( $class ){
	?>
		<div class="jws_theme_top_search_bar <?php echo esc_attr($class);?>">
			<?php dynamic_sidebar("tbtheme-top-search-bar"); ?>
		</div>
	<?php
}

function jws_theme_getPageTitle(){
	ob_start();
	if(get_post_type() == 'lp_course' || get_post_type() == 'lp_quiz' || jws_check_is_course() || jws_check_is_course_taxonomy()){
		$course_cat = get_the_terms( get_the_ID(), 'course_category' );
		
		if ( is_single() ) {
			the_title();
			
		}  else {
			//echo jws_course_page_title( false );
			$courses_page_id = learning_online_get_page_id( 'courses' );
			$page_title      = get_the_title( $courses_page_id );
			echo $page_title;
		}
	}else{
	if( is_home() ){
		_e('Home', 'eduonline');
	}elseif(is_search()){
		esc_html_e('Search Keyword: ', 'eduonline');
		echo '<span class="keywork">'. get_search_query(). '</span>';
	}
	elseif (!is_archive()) {
		the_title();
	} else { 
		if (is_category()){
			single_cat_title();
		}elseif(get_post_type() == 'recipe' || get_post_type() == 'portfolio' || get_post_type() == 'produce' || get_post_type() == 'team' || get_post_type() == 'testimonial' || get_post_type() == 'myclients' || get_post_type() == 'product'){
			single_term_title();
		}elseif (is_tag()){
			single_tag_title();
		}elseif (is_author()){
			printf(__('Author: %s', 'eduonline'), '<span class="vcard">' . get_the_author() . '</span>');
		}elseif (is_day()){
			printf(__('Day: %s', 'eduonline'), '<span>' . get_the_date() . '</span>');
		}elseif (is_month()){
			printf(__('Month: %s', 'eduonline'), '<span>' . get_the_date(_e('F Y', 'eduonline')) . '</span>');
		}elseif (is_year()){
			printf(__('Year: %s', 'eduonline'), '<span>' . get_the_date(_e('Y', 'eduonline')) . '</span>');
		}elseif (is_tax('post_format', 'post-format-aside')){
			esc_html_e('Asides', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-gallery')){
			esc_html_e('Galleries', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-image')){
			esc_html_e('Images', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-video')){
			esc_html_e('Videos', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-quote')){
			esc_html_e('Quotes', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-link')){
			esc_html_e('Links', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-status')){
			esc_html_e('Statuses', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-audio')){
			esc_html_e('Audios', 'eduonline');
		}elseif (is_tax('post_format', 'post-format-chat')){
			esc_html_e('Chats', 'eduonline');
		}else{
			esc_html_e('Archives', 'eduonline');
		}
	}
	}
	return ob_get_clean();

}

/**
 * Page title for course
 */
if ( !function_exists( 'jws_course_page_title' ) ) {
	function jws_course_page_title( $echo = true ) {
		$title = '';
		if ( get_post_type() == 'lp_course' ) {
			if ( is_tax() ) {
				$title = single_term_title( '', false );
			} else {
				$title = esc_html__( 'All Courses', 'eduonline' );
			}
		}
		if ( get_post_type() == 'lp_quiz' ) {
			if ( is_tax() ) {
				$title = single_term_title( '', false );
			} else {
				$title = esc_html__( 'Quiz', 'eduonline' );
			}
		}
		if( $echo ) {
			echo $title;
		}else{
			return $title;
		}
	}
}

/* Header */
function jws_theme_header() {
	global $jws_theme_options;
	// $header_layout = $jws_theme_options["jws_theme_header_layout"];
	$header_layout = jws_theme_get_object_id('jws_theme_header_layout', true);
	$jws_theme_options['jws_theme_header_layout'] = $header_layout;
	switch ($header_layout) {
		case 'v1':
			get_template_part('framework/headers/header', 'v1');
			break;
		case 'v2':
			get_template_part('framework/headers/header', 'v2');
			break;
		default :
			get_template_part('framework/headers/header', 'v1');
			break;
	}
}


/* Main Logo */
if (!function_exists('jws_theme_theme_logo')) {
	function jws_theme_theme_logo( $logo='' ) {
		global $jws_theme_options,$post;
		$postid = isset($post->ID) ? $post->ID : 0;
		if( isset($jws_theme_options['jws_theme_logo_image']['url']) && ! empty( $jws_theme_options['jws_theme_logo_image']['url']) ){
			$logo = empty( $logo ) ? $jws_theme_options['jws_theme_logo_image']['url'] : $logo;
			$logo = get_post_meta($postid, 'jws_theme_custom_logo', true) ? get_post_meta($postid, 'jws_theme_custom_logo', true) : $logo;
			$logo = '<img src="'.esc_url($logo).'" class="main-logo" alt="' . __('Main Logo', 'eduonline') .  '"/>';
		}else{
			$logo = isset( $jws_theme_options['jws_theme_logo_text'] ) ? strip_tags( $jws_theme_options['jws_theme_logo_text'],'<span><br><em><strong>' ) : wp_kses( __('eduonline','eduonline'), array(
				'br' => array(),
			    'em' => array(),
			    'strong' => array(),
			    'span' => array()
			   )
			);
		}
		echo $logo;
	}
}

/* Page breadcrumb */
if (!function_exists('jws_theme_page_breadcrumb')) {
    function jws_theme_page_breadcrumb($delimiter) {
            ob_start();
			$delimiter = esc_attr($delimiter);
			
            $home = esc_html__('Home', 'eduonline');
            $before = '<span class="current">'; // tag before the current crumb
            $after = '</span>'; // tag after the current crumb

            global $post;
            $homeLink = home_url('/');
			if( is_home() ){
				_e('Home', 'eduonline');
			}else{
				echo '<a href="' . esc_url($homeLink) . '">' . $home . '</a> ' . $delimiter . ' ';
			}

            if ( is_category() ) {
                $thisCat = get_category(get_query_var('cat'), false);
                if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
                echo wp_kses_post($before . esc_html__('Archive by category: ', 'eduonline') . single_cat_title('', false) . $after);

            } elseif ( is_search() ) {
                echo wp_kses_post($before . esc_html__('Search results for: ', 'eduonline') . get_search_query() . $after);

            } elseif ( is_day() ) {
                echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F').' '. get_the_time('Y') . '</a> ' . $delimiter . ' ';
                echo wp_kses_post($before . get_the_time('d') . $after);

            } elseif ( is_month() ) {
                echo wp_kses_post($before . get_the_time('F'). ' '. get_the_time('Y') . $after);

            } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                if(get_post_type() == 'portfolio'){
                    $terms = get_the_terms(get_the_ID(), 'portfolio_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'portfolio_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'recipe'){
                    $terms = get_the_terms(get_the_ID(), 'recipe_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'recipe_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'produce'){
                    $terms = get_the_terms(get_the_ID(), 'produce_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'produce_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'team'){
                    $terms = get_the_terms(get_the_ID(), 'team_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'team_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'testimonial'){
                    $terms = get_the_terms(get_the_ID(), 'testimonial_category', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'testimonial_category', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'myclients'){
                    $terms = get_the_terms(get_the_ID(), 'clientscategory', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'clientscategory', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }elseif(get_post_type() == 'product'){
                    $terms = get_the_terms(get_the_ID(), 'product_cat', '' , '' );
                    if($terms) {
                        the_terms(get_the_ID(), 'product_cat', '' , ', ' );
                        echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                    }else{
                        echo wp_kses_post($before . get_the_title() . $after);
                    }
                }else{
                    $post_type = get_post_type_object(get_post_type());
                    $slug = $post_type->rewrite;
                    echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }

            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo wp_kses_post($cats);
                echo wp_kses_post($before . get_the_title() . $after);
            }

            } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                $post_type = get_post_type_object(get_post_type());
				if($post_type) echo wp_kses_post($before . $post_type->labels->singular_name . $after);
            } elseif ( is_attachment() ) {
                $parent = get_post($post->post_parent);
                $cat = get_the_category($parent->ID); $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
                echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            } elseif ( is_page() && !$post->post_parent ) {
                echo wp_kses_post($before . get_the_title() . $after);

            } elseif ( is_page() && $post->post_parent ) {
                $parent_id  = $post->post_parent;
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo wp_kses_post($breadcrumbs[$i]);
                    if ($i != count($breadcrumbs) - 1)
                        echo ' ' . $delimiter . ' ';
                }
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

            } elseif ( is_tag() ) {
                echo wp_kses_post($before . esc_html__( 'Posts tagged: ', 'eduonline' ) . single_tag_title('', false) . $after);
            } elseif ( is_author() ) {
                global $author;
                $userdata = get_userdata($author);
                echo wp_kses_post( $before . esc_html__( 'Articles posted by ', 'eduonline' ) . $userdata->display_name . $after );
            } elseif ( is_404() ) {
                echo wp_kses_post($before . esc_html__( 'Error 404', 'eduonline' ) . $after);
            }

            if ( get_query_var('paged') ) {
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                    echo ' '.$delimiter.' '.__('Page', 'eduonline') . ' ' . get_query_var('paged');
                if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
            }
                
            return ob_get_clean();
    }
}

/* Custom excerpt */
function jws_theme_custom_excerpt($limit, $more) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt) >= $limit) {
        array_pop($excerpt);
        $excerpt = implode(" ", $excerpt) . esc_attr( $more );
    } else {
        $excerpt = implode(" ", $excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`', '', $excerpt);
    return $excerpt;
}

/* Custom excerpt */
function jws_theme_custom_content($limit,$more) {
	
	$trimContent = get_the_content();
	$shortContent = wp_trim_words( $trimContent, $limit, $more);
	echo do_shortcode($shortContent); 
	
}
/* Display navigation to next/previous set of posts */
if ( ! function_exists( 'jws_theme_theme_paging_nav' ) ) {
	function jws_theme_theme_paging_nav() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'eduonline' ),
				'next_text' => __( '<i class="fa fa-angle-right"></i>', 'eduonline' ),
		) );

		if ( $links ) {
		?>
		<div class="col-xs-12">
			<nav class="pagination text-center" role="navigation">
				<?php echo wp_kses_post($links); ?>
			</nav>
		</div>
		<?php
		}
	}
}
/* Display navigation to next/previous post */
if ( ! function_exists( 'jws_theme_theme_post_nav' ) ) {
	function jws_theme_theme_post_nav() {
		$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
		$next     = get_adjacent_post( false, '', false );
		if ( ! $next && ! $previous ) {
			return;
		}
		?>
		<nav class="navigation post-navigation clearfix" role="navigation">
			<div class="nav-links">
				<?php
					$previous = get_previous_post_link( '<div class="nav-previous pull-left">%link</div>', wp_kses( __( '<span class="btn text-left btn-default"><i class="fa fa-caret-left"></i>&nbsp; Previous</span>', 'eduonline' ),array( 'span' => array( 'class' => array() ), 'i' => array( 'class' => array() ))) );
					$next = get_next_post_link(     '<div class="nav-next pull-right">%link</div>',     wp_kses( __( '<span class="text-right btn btn-default">Next &nbsp;<i class="fa fa-caret-right"></i></span>', 'eduonline' ),array( 'span' => array( 'class' => array() ), 'i' => array( 'class' => array() ))) );
					if( $previous ){
						echo $previous;
					}else{
						?>
						<div class="nav-previous pull-left"><a href="#previous" rel="prev"><span class="btn btn-default disabled text-left"><i class="fa fa-caret-left"></i>&nbsp; Previous</span></a></div>
						<?php
					}
					if( $next ){
						echo $next;
					}else{
						?>
						<div class="nav-next pull-right"><a href="#next" rel="next"><span class="btn btn-default disabled text-right">Next &nbsp;<i class="fa fa-caret-right"></i></span></a></div>
						<?php
					}
				?>
			</div>
		</nav>
		<?php
	}
}
/* Title Bar */
if ( ! function_exists( 'jws_theme_theme_title_bar' ) ) {
	function jws_theme_theme_title_bar($jws_theme_show_page_title, $jws_theme_show_page_breadcrumb) {
		global $jws_theme_options;
		$class = array();
		$class[] = 'title-bar';
		
		if($jws_theme_show_page_title || $jws_theme_show_page_breadcrumb){ 
			jws_theme_get_content_title_bar( $class );
		}
	}
}
/*Custom comment list*/
function jws_theme_custom_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo wp_kses_post($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'div' != $args['style'] ) : ?>
			<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
		<?php endif; ?>
			<div class="comment-avatar">
				<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="comment-info">
				
				<div class="comment-header-info">
					<div class="comment-author vcard">
						<?php printf( esc_html__( '%s','eduonline' ), get_comment_author_link() ); ?>
					</div>
					<div class="comment-date">
						<a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">
							<?php
							/* translators: 1: date, 2: time */
							printf( esc_html__('%1$s %2$s','eduonline'), get_comment_date('M, d, Y'),  get_comment_time('g:i A') ); ?>
						</a>
					</div>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'eduonline' ); ?></em>
					<br />
				<?php endif; ?>

				<?php comment_text(); ?>
				
			</div>
			
	<?php if ( 'div' != $args['style'] ) : ?>
		</div>
	<?php endif; ?>
<?php
}

function jws_theme_addURLParameter($url, $paramName, $paramValue) {
	 $url_data = parse_url($url);
	 if(!isset($url_data["query"]))
		 $url_data["query"]="";

	 $params = array();
	 parse_str($url_data['query'], $params);
	 $params[$paramName] = $paramValue;

	 if( $paramName == 'product_count' ) {
	 	$params['paged'] = '1';
	 }

	 $url_data['query'] = http_build_query($params);
	 return jws_theme_build_url($url_data);
}


function jws_theme_build_url($url_data) {
	 $url="";
	 if(isset($url_data['host']))
	 {
		 $url .= $url_data['scheme'] . '://';
		 if (isset($url_data['user'])) {
			 $url .= $url_data['user'];
				 if (isset($url_data['pass'])) {
					 $url .= ':' . $url_data['pass'];
				 }
			 $url .= '@';
		 }
		 $url .= $url_data['host'];
		 if (isset($url_data['port'])) {
			 $url .= ':' . $url_data['port'];
		 }
	 }
	 if (isset($url_data['path'])) {
	 	$url .= $url_data['path'];
	 }
	 if (isset($url_data['query'])) {
		 $url .= '?' . $url_data['query'];
	 }
	 if (isset($url_data['fragment'])) {
		 $url .= '#' . $url_data['fragment'];
	 }
	 return $url;
}

// Hooks add play btn for editor
add_action('admin_init', 'jws_theme_add_button_play');
function jws_theme_add_button_play() {
	add_filter('mce_external_plugins', 'jws_theme_add_plugin_play');
	add_filter('mce_buttons', 'jws_theme_register_button_play');
}
function jws_theme_register_button_play($buttons) {
	   array_push($buttons, "btnplay");
	   return $buttons;
}
function jws_theme_add_plugin_play($plugin_array) {
   $plugin_array['btnplay'] = JWS_THEME_URI_PATH .'/assets/js/mce.btn.play.js';
   return $plugin_array;
}



function jws_theme_get_page_id( $id, $global ){
	global $jws_theme_options;
	if( is_archive() || is_search() || is_single() ){
		if( isset( $jws_theme_options[ $id ] ) ){
			return $jws_theme_options[ $id ];
		}else{
			$post_id = get_option('page_on_front');
		}
	}else{
		$post_id = get_queried_object_id();
	}

	$result = get_post_meta( $post_id , $id, true );

	if( $global && ($result=='global'||$result=='') && isset( $jws_theme_options[ $id ] ) ){
		return $jws_theme_options[ $id ];
	}
	return $result;
}

function jws_theme_get_object_id( $id, $global=false ){
	if( function_exists('is_woocommerce') && is_woocommerce() )
		return jws_theme_get_shop_id( $id, $global );
	else
		return jws_theme_get_page_id( $id, $global );
}

function jws_theme_get_sep_title( $title, $separated=',' ){
	$title = explode( $separated, $title );
	$title = array_map(function($v){
		if( !empty($v) ){
			return $v;
		}
	}, $title);
	return $title;
}

function jws_theme_custom_cat_thumbnail($thumb){
	$thumb = 'eduonline-thumb-cat-large';
	return $thumb;
}

add_filter('body_class', 'jws_theme_body_classes');

function jws_theme_body_classes($classes) {
	global $jws_theme_options;
	$classes[] = $jws_theme_options['jws_theme_body_layout'];
    return $classes;
}
function fetchData($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch); 
  return $result;
}
function jws_theme_get_image_width( $size ) {
	global $_wp_additional_image_sizes;

	if ( in_array( $size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
		return get_option( "{$size}_size_w" );
	} elseif ( isset( $_wp_additional_image_sizes[ $size ] ) ) {
		return $_wp_additional_image_sizes[ $size ]['width'];
	}

	return false;
}


add_action( 'wp_ajax_jws_theme_load_filter_course', 'jws_theme_load_filter_course' );
add_action( 'wp_ajax_nopriv_jws_theme_load_filter_course', 'jws_theme_load_filter_course' );

function jws_theme_load_filter_course(){
	global $wpdb, $pagenow;
	$data = (array)$_POST['data'];
	if( empty( $data['args']) || empty( $data['atts']) ) return;
	$query_args = (array)$data['args'];

	if( empty( $query_args['paged'] ) ) return;

	$atts =  wp_parse_args( (array)$data['atts'], array(
		'post_type' => 'post',
        'posts_per_page' => -1,
        'category' => '',
		'style' => 'blog',
        'course_style' => 'entry',
        'course_category' => '',
		'columns' =>  4,
		'tab_active' =>  1,
        'show_title' => 0,
        'show_excerpt' => 1,
        'excerpt_length' => 25,
        'excerpt_more' => '...',
        'show_date' => 0,
        'show_cate' => 0,
        'orderby' => 'none',
        'order' => 'none',
        'el_class' => ''

    ) );
	switch ($post_type) {
        case 'post':
            $category = $category;
            $taxonomy = 'category';
            $style = $style;
            break;
        case 'lp_course':
            $category = $course_category;
            $taxonomy = 'course_category';
			$style = $course_style;
            break;
    }
	if( $_GET['degree'] && isset( $data['degree'] ) ){
		$degree = trim( $_GET['degree'] );
		
		$meta_query[] = array(
				'key' => '_lp_degree',
				'value' => $degree,
				'compare' => '='
			);
	}
    if( isset( $data['cat'] ) && $data['cat'] ){
    	 $query_args['tax_query'] = array(
            array(
                    'taxonomy'      => 'course_category',
                    'terms'         => $data['cat'],
                    'field'         => 'id',
                    'operator'      => 'IN'
            )
        );
    }

	extract( $atts );


	$wpp = new WP_Query( $query_args );
	ob_start();	
	//var_dump($query_args);
	?>
	<div class="owl-carousel course-same-height"><?php
	if ($wpp->have_posts() ) {
		while ($wpp->have_posts() ) {$wpp->the_post();
           include JWS_THEME_ABS_PATH_FR .'/shortcodes/blog_carousel/'.$post_type.'/entry.php';
		}wp_reset_postdata();
    }
	?>
	</div><?php
    $response['content'] = ob_get_clean();
    echo json_encode( $response );
	wp_die();
}

function search_course($query) {

	  if ( is_search()) {
		  
		if ($query->is_search) {
			
			$meta_query = $query->get( 'meta_query' );
			$tax_query = $query->get( 'tax_query' );
			
			if( isset( $data['degree']) && $_GET['degree']  ){
				$degree = trim( $_GET['degree'] );
				
				$meta_query[] = array(
						'key' => '_lp_degree',
						'value' => $degree,
						'compare' => '='
					);
			}
			
			if(isset( $data['cate']) && $_GET['cate']){
				$cate = trim( $_GET['cate'] );
				
				$tax_query[] = array(
						'taxonomy' => 'course_category',
						'terms' => $cate,
						'field' => 'slug',
					);
				
			}
			
			$query->set('meta_query', $meta_query );
			$query->set('tax_query', $tax_query );
			
		}
			
	  }
}

add_action('pre_get_posts','search_course');	


/**
 * Check is course
 */
if ( ! function_exists( 'jws_check_is_course' ) ) {
	function jws_check_is_course() {
		if ( function_exists( 'learning_online_is_courses' ) && learning_online_is_courses() ) {
			return true;
		} else {
			return false;
		}
	}
}

/**
 * Check is course taxonomy
 */
if ( ! function_exists( 'jws_check_is_course_taxonomy' ) ) {
	function jws_check_is_course_taxonomy() {
		if ( function_exists( 'learning_online_is_course_taxonomy' ) && learning_online_is_course_taxonomy() ) {
			return true;
		} else {
			return false;
		}
	}
}