<?php
vc_map(array(
	"name" => __("About", 'eduonline'),
	"base" => "about",
	"category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Title", 'eduonline'),
			"param_name" => "title",
			"value" => "",
			"description" => __("Please, Enter text of title.", 'eduonline')
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
            "type" => "attach_image",
            "class" => "",
            "heading" => __("Image", 'eduonline'),
            "param_name" => "image_1",
            "value" => "",
            "description" => __("Select image in this element", 'eduonline')
        ),
		array(
            "type" => "attach_image",
            "class" => "",
            "heading" => __("Image", 'eduonline'),
            "param_name" => "image_2",
            "value" => "",
            "description" => __("Select image in this element", 'eduonline')
        ),
		array(
			"type" => "checkbox", 
			"heading" => __('Crop image', "eduonline"),
			"param_name" => "crop_image",
			"value" => array(
				__("Yes, please", "eduonline") => 1
			),
			"description" => __('Crop or not crop image on your Post.', "eduonline")
		),
		array(
			"type" => "textfield",
			"heading" => __('Width image', "eduonline"),
			"param_name" => "width_image",
			
			"description" => __('Enter the width of image. Default: 670.', "eduonline")
		),
		array(
			"type" => "textfield",
			"heading" => __('Height image', "eduonline"),
			"param_name" => "height_image",
			"description" => __('Enter the height of image. Default: 450.', "eduonline")
		),
        array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Link button", 'eduonline'),
			"param_name" => "ex_link",
			"value" => "",
			"std" =>"",
			"description" => __("Please, Enter link for button in this element.", 'eduonline')
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
