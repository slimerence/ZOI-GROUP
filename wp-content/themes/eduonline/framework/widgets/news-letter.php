<?php

/**
 * Newsletter widget version 2.0: it'll replace the old version left for compatibility.
 */
class Eduonline_NewsletterWidget extends WP_Widget {

    function __construct() {
        parent::__construct(false, $name = '@Eduonline Newsletter', array('description' => 'Newsletter widget to add subscription forms on sidebars'), array('width' => '350px'));
    }

    static function get_widget_form( array $instance=array() ) {
        $options_profile = get_option('newsletter_profile');
        $placeholder =( isset( $instance['placeholder'] ) ) ? $instance['placeholder'] : __('Enter your email','Eduonline');
        $email = is_email( $options_profile['email'] ) ? $options_profile['email'] : $placeholder;
        $form = NewsletterSubscription::instance()->get_form_javascript();

        $form .= '<form action="' . home_url('/') . '?na=s" onsubmit="return newsletter_check(this)" method="post">';
        // Referrer
        $form .= '<input type="hidden" name="nr" value="widget"/>';

        if ($options_profile['name_status'] == 2)
            $form .= '<p><input class="newsletter-firstname" placeholder="'. esc_attr( $placeholder ) .'" type="text" name="nn" value="' . esc_attr($options_profile['name']) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if ($options_profile['surname_status'] == 2)
            $form .= '<p><input class="newsletter-lastname" placeholder="'. esc_attr( $placeholder ) .'" type="text" name="ns" value="' . esc_attr($options_profile['surname']) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        $form .= '<p><input class="newsletter-email" type="email" placeholder="'. esc_attr( $placeholder ) .'" required name="ne" value="' . esc_attr( $email ) . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';

        if (isset($options_profile['sex_status']) && $options_profile['sex_status'] == 2) {
            $form .= '<p><select name="nx" class="newsletter-sex">';
            $form .= '<option value="m">' . $options_profile['sex_male'] . '</option>';
            $form .= '<option value="f">' . $options_profile['sex_female'] . '</option>';
            $form .= '</select></p>';
        }

        // Extra profile fields
        for ($i = 1; $i <= NEWSLETTER_PROFILE_MAX; $i++) {
            if ($options_profile['profile_' . $i . '_status'] != 2)
                continue;
            if ($options_profile['profile_' . $i . '_type'] == 'text') {
                $form .= '<p><input class="newsletter-profile newsletter-profile-' . $i . '" type="text" name="np' . $i . '" value="' . $options_profile['profile_' . $i] . '" onclick="if (this.defaultValue==this.value) this.value=\'\'" onblur="if (this.value==\'\') this.value=this.defaultValue"/></p>';
            }
            if ($options_profile['profile_' . $i . '_type'] == 'select') {
                $form .= '<p>' . $options_profile['profile_' . $i] . '<br /><select class="newsletter-profile newsletter-profile-' . $i . '" name="np' . $i . '">';
                $opts = explode(',', $options_profile['profile_' . $i . '_options']);
                for ($t = 0; $t < count($opts); $t++) {
                    $form .= '<option>' . trim($opts[$t]) . '</option>';
                }
                $form .= '</select></p>';
            }
        }

        $lists = '';
        for ($i = 1; $i <= NEWSLETTER_LIST_MAX; $i++) {
            if ($options_profile['list_' . $i . '_status'] != 2)
                continue;
            $lists .= '<input type="checkbox" name="nl[]" value="' . $i . '"';
            if ($options_profile['list_' . $i . '_checked'] == 1)
                $lists .= ' checked';
            $lists .= '/>&nbsp;' . $options_profile['list_' . $i] . '<br />';
        }
        if (!empty($lists))
            $form .= '<p>' . $lists . '</p>';


        $extra = apply_filters('newsletter_subscription_extra', array());
        foreach ($extra as &$x) {
            $form .= "<p>";
            if (!empty($x['label']))
                $form .= $x['label'] . "<br/>";
            $form .= $x['field'] . "</p>";
        }

        if ($options_profile['privacy_status'] == 1) {
            if (!empty($options_profile['privacy_url'])) {
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;<a target="_blank" href="' . $options_profile['privacy_url'] . '">' . $options_profile['privacy'] . '</a></p>';
            }
            else
                $form .= '<p><input type="checkbox" name="ny"/>&nbsp;' . $options_profile['privacy'] . '</p>';
        }

        if (strpos($options_profile['subscribe'], 'http://') !== false) {
            $form .= '<p><input class="newsletter-submit" type="image" src="' . $options_profile['subscribe'] . '"/></p>';
        } else {
            $form .= '<p><input class="newsletter-submit" type="submit" value="' . $options_profile['subscribe'] . '"/></p>';
        }
        // hide popup
        $form .= '<div class="tb-newsletter-checkbox"><input type="checkbox" name="hide_popup" id="tb-hide-popup"><span>' . esc_html__("Don’t show this popup again","Eduonline") .'</span></div>';

        $form .= '</form>';

        return $form;
    }

