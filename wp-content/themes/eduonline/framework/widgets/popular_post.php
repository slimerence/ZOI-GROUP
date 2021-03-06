<?php
class JWS_Post_List_Widget extends RO_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'tb-post tb-widget-post-list';
		$this->widget_description = esc_html__( 'Display a list of your posts on your site.', 'preshool' );
		$this->widget_id          = 'jws_theme_post_list';
		$this->widget_name        = esc_html__( 'Post List Widget', 'preshool' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'post List', 'preshool' ),
				'label' => esc_html__( 'Title', 'preshool' )
			),
			'category' => array(
				'type'   => 'jws_theme_taxonomy',
				'std'    => '',
				'label'  => esc_html__( 'Categories', 'preshool' ),
			),
			'posts_per_page' => array(
				'type'  => 'number',
				'step'  => 1,
				'min'   => 1,
				'max'   => '',
				'std'   => 3,
				'label' => esc_html__( 'Number of posts to show', 'preshool' )
			),
			'orderby' => array(
				'type'  => 'select',
				'std'   => 'date',
				'label' => esc_html__( 'Order by', 'preshool' ),
				'options' => array(
					'none'   => esc_html__( 'None', 'preshool' ),
					'title'  => esc_html__( 'Title', 'preshool' ),
					'date'   => esc_html__( 'Date', 'preshool' ),
					'ID'  => esc_html__( 'ID', 'preshool' ),
				)
			),
			'order' => array(
				'type'  => 'select',
				'std'   => 'none',
				'label' => esc_html__( 'Order', 'preshool' ),
				'options' => array(
					'none'  => esc_html__( 'None', 'preshool' ),
					'asc'  => esc_html__( 'ASC', 'preshool' ),
					'desc' => esc_html__( 'DESC', 'preshool' ),
				)
			),
			'el_class'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Extra Class', 'preshool' )
			)
		);
		parent::__construct();
		add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));
	}
        
	public function widget_scripts() {
		wp_enqueue_script('widget_scripts', get_template_directory_uri() . '/framework/widgets/widgets.js');
	}

	public function widget( $args, $instance ) {
		
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );
                
		$title                  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$category               = isset($instance['category'])? $instance['category'] : '';
		$posts_per_page         = absint( $instance['posts_per_page'] );
		$orderby                = sanitize_title( $instance['orderby'] );
		$order                  = sanitize_title( $instance['order'] );
		$el_class               = sanitize_title( $instance['el_class'] );
                
                echo jws_theme_filtercontent($before_widget);

                if ( $title )
                        echo jws_theme_filtercontent($before_title . $title . $after_title);
                
                $query_args = array(
                    'posts_per_page' => $posts_per_page,
                    'orderby' => $orderby,
                    'order' => $order,
                    'post_type' => 'post',
                    'post_status' => 'publish');
                if (isset($category) && $category != '') {
                    $cats = explode(',', $category);
                    $category = array();
                    foreach ((array) $cats as $cat) :
                    $category[] = trim($cat);
                    endforeach;
                    $query_args['tax_query'] = array(
                                            array(
                                                'taxonomy' => 'category',
                                                'field' => 'id',
                                                'terms' => $category
                                            )
                                    );
                }
                $wp_query = new WP_Query($query_args);
				
				if ($wp_query->have_posts()){
					?>
					<div class="jws_theme_post_list">
						<?php while ($wp_query->have_posts()){ $wp_query->the_post(); ?>
							<div class="jws_theme_post_sidebar">
								
								<div class="jws_theme_post_img">
									<a class="jws_theme_feature_img" href="<?php the_permalink(); ?>">
										<?php
										if(has_post_thumbnail()){
											the_post_thumbnail('thumbnail');
										}else{
											echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr(get_template_directory_uri().'/assets/images/post_default.jpg') .'">';
										}
										?>
									</a>
								</div>
								<div class="jws_theme_post_content">
									<h4 class="jws_theme_title"><a href="<?php the_permalink(get_the_ID());?>"><?php echo the_title();?></a></h4>
									<p class="jws_theme_date"><?php echo get_the_time('j F Y');?></p>
								</div>
								<div style="clear: both"></div>
							</div>
						<?php } ?>
					</div>
				<?php 
				}
				
                wp_reset_postdata();

                echo jws_theme_filtercontent($after_widget);
                
		$content = ob_get_clean();

		echo jws_theme_filtercontent($content);

		$this->cache_widget( $args, $content );
	}
}
/* Class TB_Post_List_Widget */
function register_post_list_widget() {
    register_widget('JWS_Post_List_Widget');
}

add_action('widgets_init', 'register_post_list_widget');
