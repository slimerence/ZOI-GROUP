<?php
if(class_exists('LearningOnline')){
    vc_map(array(
        "name" => __("Category", 'eduonline'),
        "base" => "tb-category",
        "class" => "ro-category",
        "category" => __('Eduonline', 'eduonline'),
        'admin_enqueue_js' => array(JWS_THEME_URI_PATH_FR.'/assets/js/customvc.js'),
        "icon" => "tb-icon-for-vc",
        "params" => array(
			array (
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Template", 'eduonline' ),
				"param_name" => "tpl",
				"value" => array (
						__("Template 1 ~ slider",'eduonline') => "tpl1",
						__("Template 2 ~ grid",'eduonline') => "tpl2",
				),
				"description" => __( "Select a template type in this elment", 'eduonline' )
			),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Post Count", "eduonline"),
                "param_name" => "number",
                "value" => "",
				"description" => __('Please, enter number of post per page for course. Show all: -1.', "eduonline")
            ),

            array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Columns", "eduonline"),
                "param_name" => "columns",
                 "value" => array(
                    "4 Columns" => "4",
                    "3 Columns" => "3",
                    "2 Columns" => "2",
                    "1 Column" => "1",
                ),
				 
				"description" => __('Select columns for course.', "eduonline")
            ),
			 array(
                "type" => "checkbox",
                "heading" => __('Show Title', 'eduonline'),
                "param_name" => "show_title",
                "value" => array(
                    __("Yes, please", 'eduonline') => 1
                ),
				"std" => 1,
                "description" => __('Show or hide title of post on your category.', 'eduonline')
            ),
			 array(
                "type" => "checkbox",
                "heading" => __('Show Number ', 'eduonline'),
                "param_name" => "show_number",
                "value" => array(
                    __("Yes, please", 'eduonline') => 1
                ),
				"std" => 1,
                "description" => __('Show or hide number of products on your category.', 'eduonline')
            ),
			 array(
                "type" => "checkbox",
                "heading" => __('Show Image', 'eduonline'),
                "param_name" => "show_image",
                "value" => array(
                    __("Yes, please", 'eduonline') => 1
                ),
				"std" => 1,
                "description" => __('Show or hide images of post on your category.', 'eduonline')
            ),
			
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Extra Class", 'eduonline'),
                "param_name" => "el_class",
                "value" => "",
				"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eduonline' )
            ),
        )
    ));
}
