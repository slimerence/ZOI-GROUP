<?php
class Jws_Testimonial_Widget extends WP_Widget { 
    function __construct() {
        parent::__construct(
                'jws_theme_testimonial', // Base ID
                __('@Eduonline Testimonial', 'eduonline'), // Name
                array('description' => __('Testimonial Widget', 'eduonline'),) // Args
        );
    }
	function widget($args, $instance) {
		extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $number = !empty($instance['number']) ? esc_attr($instance['number']) : '';
        $excerpt_length = !empty($instance['excerpt_length']) ? esc_attr($instance['excerpt_length']) : '';
        $excerpt_more = !empty($instance['excerpt_more']) ? esc_attr($instance['excerpt_more']) : '';
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : '';
		
		$args = array(
			'post_type' => 'testimonial',
			'post_status' => 'publish',
			'posts_per_page' => $number
		);
		$wp_query = new WP_Query($args);
		
		// no 'class' attribute - add one with the value of width
        if (strpos($before_widget, 'class') === false) {
            $before_widget = str_replace('>', 'class="' . $extra_class . '"', $before_widget);
        }
        // there is 'class' attribute - append width value to it
        else {
            $before_widget = str_replace('class="', 'class="' . $extra_class . ' ', $before_widget);
        }
		ob_start();
        echo jws_theme_filtercontent($before_widget);
		
		if ( $title ) echo jws_theme_filtercontent($before_title . $title . $after_title);
		
		if($wp_query->have_posts()){
			echo "<ul>";
			while($wp_query->have_posts()){ $wp_query->the_post();
					?><li>
						<div class="tb-image">
						<?php if(has_post_thumbnail()){
							the_post_thumbnail('eduonline-testimonial-widget');
						}?>
						</div>
						<div class="tb-content">
							<h4 class="tb-name"><?php the_title(); ?></h4>
							<?php
								$position = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_testimonial_position', true) );
								if($position) echo ' - <span class="tb-position">'. $position.'</span>';
							?>
							<div class="tb-item-content">
								<?php if(intval($excerpt_length) > 0 ) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>

							</div>
						</div>
						<div style="clear: both"></div>
					</li><?php
			}
			echo "</ul>";
		}
		
		echo jws_theme_filtercontent($after_widget);
        echo ob_get_clean();
    }
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['number'] = $new_instance['number'];
		$instance['excerpt_length'] = $new_instance['excerpt_length'];
		$instance['excerpt_more'] = $new_instance['excerpt_more'];
		$instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }
    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Testimonials', 'eduonline');
		$number = isset($instance['number']) ? esc_attr($instance['number']) : '3';
		$excerpt_length = isset($instance['excerpt_length']) ? esc_attr($instance['excerpt_length']) : '25';
		$excerpt_more = isset($instance['excerpt_more']) ? esc_attr($instance['excerpt_more']) : '...';
		$extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php _e('Number:', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="number" value="<?php echo esc_attr($number); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>"><?php _e('Excerpt length (0 is hidden excerpt):', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('excerpt_length')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_length')); ?>" type="number" value="<?php echo esc_attr($excerpt_length); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('excerpt_more')); ?>"><?php _e('Excerpt more:', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('excerpt_more')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_more')); ?>" type="text" value="<?php echo esc_attr($excerpt_more); ?>" />
		</p>
		<p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'eduonline'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo jws_theme_filtercontent($extra_class); ?>" />
        </p>
		<?php
    }
}
/**
 * Class TB_Recent_Work_Widget
 */
function register_testimonial_widget() {
    register_widget('Jws_Testimonial_Widget');
}
add_action('widgets_init', 'register_testimonial_widget');
?>