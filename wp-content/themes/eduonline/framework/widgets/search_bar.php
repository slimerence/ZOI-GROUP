<?php

class Eduonline_Widget_Search_Account extends WP_Widget {
	function __construct() {
        parent::__construct(
                'jws_theme_widget_search', // Base ID
                __('@Eduonline Search & Account Widget', 'eduonline'), // Name
                array('description' => __('Course search & Account widget', 'eduonline'),) // Args
        );
    }

	function widget( $args, $instance ) {
		extract($args);
		$show_account = empty( $instance['show_account'] ) ? 0 : 1;
		$show_search = empty( $instance['show_search'] ) ? 0 : 1;
		$extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";
		
		$header_layout =  jws_theme_get_object_id('jws_theme_header_layout');
		
		ob_start();
    ?>
		<div class="jws_themes_widget_search_account <?php echo esc_attr($extra_class);?>">
		
			<div class="widget_searchform_content hidden-sm <?php echo $hidden =  empty( $instance['show_search'] ) ? 'hidden' : ""; ?>">
				<a href="#" class="icon icon_search_wrap"><i class="fa fa-search search-icon"></i></a>
				<?php if ($header_layout == "v2") echo '<div class = "box-overlay">';?>
				<form method="get" action="<?php echo esc_url( home_url( '/'  ) );?>">
					<input type="text" value="<?php echo get_search_query();?>" name="s" placeholder="<?php esc_html_e('Search your course','eduonline');?>" />
					<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
				</form>
				<?php if ($header_layout == "v2") echo '</div>'; ?>
			</div>
			<div class="widget-account-content <?php echo $hidden =  empty( $instance['show_account'] ) ? 'hidden' : ""; ?>">
				<a class="tb_signup" href="<?php echo esc_url(home_url()); ?>/wp-login.php?action=register"><span><?php echo _e('Sign up','eduonline');?></span><i class="fa fa-user-plus" aria-hidden="true"></i></a>
				<a class="tb_login" href="<?php echo esc_url(home_url()); ?>/wp-admin/"><span><?php echo _e('Login','eduonline');?></span><i class="fa fa-user" aria-hidden="true"></i></a>
				<a class="tb_logout" href="<?php echo esc_url(home_url()); ?>/wp-login.php?action=logout&_wpnonce=5c4212d3fc"><span><?php echo _e('Logout','eduonline');?></span><i class="fa fa-user-times" aria-hidden="true"></i></a>					
			</div>
		</div>
    <?php

	echo ob_get_clean();
	}
	 function update($new_instance, $old_instance) {
        $instance = $old_instance;
		
        $instance['show_account'] = $new_instance['show_account'];
        $instance['show_search'] = $new_instance['show_search'];
		$instance['extra_class'] = $new_instance['extra_class'];

        return $instance;
    }

    function form($instance) {
       
        $show_account = isset($instance['show_account']) ? esc_attr($instance['show_account']) : '';
        $show_search = isset($instance['show_search']) ? esc_attr($instance['show_search']) : '';
        $extra_class = isset($instance['extra_class']) ? esc_attr($instance['extra_class']) : '';
        ?>
        <p>
            <input class="widefat" <?php checked($show_account, 1); ?> type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_account')); ?>" name="<?php echo esc_attr($this->get_field_name('show_account')); ?>" value="1" />
			<label for="<?php echo esc_attr($this->get_field_id('show_account')); ?>"><?php _e('Show account button ', 'eduonline'); ?></label>

        </p>
        <p>
            <input class="widefat" <?php checked($show_search, 1); ?> type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_search')); ?>" name="<?php echo esc_attr($this->get_field_name('show_search')); ?>" value="1" />
            <label for="<?php echo esc_attr($this->get_field_id('show_search')); ?>"><?php _e('Show course search ', 'eduonline'); ?></label>

        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('extra_class')); ?>"><?php _e('Extra Class:', 'eduonline'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('extra_class')); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php echo jws_theme_filtercontent($extra_class); ?>" />
        </p>
        <?php
    }
}

function register_eduonline_search_account() {
    register_widget('Eduonline_Widget_Search_Account');
}
add_action('widgets_init', 'register_eduonline_search_account');
