<?php
//Add extra params vc_row
vc_add_param ( "vc_row", array (
		"type" 			=> "textfield",
		"class" 		=> "",
		"heading" 		=> __( "Id Section", 'eduonline' ),
		"param_name" 	=> "id_section",
		"value" 		=> "",
		"description" 	=> __( "Please, Enter row id section.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Type", 'eduonline' ),
		"admin_label" 	=> true,
		"param_name" 	=> "type",
		"value" 		=> array (
							"Default" => "default",
							"Background Video" => "custom-bg-video"
						),
		"description" 	=> __( "Select type of this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "colorpicker",
		"class" 		=> "",
		"heading" 		=> __( "Text Color", 'eduonline' ),
		"param_name" 	=> "text_color",
		"value" 		=> "",
		"description" 	=> __( "Select color for content in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "colorpicker",
		"class" 		=> "",
		"heading" 		=> __( "Heading Color", 'eduonline' ),
		"param_name" 	=> "heading_color",
		"value" 		=> "",
		"description" 	=> __( "Select color for all heading in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "colorpicker",
		"class" 		=> "",
		"heading" 		=> __( "Link Color", 'eduonline' ),
		"param_name" 	=> "link_color",
		"value" 		=> "",
		"description" 	=> __( "Select color for all link in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "colorpicker",
		"class" 		=> "",
		"heading" 		=> __( "Link Color Hover", 'eduonline' ),
		"param_name" 	=> "link_color_hover",
		"value" 		=> "",
		"description" 	=> __( "Select color for all link hover in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Text Align", 'eduonline' ),
		"param_name" 	=> "text_align",
		"value" 		=> array (
							"No" => "text-align-none",
							"Left" => "text-left",
							"Right" => "text-right",
							"Center" => "text-center"
						),
		"description" 	=> __( "Select text align for all columns in this row.", 'eduonline' )
) );
vc_add_param ( 'vc_row', array (
		'type' 			=> 'checkbox',
		'heading' 		=> __("Text Middle", 'eduonline'),
		'param_name' 	=> 'text_middle',
		"value" 		=> array (
							__( "Yes, please", 'eduonline' )  => 1
						),
		'description' 	=> __("Set text middle for all columns in this row.", 'eduonline')
) );
vc_add_param ( 'vc_row', array (
		'type' 			=> 'checkbox',
		'heading' 		=> __("Content Full Width", 'eduonline'),
		'param_name' 	=> 'content_full_width',
		"value" 		=> array (
							__( "Yes, please", 'eduonline' )  => 1
						),
		'description' 	=> __("Set content full width of this row.", 'eduonline')
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "checkbox",
		"class" 		=> "",
		"heading" 		=> __( "Same Height", 'eduonline' ),
		"param_name" 	=> "same_height",
		"value" 		=> array (
							__( "Yes, please", 'eduonline' )  => 1
						),
		"description" 	=> __( "Set the same height for all column in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Effect", 'eduonline' ),
		"param_name" 	=> "animation",
		"value" 		=> array(
							"No" => "animation-none",
							"Top to bottom" => "top-to-bottom",
							"Bottom to top" => "bottom-to-top",
							"Left to right" => "left-to-right",
							"Right to left" => "right-to-left",
							"Appear from center" => "appear"
						),
		"description" 	=> __( "Select effect in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "checkbox",
		"class" 		=> "",
		"heading" 		=> __( "Enable parallax", 'eduonline' ),
		"param_name" 	=> "enable_parallax",
		"value" 		=> array (
							__( "Yes, please", 'eduonline' )  => 1,
						),
		"description" 	=> __( "Enable parallax effect in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "textfield",
		"class" 		=> "",
		"heading" 		=> __( "Parallax speed", 'eduonline' ),
		"param_name" 	=> "parallax_speed",
		"value" 		=> "0.5",
		"description" 	=> __( "Please, Enter parallax speed in this row.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Enable Overlay", 'eduonline' ),
		"param_name" 	=> "enable_overlay",
		"value" 		=> array (
							__( "No", 'eduonline' ) => 'false',
							__( "Yes, please", 'eduonline' ) => 'true',
						),
		"description" 	=> __( "Enable overlay on background.", 'eduonline' )
) );
vc_add_param ( "vc_row", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" 		=> __( "Overlay Background Color", 'eduonline' ),
		"param_name" => "background_overlay",
		"value" => "",
		"dependency" => array (
				"element" => "enable_overlay",
				"value" => array('true')
		)
) );

vc_add_param ( "vc_row", array (
		"type" => "attach_image",
		"class" => "",
		"heading" => __( "Video poster", 'eduonline' ),
		"param_name" => "poster",
		"value" => "",
		"dependency" => array (
				"element" => "type",
				"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" => "checkbox",
		"class" => "",
		"heading" => __( "Loop", 'eduonline' ),
		"param_name" => "loop",
		"value" => array (
				__( "Yes, please", 'eduonline' )  => true,
		),
		"dependency" => array (
			"element" => "type",
			"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" => "checkbox",
		"class" => "",
		"heading" => __( "Autoplay", 'eduonline' ),
		"param_name" => "autoplay",
		"value" => array (
				__( "Yes, please", 'eduonline' )  => true,
		),
		"dependency" => array (
			"element" => "type",
			"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" => "checkbox",
		"class" => "",
		"heading" => __( "Muted", 'eduonline' ),
		"param_name" => "muted",
		"value" => array (
				__( "Yes, please", 'eduonline' )  => true,
		),
		"dependency" => array (
			"element" => "type",
			"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" => "checkbox",
		"class" => "",
		"heading" => __( "Controls", 'eduonline' ),
		"param_name" => "controls",
		"value" => array (
				__( "Yes, please", 'eduonline' )  => true,
		),
		"dependency" => array (
			"element" => "type",
			"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" => "checkbox",
		"class" => "",
		"heading" => __( "Show Button Play", 'eduonline' ),
		"param_name" => "show_btn",
		"value" => array (
				__( "Yes, please", 'eduonline' )  => true,
		),
		"dependency" => array (
			"element" => "type",
			"value" => array('custom-bg-video')
		)
) );
vc_add_param ( "vc_row", array (
		"type" 			=> "textfield",
		"class" 		=> "",
		"heading" 		=> __( "Video background (mp4)", 'eduonline' ),
		"param_name" 	=> "bg_video_src_mp4",
		"value" 		=> "",
		"dependency" 	=> array (
							"element" 	=> "type",
							"value" 	=> array('custom-bg-video')
						),
		"description" 	=> __( "Please, Enter url video (mp4) for background in this row.", 'eduonline' )
) );

vc_add_param ( "vc_row", array (
		"type" 			=> "textfield",
		"class" 		=> "",
		"heading" 		=> __( "Video background (ogv)", 'eduonline' ),
		"param_name" 	=> "bg_video_src_ogv",
		"value" 		=> "",
		"dependency" 	=> array (
							"element" 	=> "type",
							"value" 	=> array('custom-bg-video')
						),
		"description" 	=> __( "Please, Enter url video (ogv) for background in this row.", 'eduonline' )
) );

vc_add_param ( "vc_row", array (
		"type" 			=> "textfield",
		"class" 		=> "",
		"heading" 		=> __( "Video background (webm)", 'eduonline' ),
		"param_name" 	=> "bg_video_src_webm",
		"value" 		=> "",
		"dependency" 	=> array (
							"element" 	=> "type",
							"value" 	=> array('custom-bg-video')
						),
		"description" 	=> __( "Please, Enter url video (webm) for background in this row.", 'eduonline' )
) );
vc_remove_param( "vc_row", "full_width" );
//Add extra params vc_column
vc_add_param ( "vc_column", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Effect", 'eduonline' ),
		"param_name" 	=> "animation",
		"value" 		=> array(
							"No" => "animation-none",
							"Top to bottom" => "top-to-bottom",
							"Bottom to top" => "bottom-to-top",
							"Left to right" => "left-to-right",
							"Right to left" => "right-to-left",
							"Appear from center" => "appear"
						),
		"description" 	=> __( "Select effect in this column.", 'eduonline' )
) );
vc_add_param ( "vc_column", array (
		"type" 			=> "dropdown",
		"class" 		=> "",
		"heading" 		=> __( "Text Align", 'eduonline' ),
		"param_name" 	=> "text_align",
		"value" 		=> array (
							"No" => "text-align-none",
							"Left" => "text-left",
							"Right" => "text-right",
							"Center" => "text-center"
						),
		"description" 	=> __( "Select text align in this column.", 'eduonline' )
) );
//Add extra params vc_tabs
vc_add_param ( "vc_tabs", array (
		"type" => "textfield",
		"class" => "",
		"heading" => __( "Active tab", 'eduonline' ),
		"param_name" => "active_tab",
		"value" => "",
		"description" => __( "Enter section number to be active on load or enter false to collapse all sections..", 'eduonline' )
) );
//Add extra params vc_tab
vc_add_param ( "vc_tab", array (
		"type" => "textfield",
		"class" => "",
		"heading" => __( "Icon", 'eduonline' ),
		"param_name" => "icon",
		"value" => "",
		"description" => __( "Icon class.", 'eduonline' )
) );
//Add extra params vc_accordion_tab
vc_add_param ( "vc_accordion_tab", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" => __( "Background Title", 'eduonline' ),
		"param_name" => "background",
		"value" => "",
		"description" => __( "Background color of title.", 'eduonline' )
) );
vc_add_param ( "vc_accordion_tab", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" => __( "Background Title Active", 'eduonline' ),
		"param_name" => "background_active",
		"value" => "",
		"description" => __( "Background color of title active.", 'eduonline' )
) );
vc_add_param ( "vc_accordion_tab", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" => __( "Border Title", 'eduonline' ),
		"param_name" => "border",
		"value" => "",
		"description" => __( "Border color of title.", 'eduonline' )
) );
vc_add_param ( "vc_accordion_tab", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" => __( "Color Title", 'eduonline' ),
		"param_name" => "color",
		"value" => "",
		"description" => __( "Color of title.", 'eduonline' )
) );
vc_add_param ( "vc_accordion_tab", array (
		"type" => "colorpicker",
		"class" => "",
		"heading" => __( "Background Content", 'eduonline' ),
		"param_name" => "background_content",
		"value" => "",
		"description" => __( "Background color of Content.", 'eduonline' )
) );