<?php
class jws_theme_Social_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
                'jws_theme_social_widget', // Base ID
                __('@Eduonline Socials', 'eduonline'), // Name
                array('description' => __('Social Widget', 'eduonline'),) // Args
        );
    }
    function widget($args, $instance) {
        extract($args);
		$title = !empty($instance['title']) ? $instance['title'] : '';
        $show_tooltip = !empty($instance['show_tooltip']) ? $instance['show_tooltip'] : "";
        $extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";
        $title_social = array();
        $icon_social_ = array();
		$bg_color_ = array();
        $link_social_ = array();
		
        for ($i = 1; $i <= 10; $i++) {
            $title_social[$i] = !empty($instance['title_social_' . $i]) ? esc_attr($instance['title_social_' . $i]) : '';
            $icon_social[$i] = !empty($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $bg_color[$i] = !empty($instance['bg_color_' . $i]) ? esc_attr($instance['bg_color_' . $i]) : '';
            $link_social[$i] = !empty($instance['link_social_' . $i]) ? esc_attr($instance['link_social_' . $i]) : '';
        }
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
		$inline_style = '<style>';
        ?>
        <ul class='wg-footer-socials list-inline'>
            <?php
			$item = 0;
            for ($i = 1; $i <= 10; $i++) {
                if($icon_social[$i]):
				$item++;
                ?>
                <li>
                    <a target="_blank" class="icon-color icon-color<?php echo jws_theme_filtercontent($bg_color[$i]); ?>" href="<?php echo esc_url($link_social[$i]); ?>">
                        <i class="<?php echo jws_theme_filtercontent($icon_social[$i]); ?>"></i>
					<?php if($show_tooltip){?>	<span><?php echo jws_theme_filtercontent($title_social[$i]); ?></span><?php }?>
                    </a>
					<?php 
					if($bg_color[$i]){
						$inline_style .= '.icon-color'.jws_theme_filtercontent($bg_color[$i]).'{background-color:#'.jws_theme_filtercontent($bg_color[$i]).'; color: #'.jws_theme_filtercontent($bg_color[$i]).';border-color: #'.jws_theme_filtercontent($bg_color[$i]).';}';
					}?>
                </li>
        <?php endif; ?>
        <?php } 
			//$inline_style .='.jws_theme_footer_v2 .wg-footer-socials>li{ width:'. round(100 / $item , 1 ) .'% !important}';
			$inline_style .= '</style>';
		?>
        </ul>
        <?php
		echo $inline_style;
        echo jws_theme_filtercontent($after_widget);
        echo ob_get_clean();
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
		$instance['title'] = $new_instance['title'];
        for ($i = 1; $i <= 10; $i++) {
            $instance['title_social_' . $i] = $new_instance['title_social_' . $i];
            $instance['icon_social_' . $i] = $new_instance['icon_social_' . $i];
            $instance['bg_color_' . $i] = $new_instance['bg_color_' . $i];
            $instance['link_social_' . $i] = $new_instance['link_social_' . $i];
        }
        $instance['show_tooltip'] = $new_instance['show_tooltip'];
        $instance['extra_class'] = $new_instance['extra_class'];
        return $instance;
    }

    function form($instance) {
        $title_social = array();
        $icon_social = array();
        $link_social = array();
        $bg_color = array();
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        for ($i = 1; $i <= 10; $i++) {
            $title_social[$i] = isset($instance['title_social_' . $i]) ? esc_attr($instance['title_social_' . $i]) : '';
            $icon_social[$i] = isset($instance['icon_social_' . $i]) ? esc_attr($instance['icon_social_' . $i]) : '';
            $bg_color[$i] = isset($instance['bg_color_' . $i]) ? esc_attr($instance['bg_color_' . $i]) : '';
            $link_social[$i] = isset($instance['link_social_' . $i]) ? esc_attr($instance['link_social_' . $i]) : '';
        }
        $show_tooltip = isset($instance['show_tooltip']) ? esc_attr($instance['show_tooltip']) : '';
        $extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
		?>
		<p>
			<label for="<?php echo esc_url($this->get_field_id('title')); ?>"><?php _e('Title:', 'eduonline');?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		
		<?php
        for ($i = 1; $i <= 10; $i++) {
            ?>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('title_social_' . $i)); ?>"><?php _e('Social Title:', 'eduonline');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('title_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($title_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('icon_social_' . $i)); ?>"><?php _e('Social Icon:', 'eduonline');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('icon_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('icon_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($icon_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('link_social_' . $i)); ?>"><?php _e('Social Link:', 'eduonline');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_social_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('link_social_' . $i)); ?>" type="text" value="<?php echo esc_attr($link_social[$i]); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_url($this->get_field_id('bg_color_' . $i)); ?>"><?php _e('Background color for icon social ', 'eduonline');
            echo esc_html($i); ?></label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('bg_color_' . $i)); ?>" name="<?php echo esc_attr($this->get_field_name('bg_color_' . $i)); ?>" type="text" value="<?php echo esc_attr($bg_color[$i]); ?>" />
            </p>
        <?php } ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('show_tooltip')); ?>"><?php _e('Show tooltip:', 'eduonline'); ?></label>
            <input class="widefat" <?php checked($show_tooltip, 1); ?> type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_tooltip')); ?>" name="<?php echo esc_attr($this->get_field_name('show_tooltip')); ?>" value="1" />
        </p>
       
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'eduonline'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo jws_theme_filtercontent($extra_class); ?>" />
        </p>
        <?php
    }
}
/**
 * Class jws_theme_Social_Widget
 */
function register_social_widget() {
    register_widget('jws_theme_Social_Widget');
}
add_action('widgets_init', 'register_social_widget');
?>
