<?php

add_action('init', 'title_integrateWithVC');

function title_integrateWithVC() {
    vc_map(array(
        "name" => __("Title", 'eduonline'),
        "base" => "title",
        "class" => "title",
        "category" => __('Eduonline', 'eduonline'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
			array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Template", 'eduonline'),
				"param_name" => "tpl",
				"value" => array(
					__("Default",'eduonline') => "tpl",
					__("Template 1 (no line bottom )",'eduonline') => "tpl1",
				),
				"description" => __('Select template in this element.', 'eduonline')
			),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'eduonline'),
                "param_name" => "title",
                "value" => "",
                "description" => __("Content.", 'eduonline')
            ),
			
			array(
                "type" => "attach_image",
                "class" => "",
                "heading" => __("Icon Border bottom", 'eduonline'),
                "param_name" => "icon",
                "value" => "",
				"dependency" => array(
                    "element"=>"tpl",
                    "value"=>array("tpl"),
                ),
                "description" => __("Icon border bottom.", 'eduonline')
            ),
			array(
                "type" => "dropdown",
                "heading" => __('Title Position', "eduonline"),
                "param_name" => "title_align",
                "value" => Array(
                    "Left" => "text-left",
                    "Center" => "text-center",
					"Right" => "text-right"
                ),
				"std" => 'text-center',
                "description" => __('Select Title Position.', "eduonline")
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
