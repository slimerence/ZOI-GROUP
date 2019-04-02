<?php

function jws_theme_portfolio_func($atts) {
    $atts=shortcode_atts(array(

		'posts_per_page' => -1,

		'show_filter' => 1,

		'tpl' => 'tpl',

		'orderby' => 'none',

		'show_count' => 0,

        'order' => 'none',

        'el_class' => '',

        'viewall' => '',

        'linkall' => '#',

        'viewmore' => ''

         ), $atts);
	extract($atts);

    $class = array();

    $parent_class = array('portfolio-template');
    if( $tpl == 'tpl1' ){
    	$parent_class[] = 'grid-portfolio';
    }elseif( $tpl == 'tpl2'){
    	$parent_class[] = 'grids-portfolio portfolio-mixit row';
    }else{
    	$parent_class[] = 'grid-portfolio grids-portfolio portfolio-template row';
    }
    $class[] = $el_class;

    $class[] = $tpl;
	
	$paged = (get_query_var('paged')) ? get_query_var('paged') : (get_query_var('page')) ? get_query_var('page') : 1;
	
	
    $args = array(

	
        'posts_per_page' => $posts_per_page,

        'paged' => $paged,

        'orderby' => $orderby,

        'order' => $order,

        'post_type' => 'portfolio',

        'post_status' => 'publish');
		
    if (isset($category) && $category != '') {

        $cats = explode(',', $category);

        $category = array();

        foreach ((array) $cats as $cat) :

        $category[] = trim($cat);

        endforeach;

        $args['tax_query'] = array(

                array(

                    'taxonomy' => 'portfolio_category',

                    'field' => 'id',

                    'terms' => $category

                )

        );

    }

    $p = new WP_Query($args);

	wp_enqueue_script('isotope', JWS_THEME_URI_PATH . '/assets/js/vendors/isotope/isotope.pkgd.min.js',array(),"2.1.5");
	

    ob_start();

	

	if ( $p->have_posts() ) {

	?>
		<script src="https://npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>

		<div id="tb-list-portfolio" class="<?php echo esc_attr(implode(' ', $class)); ?>">
			
			<?php if( $show_filter ) { ?>

				<ul class="controls-filter list-unstyled list-inline text-center">

					<li class="filter active" data-filter="*"><a href="javascript:void(0);"><?php _e('All', 'eduonline');?><?php if( $show_count && $p->post_count ){?><span><?php echo intval($p->post_count);?></span><?php }?></a></li>

					<?php
						$terms = get_terms('portfolio_category');

						if ( !empty( $terms ) && !is_wp_error( $terms ) ){
							foreach ( $terms as $term ) {
							?>
								<li class="filter" data-filter=".<?php echo esc_attr($term->slug); ?>"><a href="javascript:void(0);"><?php echo esc_html($term->name); ?><?php if( $show_count && $term->count ){?><span><?php echo intval($term->count);?></span><?php }?></a></li>

							<?php

							}

						}

					?>

				</ul>

			<?php } ?>

			<div id="porfolio-container" class="tb-grid-content <?php echo esc_attr(implode(' ',$parent_class));?> tb-portfolio<?php if( !$show_filter ) echo ' no-filter';?>">
				<?php
					$class_columns = array();

					$i = 0;
					?>
					
					<?php
						include 'tpl/'.$tpl.'.php';
				?> 
			</div>
		</div>
	 <?php
    }else {
            echo 'Post not found!';
    } 
    wp_reset_postdata();
		
    return ob_get_clean();
}



if(function_exists('insert_shortcode')) { insert_shortcode('portfolio', 'jws_theme_portfolio_func'); }
