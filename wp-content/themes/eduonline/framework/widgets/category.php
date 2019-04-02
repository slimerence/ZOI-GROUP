<?php
class Jws_Category_Widget extends WP_Widget { 
    function __construct() {
        parent::__construct(
                'jws_theme_category_course', // Base ID
                __('@Education Course Categories ', 'eduonline'), // Name
                array('description' => __('Course categories', 'eduonline'),) // Args
        );
    }
	function widget($args, $instance) {
		global $post;
		$jws_theme_options = $GLOBALS['jws_theme_options'];
		extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : '';
		
		
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
			$taxonomy     = 'course_category';

			$args_cat = array(
				'taxonomy'     => $taxonomy,
				'title_li'     => '',
			);
			echo '<ul class="tb-course-categories">'; wp_list_categories( $args_cat ); echo '</ul>';
		
		echo jws_theme_filtercontent($after_widget);
        echo ob_get_clean();
    }
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }
    function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Course Categories', 'eduonline');
		$extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
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
function register_category_widget() {
    register_widget('Jws_Category_Widget');
}
add_action('widgets_init', 'register_category_widget');
?>