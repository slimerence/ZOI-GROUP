<?php

add_action('init', 'jws_theme_logo_integrateWithVC');

function jws_theme_logo_integrateWithVC() {
    vc_map(array(
        "name" => __("Insert Logo", 'eduonline'),
        "base" => "logo",
        "class" => "tb-logo",
        "category" => __('Eduonline', 'eduonline'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Align", 'eduonline'),
                "param_name" => "el_align",
                "value" => array(
                    __("Left",'eduonline') => "text-left",
                    __("Right",'eduonline') => "text-right",
                    __("Center",'eduonline') => "text-center"
                ),
                "std" => "text-center",
                "description" => __("Align", 'eduonline')
            ), 
            array (
                "type" => "colorpicker",
                "heading" => __ ( 'Color', 'eduonline' ),
                "param_name" => "color",
                "value" => '',
                "std" => '#353535',
                "description" => __ ( 'Color', 'eduonline' ),
            ),
            array(

                "type" => "attach_image",

                "class" => "",

                "heading" => __("Image Logo", 'eduonline'),

                "param_name" => "image_logo",

                "value" => "",

                "description" => __("Insert logo image.", 'eduonline')

            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Font size", 'eduonline'),
                "param_name" => "font_size",
                "value" => "",
                "std" => '55px',
                "description" => __("Font size.", 'eduonline')
            ),          
            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Animation", 'eduonline'),
                "param_name" => "animation",
                "value" => array(
                    __("No",'cayto') => "",
                    __("Top to bottom",'eduonline') => "top-to-bottom",
                    __("Bottom to top",'eduonline') => "bottom-to-top",
                    __("Left to right",'eduonline') => "left-to-right",
                    __("Right to left",'eduonline') => "right-to-left",
                    __("Appear from center",'eduonline') => "appear"
                ),
                "description" => __("Animation", 'eduonline')
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Extra Class", 'eduonline'),
                "param_name" => "el_class",
                "value" => "",
                "description" => __("Extra Class.", 'eduonline')
            ),
        )
    ));
}
