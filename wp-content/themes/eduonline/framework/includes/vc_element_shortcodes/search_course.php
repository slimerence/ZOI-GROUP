<?php
vc_map(array(
	"name" => __("Search Courses", 'eduonline'),
	"base" => "search_course",
	"class" => "search-courses",
	"category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title", 'eduonline'),
			"param_name" => "title",
			"value" => "",
			"description" => __("Search title.", 'eduonline')
		),
	   
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Sub Title", 'eduonline'),
			"param_name" => "sub_title",
			"value" => "",
			"description" => __("Search sub title.", 'eduonline')
		),
	   
		array(
			"type" => "checkbox",
			"heading" => __('Show Textbox', "eduonline"),
			"param_name" => "show_textbox",
			"value" => array(
				__("Yes, please", "eduonline") => 1
			),
			"std"   => 1,
			"description" => __('Show or hide textbox of this search.', "eduonline")
		),
		array(
			"type" => "checkbox",
			"heading" => __('Show Category Dropdown', "eduonline"),
			"param_name" => "show_category",
			"value" => array(
				__("Yes, please", "eduonline") => 1
			),
			"std"   => 1,
			"description" => __('Show or hide category dropdown of this search.', "eduonline")
		),
		array(
			"type" => "checkbox",
			"heading" => __('Show Degree Dropdown', "eduonline"),
			"param_name" => "show_degree",
			"value" => array(
				__("Yes, please", "eduonline") => 1
			),
			"std"   => 1,
			"description" => __('Show or hide degree dropdown of this search.', "eduonline")
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
