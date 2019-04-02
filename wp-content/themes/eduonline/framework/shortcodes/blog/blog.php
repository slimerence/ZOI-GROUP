<?php
function tb_blog_func($atts) {
    $atts=shortcode_atts(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category' => '',
		'h_video' => '',
        'course_category' => '',
        'event_category' => '',
		'columns' =>  4,
        'style' => 'blog',
        'course_style' => 'entry',
        'event_style' => 'entry',
		'grid_style' => '',
		'post_format' => 'default',
        'show_popup' => 0,
        'show_content' => 1,
        'show_lession' => 1,
        'show_title' => 0,
        'show_date' => 0,
        'show_cate' => 0,
        'show_info' => 0,
        'show_view' => 0,
        'show_excerpt' => 0,
        'excerpt_length' => 25,
        'read_more' => 0,
		'read_more_text' => 'Read more',
        'excerpt_more' => '...',
        'orderby' => 'none',
        'order' => 'none',
		'ob_animation' => 'wrap',
		'animation' => '',
		'show_pagination' => 0,
		'pos_pagination' => 'text-center',
        'el_class' => ''
    ), $atts);
	extract($atts);
    
	$style_wrap = array();
	$class = array();
	$class[] = $style;
	$class[] = $grid_style;
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
        case 'event':
            $category = $event_category;
            $taxonomy = 'event_category';
            $style = $event_style;
            break;
    }
    $cl_effect = getCSSAnimation($animation);
    $class[] = 'tb-blog';
    $class[] = ($grid_style == 'no-padding') ? '' : 'course-same-height';
	
    $class[] = $post_type;
    $class[] = $post_format;
    $class[] = $style;
	
	if($ob_animation == 'wrap') $class[] = $cl_effect;
    $class[] = $el_class;
    
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    
    $args = array(
		'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
        'post_type' => $post_type,
        'post_status' => 'publish'
	);	
	if($post_format == 'video'){
		$args['tax_query'][] = array(
			'taxonomy' => 'post_format',
			'field' => 'slug',
			'terms' => 'post-format-'.$post_format
		);
	}
	if($post_format == 'free'){
		 $args['meta_query'] = array(
			array(
                'key'     => '_lp_price',
				'compare' => 'NOT EXISTS',
				'value' => 'null',
			)
        );
		
	}
    if (isset($category) && $category != '') {
        $cats = explode(',', $category);
        $category = array();
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
        endforeach;
        $args['tax_query'][] = array(
                'taxonomy' => $taxonomy,
                'field' => 'slug',
                'terms' => $category
            );
    }

    $wp_query = new WP_Query($args);
	
	
	if($post_type == 'event'){
		$columns = 1;
		wp_enqueue_script('jq.countdown.min', JWS_THEME_URI_PATH . '/assets/js/jquery.countdown.js');

	}
    ob_start();
    
    if ( $wp_query->have_posts() ) {
    ?>
    <div class="row <?php echo esc_attr(implode(' ', $class)); ?>" style="<?php echo esc_attr(implode(' ', $style_wrap)); ?> ">
		<?php
			$loop = 0;
			$class_columns = array();
				
			switch ($columns) {
				case 1:
					$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
					break;
				case 2:
					$class_columns[] = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
					break;
				case 3:
					$class_columns[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-4';
					break;
				case 4:
					$class_columns[] = 'col-xs-12 col-sm-6 col-md-4 col-lg-3 col-4';
					break;
				default:
					$class_columns[] = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
					break;
			}
			$video = 0;
			if($ob_animation == 'item') $class_columns[] = $cl_effect;			
			while ( $wp_query->have_posts() ) { $wp_query->the_post();global $post;
				if($post_format == 'video') {
						$format = '';
						$format = get_post_format();
						if($format == 'video' && is_file(dirname(__FILE__)."/$post_type/$style-$format.php")){
							echo '<div class="'.esc_attr(implode(' ', $class_columns)).'">';
								include "$post_type/$style-$format.php";
							echo '</div>';
							$video++;
						}
				}
				else{
					echo '<div class="'.esc_attr(implode(' ', $class_columns)).'">';
							include "$post_type/$style.php";
					echo '</div>';
				}
			}
			 $paged = is_front_page() ? get_query_var('page') : get_query_var('paged'); $paged = max(1, $paged); if($show_pagination){ ?>
			<nav class="pagination <?php echo esc_attr($pos_pagination); ?>" role="navigation">
				<?php
					$big = 999999999; // need an unlikely integer
					
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?paged=%#%',
						'current' => max( 1, $paged ),
						'total' => $wp_query->max_num_pages,
						'type'               => 'plain',
						'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'eduonline' ),
						'next_text' => __( '<i class="fa fa-angle-right"></i>', 'eduonline' ),
					) );
				?>
			</nav>
		<?php } ?>

    </div>
    <?php
    }else {
            echo 'Post not found!';
    } 
    ?>
    
    <?php
    wp_reset_postdata();
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_blog', 'tb_blog_func'); }

