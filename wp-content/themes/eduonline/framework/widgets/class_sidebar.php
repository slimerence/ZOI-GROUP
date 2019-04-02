<?php
class Jws_Class_Sidebar_Widget extends WP_Widget { 
    function __construct() {
        parent::__construct(
                'jws_theme_classes_widget', // Base ID
                __('Classes sidebar', 'eduonline'), // Name
                array('description' => __('Classes sidebar', 'eduonline'),) // Args
        );
    }
	function widget($args, $instance) {
		$jws_theme_options = $GLOBALS['jws_theme_options'];
		extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : '';
		$jws_theme_classes_show_button_price = (int) isset($jws_theme_options['jws_theme_classes_show_button_price']) ? $jws_theme_options['jws_theme_classes_show_button_price'] : -1;

		$jws_theme_classes_url_price = (int) isset($jws_theme_options['jws_theme_classes_url_price']) ? $jws_theme_options['jws_theme_classes_url_price'] : '';

		$jws_theme_classes_show_button_register = (int) isset($jws_theme_options['jws_theme_classes_show_button_register']) ? $jws_theme_options['jws_theme_classes_show_button_register'] : -1;

		$jws_theme_classes_url_register = (int) isset($jws_theme_options['jws_theme_classes_url_register']) ? $jws_theme_options['jws_theme_classes_url_register'] : '';
		$args = array(
			'post_type' => 'courses',
			'posts_per_page' => 3,
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
		echo '<div class="jws_theme_classes_widget">';
			
			while ( have_posts() ) : the_post();
				$post_id = get_the_ID();
				$year_olds = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_year_olds', true) );
				$class_size = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_classes_size', true) );
				$member = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_member_hours', true) );
				$start_date = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_start_date', true) );
				$class_duration = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_duration', true) );
				$transportation = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_transportation', true) );
				$class_staff = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_staff', true) );
				$class_price_per_day = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_class_price', true) );
				?>
				<div class="classes-meta-item">
					<i class="fa fa-calendar"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Start date','prechool'); ?>
						<span><?php echo $start_date; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-birthday-cake"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Years old','prechool'); ?>
						<span><?php echo $year_olds; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-home"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class size','prechool'); ?>
						<span><?php echo $class_size; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-clock-o"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class durantion','prechool'); ?>
						<span><?php echo $class_duration; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-car"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Transportation','prechool'); ?>
						<span><?php echo $transportation; ?></span>
					</div>
				</div>
				<div class="classes-meta-item">
					<i class="fa fa-users"></i>
					<div class="classes-meta-item-content">
						<?php echo esc_html__('Class staff','prechool'); ?>
						<span><?php echo $class_staff; ?></span>
					</div>
				</div>
				
				
			<?php endwhile;
		echo '</div>';
		 if($jws_theme_classes_show_button_price)?> <a class="btn-pre-v2 button-price" href="<?php echo esc_url($jws_theme_classes_url_price);?>"><?php echo esc_html__($class_price_per_day,'prechool'); ?></a>
		<?php if($jws_theme_classes_show_button_register)?> <a class="btn-pre-v2 button-register" href="<?php echo esc_url($jws_theme_classes_url_register);?>"><?php echo esc_html__('Register today','prechool'); ?></a>
		<?php 
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
		$title = isset($instance['title']) ? esc_attr($instance['title']) : __('Classes sidebar', 'eduonline');
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
function register_class_sidebar_widget() {
    register_widget('Jws_Class_Sidebar_Widget');
}
add_action('widgets_init', 'register_class_sidebar_widget');
?>