<?php

add_action('init', 'tb_blog_integrateWithVC');

function tb_blog_integrateWithVC() {
    vc_map(array(
        "name" => __("Blog", "eduonline"),
        "base" => "tb_blog",
        "class" => "tb-blog",
        "category" => __('Eduonline', "eduonline"),
        'admin_enqueue_js' => array(
            JWS_THEME_URI_PATH_ADMIN.'/assets/js/customvc.js',
            JWS_THEME_URI_PATH_ADMIN.'/assets/js/select2/select2.min.js',
        ),
        'admin_enqueue_css'=>array(
            JWS_THEME_URI_PATH_ADMIN.'/assets/js/select2/select2.css',
        ),
        "icon" => "tb-icon-for-vc",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Post Type", "eduonline"),
                "param_name" => "post_type",
                "value" => array(
                    "Post" => "post",
                    "Course" => "lp_course",
                    "Event" => "event",
                ),
				"description" => __('Select post type for blog.', "eduonline")
            ),
            array (
                "type" => "jws_theme_taxonomy_slug",
                "taxonomy" => "category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"post"
                ),                
                "heading" => __ ( "Categories", "eduonline" ),
                "param_name" => "category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", "eduonline" )
            ),
            array (
                "type" => "jws_theme_taxonomy_slug",
                "taxonomy" => "course_category",
                'multiple'=>true,
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"lp_course"
                    ),                
                "heading" => __ ( "Categories", "eduonline" ),
                "param_name" => "course_category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", "eduonline" )
            ),
            array (
                "type" => "jws_theme_taxonomy_slug",
                "taxonomy" => "event_category",
                "dependency" => array(
                    "element"=>"post_type",
                    "value"=>"event"
                    ),
                "heading" => __ ( "Categories", "eduonline" ),
                "param_name" => "event_category",
                "class" => "",
                "description" => __ ( "Note: By default, all your projects will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed.", "eduonline" )
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Post format", "eduonline"),
                "param_name" => "post_format",
                "value" => array(
                    "Default" => "default",
                    "Video post" => "video",
                    "Free post" => "free"
                ),
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("lp_course"),
                ),
				"description" => __('Select a type post format.', "eduonline")
            ),
           array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Height video", "eduonline"),
                "param_name" => "h_video",
                "value" => "",
				"description" => __('Please, enter number of height video for blog.', "eduonline"),
				"dependency" => array(
                    "element" => "post_format",
                    "value" => "video",
                ),
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Post Style", "eduonline"),
                "param_name" => "grid_style",
                 "value" => array(
                    "Default" => "default",
                    "Grid ~ no-padding" => "no-padding"
                ),
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("lp_course"),
                ),
				 
				"description" => __('Select a type post format.', "eduonline")
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Template", "eduonline"),
                "param_name" => "event_style",
                 "value" => array(
                    "Default" => "entry",
                    "Listing" => "entry-listing",
                ),
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("event"),
                ),
				 
				"description" => __('Select a type post format.', "eduonline")
            ),
			array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Post Count", "eduonline"),
                "param_name" => "posts_per_page",
                "value" => "",
				"description" => __('Please, enter number of post per page for blog. Show all: -1.', "eduonline")
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
				 "dependency" => array(
                    "element"=>"post_type",
                    "value"=> array("lp_course","post"),
                    ),
				"description" => __('Select columns for blog.', "eduonline")
            ),
			
            array(
                "type" => "checkbox",
                "heading" => __('Show content', "eduonline"),
                "param_name" => "show_content",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"dependency" => array(
                    "element" => "post_format",
                    "value" => "video",
                ),
				'std' => 1,
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide content of post on your blog.', "eduonline")
            ),
			
            array(
                "type" => "checkbox",
                "heading" => __('Show Date', "eduonline"),
                "param_name" => "show_date",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"group" => __("Template", 'eduonline'),

                "description" => __('Show or hide date of post on your blog.', "eduonline")
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Title', "eduonline"),
                "param_name" => "show_title",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide title of post on your blog.', "eduonline")
            ),
			   array(
					"type" => "checkbox",
					"heading" => __('Show Lession', "eduonline"),
					"param_name" => "show_lession",
					"value" => array(
						__("Yes, please", "eduonline") => 1
					),
					"std"   => 1,
					"dependency" => array(
						"element" => "post_format",
						"value" => array("free"),
					),
					"group" => __("Template", 'eduonline'),
					"description" => __('Show or hide lession of post on your blog.', "eduonline")
				),
			array(
                "type" => "checkbox",
                "heading" => __('Show Info', "eduonline"),
                "param_name" => "show_info",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("post"),
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide info of post on your blog.', "eduonline")
            ),
			
            array(
                "type" => "checkbox",
                "heading" => __('Show Excerpt', "eduonline"),
                "param_name" => "show_excerpt",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
               
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide description of post on your blog.', "eduonline")
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt Length', "eduonline"),
                "param_name" => "excerpt_length",
                "value" => '',
               
				"group" => __("Template", 'eduonline'),
                "description" => __('The length of the excerpt, number of words to display. Set -1 show all words of excerpt.', "eduonline")
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt More', "eduonline"),
                "param_name" => "excerpt_more",
                "value" => "",
				"group" => __("Template", 'eduonline'),
				"description" => __('Please enter excerpt more for blog.', "eduonline")
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Read more', "eduonline"),
                "param_name" => "read_more",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std"   => 0,
                "dependency" => array(
                    "element" => "post_format",
                    "value" => array("free"),
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide read more of post on your blog.', "eduonline")
            ),
            array(
                "type" => "textfield",
                "heading" => __('Read More Text', "eduonline"),
                "param_name" => "read_more_text",
                "value" => "",
				"std" => "Read more",
                "dependency" => array(
                    "element" => "post_format",
                    "value" => array("free"),
                ),
				"group" => __("Template", 'eduonline'),
				"description" => __('Please enter read more text of this post.', "eduonline")
            ),
			
            array(
                "type" => "dropdown",
                "heading" => __('Order by', "eduonline"),
                "param_name" => "orderby",
                "value" => array(
                    "None" => "none",
                    "Title" => "title",
                    "Date" => "date",
                    "ID" => "ID"
                ),
                "description" => __('Order by ("none", "title", "date", "ID").', "eduonline")
            ),
            array(
                "type" => "dropdown",
                "heading" => __('Order', "eduonline"),
                "param_name" => "order",
                "value" => Array(
                    "None" => "none",
                    "ASC" => "ASC",
                    "DESC" => "DESC"
                ),
                "description" => __('Order ("None", "Asc", "Desc").', "eduonline")
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Pagination', "eduonline"),
                "param_name" => "show_pagination",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std"   => 0,
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide read more of post on your blog.', "eduonline")
            ),
			 array(
                "type" => "dropdown",
                "heading" => __('Position pagination', "eduonline"),
                "param_name" => "pos_pagination",
                "value" => Array(
                    "Text Center" => "text-center",
                    "Text Left" => "text-left",
                    "Text Right" => "text-right"
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Position pagination ("left", "center", "right").', "eduonline")
            ),
			array(
                "type" => "dropdown",
                "heading" => __('Object Animation', "eduonline"),
                "param_name" => "ob_animation",
                "value" => Array(
                    "Wrap" => "wrap",
                    "Item" => "item"
                ),
                "description" => __('Select object animation', "eduonline")
            ),
			array(
                "type" => "dropdown",
                "class" => "",
                "heading" => __("Animation", "eduonline"),
                "param_name" => "animation",
                "value" => array(
                    "No" => "",
                    "Top to bottom" => "top-to-bottom",
                    "Bottom to top" => "bottom-to-top",
                    "Left to right" => "left-to-right",
                    "Right to left" => "right-to-left",
                    "Appear from center" => "appear"
                ),
                "description" => __("Box Animation", "eduonline")
            ),
            array(
                "type" => "textfield",
                "class" => "",
                "heading" => __("Extra Class", "eduonline"),
                "param_name" => "el_class",
                "value" => "",
				"description" => __ ( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "eduonline" )
            ),
        )
    ));
}
