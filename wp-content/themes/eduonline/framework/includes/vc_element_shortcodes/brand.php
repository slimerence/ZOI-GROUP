<?php
vc_map(array(
	"name" => __("Brand", 'eduonline'),
	"base" => "brand_logo",
	"category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Logo", 'eduonline'),
			"param_name" => "logo",
			"value" => "",
			"description" => __("Select logo in this element.", 'eduonline')
		),
		array(
			"type" => "attach_image",
			"class" => "",
			"heading" => __("Logo Active", 'eduonline'),
			"param_name" => "logo_active",
			"value" => "",
			"description" => __("Select logo active in this element.", 'eduonline')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Logo Url", 'eduonline'),
			"param_name" => "logo_url",
			"value" => "",
			"description" => __("Please, enter logo url in this element.", 'eduonline')
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
