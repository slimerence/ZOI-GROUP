<?php
vc_map(array(
	"name" => __("Service Box", 'eduonline'),
	"base" => "service_box",
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
				__("Template 1 ( Count Up ~ Number with text )",'eduonline') => "tpl1",
				__("Template 2 ( Count Up ~ only number on top )",'eduonline') => "tpl2",
				__("Template 3 ( Like template 1 ~ only text )",'eduonline') => "tpl3",
				__("Template 4 ( Like default ~ icon left )",'eduonline') => "tpl4",
			),
			"description" => __('Select template in this element.', 'eduonline')
		),
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
		array(
            "type" => "textfield",
            "class" => "",
            "heading" => __("Icon", 'eduonline'),
            "param_name" => "icon",
            "value" => "",
			"dependency" => array(
                    "element"=>"tpl",
                    "value"=>array("tpl","tpl4"),
                    ),
            "description" => __("Please, enter icon in this element", 'eduonline')
        ),
		
		array (
			"type" => "colorpicker",
			"heading" => __( 'Title color', 'eduonline' ),
			"param_name" => "color",
			"value" => '',
			"dependency" => array(
				"element"=>"tpl",
				"value" => array("tpl","tpl4"),
				),
			"description" => __( 'Title color', 'eduonline' ),
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Before Title", 'eduonline'),
			"param_name" => "b_title",
			"dependency" => array(
				"element"=>"tpl",
				"value" => array("tpl1","tpl3"),
			),
			"value" => "",
			"description" => __("Please, enter before title in this element.", 'eduonline')
		),
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Title", 'eduonline'),
			"param_name" => "title",
			"value" => "",
			"description" => __("Please, enter title in this element.", 'eduonline')
		),
			array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("After Title", 'eduonline'),
			"param_name" => "a_title",
			"dependency" => array(
				"element"=>"tpl",
				"value" => array("tpl1","tpl3"),
			),
			"value" => "",
			"description" => __("Please, enter after title in this element.", 'eduonline')
		),
		
		array(
			"type" => "textarea_html",
			"class" => "",
			"heading" => __("Description", 'eduonline'),
			"param_name" => "content",
			"value" => "",
			"description" => __("Please, enter description in this element.", 'eduonline')
		),
		
		array(
			"type" => "textfield",
			"holder" => "div",
			"class" => "",
			"heading" => __("Text button", 'eduonline'),
			"param_name" => "text_button",
			"value" => "",
			"dependency" => array(
				"element"=>"tpl",
				"value" => array("tpl1","tpl3"),
			),
			"description" => __("Please, enter text for button in this element.", 'eduonline')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Button Link", 'eduonline'),
			"param_name" => "ex_link",
			"dependency" => array(
				"element"=>"tpl",
				"value" => array("tpl1","tpl3"),
			),
			"value" => "",
			"description" => __("Please, enter button link in this element.", 'eduonline')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Extra Class", 'eduonline'),
			"param_name" => "el_class",
			"value" => "",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eduonline' )
		),
	)
));
