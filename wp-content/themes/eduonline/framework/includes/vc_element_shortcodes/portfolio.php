<?php

vc_map ( array (

		"name" => 'Portfolio',

		"base" => "portfolio",

		"icon" => "tb-icon-for-vc",

		"category" => __( 'Eduonline', 'eduonline' ), 

		'admin_enqueue_js' => array(JWS_THEME_URI_PATH_FR .'/admin/assets/js/customvc.js'),

		"params" => array (

					array(
						"type" => "textfield",
						
						"class" => "",
						
						"heading" => __("Post Count", "eduonline"),
						
						"param_name" => "posts_per_page",
						
						"value" => "",
						
						"description" => __('Please, enter number of post per page for blog. Show all: -1.', "eduonline")
					),
					array(

						"type" => "checkbox",

						"class" => "",

						"heading" => __("Show Filter", 'eduonline'),

						"param_name" => "show_filter",

						"value" => array (

							__( "Yes, please", 'eduonline' ) => true

						),
						"std" => true,


						"description" => __("Show or not show filter in this element.", 'eduonline')

					),

					array(

						"type" => "checkbox",

						"class" => "",

						"heading" => __("Show Number Item", 'eduonline'),

						"param_name" => "show_count",

						"value" => array (

							__( "Yes, please", 'eduonline' ) => true

						),
						"std" => false,


						"description" => __("Show or not number items in this element.", 'eduonline')

					),
					
					array (

						"type" => "dropdown",

						"heading" => __( 'Order by', 'eduonline' ),

						"param_name" => "orderby",

						"value" => array (

								__("None",'eduonline') => "none",

								__("Title",'eduonline') => "title",

								__("Date",'eduonline') => "date",

								__("ID",'eduonline') => "ID"

						),

						"description" => __( 'Order by ("none", "title", "date", "ID").', 'eduonline' )

					),

					array (

							"type" => "dropdown",

							"heading" => __( 'Order', 'eduonline' ),

							"param_name" => "order",

							"value" => Array (

									__("None",'eduonline') => "none",

									__("ASC",'eduonline') => "ASC",

									__("DESC",'eduonline') => "DESC"

							),

							"description" => __( 'Order ("None", "Asc", "Desc").', 'eduonline' )

					),

					array(

						"type" => "textfield",

						"class" => "",

						"heading" => __("Extra Class", 'eduonline'),

						"param_name" => "el_class",

						"value" => "",

						"description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", 'eduonline' )

					),
					array(

						"type" => "textfield",

						"class" => "",

						"heading" => __("View All", 'eduonline'),

						"param_name" => "viewall",

						"value" => "",

						"description" => __( "Enter View all name, default: VIEW ALL, leave blank for hidden this button", 'eduonline' )
					),
					array(

						"type" => "textfield",

						"class" => "",

						"heading" => __("View More", 'eduonline'),

						"param_name" => "viewmore",

						"value" => "",

						"description" => __( "Enter View more name, default: VIEW MORE, leave blank for hidden this button", 'eduonline' )
					)
					
	

		)

));