    function widget($args, $instance) {
        global $newsletter;
        extract($args);

        echo $before_widget;

        // Filters are used for WPML
        if (!empty($instance['title'])) {
            $title = apply_filters('widget_title', $instance['title'], $instance);
        }
        $buffer=$desc='';
        $exist_desc = !empty( $instance['desc'] );
         
		if( $exist_desc ){
			$desc .= '<div class="newsletter-desc">';
			$desc .= $before_title . $title . $after_title;
			$desc .= '<p>'. $instance['desc'].'</p>';
			$desc .= '</div><div class= "newsletter-form">';
		}
		
        $options = get_option('newsletter');
        $options_profile = get_option('newsletter_profile');

        $buffer .= $desc;

       

		$form = NewsletterSubscription::instance()->get_form_javascript();

		$form .= '<div class="newsletter newsletter-widget">';
		$form .= Eduonline_NewsletterWidget::get_widget_form( $instance );
		$form .= '</div>';

		// Canot user directly the replace, since the form is different on the widget...
		if (strpos($buffer, '{subscription_form}') !== false)
			$buffer = str_replace('{subscription_form}', $form, $buffer);
		else {
			if (strpos($buffer, '{subscription_form_') !== false) {
				// TODO: Optimize with a method to replace only the custom forms
				$buffer = $newsletter->replace($buffer);
			} else {
				$buffer .= $form;
			}
		}

        if($exist_desc ){
            if( $exist_desc ){
                $buffer .='</div>';
            }
        }

        // That replace all the remaining tags
        $buffer = $newsletter->replace($buffer);

        echo $buffer;
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['placeholder'] = strip_tags($new_instance['placeholder']);
        $instance['desc'] = $new_instance['desc'];
        return $instance;
    }

    function form($instance) {
        if (!is_array($instance)) $instance = array();
        $instance = array_merge(array('title'=>'', 'text'=>'','placeholder'=>'','desc'=>''), $instance);
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php esc_html_e('Title','Eduonline');?>:
                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
            </label>

            <label for="<?php echo $this->get_field_id('desc'); ?>">
                <?php esc_html_e('Description','Eduonline');?>:
                <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>"><?php echo wp_kses_post($instance['desc']); ?></textarea>
            </label>

            <label for="<?php echo $this->get_field_id('placeholder'); ?>">
                <?php esc_html_e('Placeholder','Eduonline');?>:
                <input class="widefat" id="<?php echo $this->get_field_id('placeholder'); ?>" name="<?php echo $this->get_field_name('placeholder'); ?>" type="text" value="<?php echo esc_attr($instance['placeholder']); ?>" />
            </label>

        <p>Use the tag {subscription_form} to place the subscription form within your personal text.
        </p>
        <?php
    }

}

add_action('widgets_init', create_function('', 'return register_widget("Eduonline_NewsletterWidget");'));
?>
