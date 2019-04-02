<?php
function jws_theme_blog_carousel_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'category' => '',
		'style' => 'blog',
        'course_style' => 'entry',
        'show' => 'all',
        'course_category' => '',
		'columns' =>  4,
		'tab_active' =>  1,
        'show_title' => 1,
        'show_excerpt' => 1,
        'excerpt_length' => 25,
        'excerpt_more' => '...',
        'show_price' => 1,
        'show_date' => 1,
        'show_lession' => 1,
        'show_cate' => 1,
        'read_more' => 1,
        'read_more_text' => 'Read More',
        'orderby' => 'none',
        'order' => 'none',
        'el_class' => ''
    ), $atts));
			
    $class = array();
    $class[] = 'tb-blog-carousel tb-blog-carousel'. intval( $columns );
    $class[] = 'tb-'.$post_type.'-carousel';
    $class[] = $el_class;
    $class[] = $show;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
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
    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
        'post_type' => $post_type,
        'post_status' => 'publish');
	 if($show == 'featured'){
		 $args['meta_query'] = array(
					array(
                        'key'     => '_lp_featured',
						'compare' => '=',
						'value' => 'yes',
					)
                );
		$style = $style.'-'.$show;
	}
    if (isset($category) && $category != '') {
        $cats = explode(',', $category);
        $category = array();
		$i = 0;
        foreach ((array) $cats as $cat) :
        $category[] = trim($cat);
		$i++;
        endforeach;
		$cate = $category[0];
		if($i != 0 && intval($tab_active) <= $i){
			$cate = $category[ intval($tab_active) - 1 ];
		}else $tab_active = 1;
        $args['tax_query'] = array(
                            array(
                                'taxonomy' => $taxonomy,
                                'field' => 'id',
                                'terms' => $cate
                            )
                        );
    }
    $wp_query = new WP_Query($args);
	
    ob_start();
	
	if ( $wp_query->have_posts() ) {
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
	<?php if($post_type == 'lp_course' && $show_cate ){?>
		<ul class="tb-cate-course list-inline text-center">
        <?php
            if (isset($course_category) && $course_category != '') {
                $cats = explode(',', $course_category);
				$j = 1;
                foreach( $cats as $cat ):
                    $cat = get_term( $cat, 'course_category' );
					
					$class_active = ( intval($tab_active) == $j ) ? 'active' : '';
					$j++;
					
                    if( $cat ):
                ?>
                    <li>
                        <a class="<?php echo esc_attr($class_active); ?>" data-cat="<?php echo (int) $cat->term_id;?>"  href="#"><span><?php echo esc_attr( $cat->name );?></span></a>
                    </li>
                <?php
                    endif;
                endforeach;
            }else{
                $cats = get_terms('course_category', array('parent' => 0, 'orderby' => 'slug','hide_empty' => false));
                foreach( $cats as $cat ):
                ?>
                <li>
                    <a data-cat="<?php echo (int) $cat->term_id;?>"  href="#"><span><?php echo esc_attr( $cat->name );?></span></a>
                </li>
                <?php
                endforeach;
            }
        ?>
        </ul>
	<?php }?>
		<div class="tb-reload">
			<div class="owl-carousel">
				<?php
					while ( $wp_query->have_posts() ) { $wp_query->the_post();
							include "$post_type/$style.php";
					} wp_reset_postdata();
				?>
			</div>
		</div>
		<a class="hidden tb-filter-param" data-columns = '<?php echo esc_attr($columns); ?>' data-args='<?php echo json_encode( $args );?>' data-atts='<?php echo json_encode( $atts );?>' ></a> 
	</div>
    <?php
	}
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('tb_blog_carousel', 'jws_theme_blog_carousel_func'); }
