<?php

vc_map(array(

	"name" => __("Register Form", 'eduonline'),

	"base" => "register_form",

	"category" => __('Eduonline', 'eduonline'),

	"icon" => "tb-icon-for-vc",

	"params" => array(

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

