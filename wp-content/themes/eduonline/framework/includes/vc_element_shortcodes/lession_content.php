<?php
vc_map(array(
	"name" => __("Lession Content", 'eduonline'),
	"base" => "lession_content",
	"category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
	
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
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Video Link", 'eduonline'),
			"param_name" => "video_link",
			"value" => "",
			"description" => __("Please, enter video link in this element.", 'eduonline')
		), 
		array(
            "type" => "attach_images",
            "class" => "",
            "heading" => __("Images", 'eduonline'),
            "param_name" => "images",
            "value" => "",
            "description" => __("Select image in this element", 'eduonline')
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
			"heading" => __("Extra Class", 'eduonline'),
			"param_name" => "el_class",
			"value" => "",
			"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eduonline' )
		),
	)
));
