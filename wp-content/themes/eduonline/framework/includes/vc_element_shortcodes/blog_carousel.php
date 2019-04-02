<?php

add_action('init', 'tb_blog_carousel_integrateWithVC');

function tb_blog_carousel_integrateWithVC() {
    vc_map(array(
        "name" => __("Blog Carousel", "eduonline"),
        "base" => "tb_blog_carousel",
        "class" => "tb-blog-carousel",
        "category" => __('Eduonline', "eduonline"),
        'admin_enqueue_js' => array(JWS_THEME_URI_PATH_ADMIN.'/assets/js/customvc.js'),
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
                    "Couser" => "lp_course",
                ),
				"description" => __('Select post type for blog.', "eduonline")
            ),
            array (
                "type" => "jws_theme_taxonomy",
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
                "type" => "jws_theme_taxonomy",
                "taxonomy" => "course_category",
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
				"type" => "dropdown",
				"class" => "",
				"heading" => __( "Show", 'eduonline' ),
				"param_name" => "show",
				"value" => array (
						__("All Courses",'eduonline') => "all",
						__("Featured Courses",'eduonline') => "featured",
				),
				"dependency" => array(
                    "element"=>"post_type",
                    "value"=>"lp_course"
                ),
				"group" => __("Build Query", 'eduonline'),
				"description" => __( "Select show product type in this elment", 'eduonline' )
			),
			array(
                "type" => "textfield",
                "heading" => __('Tab active', "eduonline"),
                "param_name" => "tab_active",
                "std" => 1,
				"dependency" => array(
                    "element" => "post_type",
                    "value" => array("lp_course"),
                ),
				"description" => __('Please enter tab number active for blog.', "eduonline")
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
				 
				"description" => __('Select columns for blog.', "eduonline")
            ),
           
            array(
                "type" => "checkbox",
                "heading" => __('Show Date', "eduonline"),
                "param_name" => "show_date",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std" => 1,
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
				"std" => 1,
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide title of post on your blog.', "eduonline")
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Price', "eduonline"),
                "param_name" => "show_price",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std" => 1,
				"dependency" => array(
                    "element" => "show",
                    "value" => array("featured"),
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide price of post on your courses.', "eduonline")
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Lession', "eduonline"),
                "param_name" => "show_lession",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std" => 1,
				"dependency" => array(
                    "element" => "show",
                    "value" => array("featured"),
                ),
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide lession of post on your courses.', "eduonline")
            ),
			array(
                "type" => "checkbox",
                "heading" => __('Show Excerpt', "eduonline"),
                "param_name" => "show_excerpt",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
                
				'std' => 1,
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide description of post on your blog.', "eduonline")
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt Length', "eduonline"),
                "param_name" => "excerpt_length",
                "value" => '',
				'std' => 25,
				"group" => __("Template", 'eduonline'),
                "description" => __('The length of the excerpt, number of words to display. Set -1 show all words of excerpt.', "eduonline")
            ),
            array(
                "type" => "textfield",
                "heading" => __('Excerpt More', "eduonline"),
                "param_name" => "excerpt_more",
                "value" => "",
				'std' => '...',
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
				"std"   => 1,
                "dependency" => array(
                    "element" => "show",
                    "value" => array("featured"),
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
                    "element" => "show",
                    "value" => array("featured"),
                ),
				"group" => __("Template", 'eduonline'),
				"description" => __('Please enter read more text of this post.', "eduonline")
            ),
            array(
                "type" => "checkbox",
                "heading" => __('Show Categories', "eduonline"),
                "param_name" => "show_cate",
                "value" => array(
                    __("Yes, please", "eduonline") => 1
                ),
				"std" => 1,
				"group" => __("Template", 'eduonline'),
                "description" => __('Show or hide Categories of post on your blog.', "eduonline")
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
				"group" => __("Template", 'eduonline'),
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
				"group" => __("Template", 'eduonline'),
                "description" => __('Order ("None", "Asc", "Desc").', "eduonline")
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
