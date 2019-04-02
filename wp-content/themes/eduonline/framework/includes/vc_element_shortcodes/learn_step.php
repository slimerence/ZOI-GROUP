<?php
vc_map(array(
	"name" => __("Steps Register", 'eduonline'),
	"base" => "step_register",
	"category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
	"params" => array(
		array(
			"type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Number step", "eduonline"),
                "param_name" => "step",
                "value" => array(
					__("1 step",'eduonline') => "1",
					__("2 step",'eduonline') => "2",
					__("3 step",'eduonline') => "3",
					__("4 step",'eduonline') => "4",
					__("5 step",'eduonline') => "5",
					__("6 step",'eduonline') => "6",
				),
				
			"description" => __('Steps for register to learn.', "eduonline")
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 1", 'eduonline'),
			"param_name" => "title1",
			"dependency" => array(
				"element"=>"step",
				"value"=> array("1","2","3","4","5","6"),
			),
			"description" => __("Step title 1.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 1", 'eduonline'),
			"param_name" => "desc1",
			"dependency" => array(
				"element"=>"step",
				"value"=> array("1","2","3","4","5","6"),
			),
			"description" => __("Step description 1.", 'eduonline')
		),
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 2", 'eduonline'),
			"param_name" => "title2",
			"std" =>"",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("2","3","4","5","6"),
			),
			"description" => __("Step title 2.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 2", 'eduonline'),
			"param_name" => "desc2",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("2","3","4","5","6"),
			),
			"description" => __("Step description 2.", 'eduonline')
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 3", 'eduonline'),
			"param_name" => "title3",
			"std" =>"",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("3","4","5","6"),
			),
			"description" => __("Step title 3.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 3", 'eduonline'),
			"param_name" => "desc3",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("3","4","5","6"),
			),
			"description" => __("Step description 3.", 'eduonline')
		),
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 4", 'eduonline'),
			"param_name" => "title4",
			"std" =>"",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("4","5","6"),
			),
			"description" => __("Step title 4.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 4", 'eduonline'),
			"param_name" => "desc4",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("4","5","6"),
			),
			"description" => __("Step description 4.", 'eduonline')
		),
		
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 5", 'eduonline'),
			"param_name" => "title5",
			"std" =>"",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("5","6"),
			),
			"description" => __("Step title 5.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 5", 'eduonline'),
			"param_name" => "desc5",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("5","6"),
			),
			"description" => __("Step description 5.", 'eduonline')
		),
		
		
		array(
			"type" => "textfield",
			"class" => "",
			"heading" => __("Title 6", 'eduonline'),
			"param_name" => "title6",
			"std" =>"",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("6"),
			),
			"description" => __("Step title 6.", 'eduonline')
		),
		array(
			"type" => "exploded_textarea",
			"class" => "",
			"heading" => __("Description 6", 'eduonline'),
			"param_name" => "desc6",
			'dependency' => array(
				'element'   => 'step',
				"value"=> array("6"),
			),
			"description" => __("Step description 6.", 'eduonline')
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
