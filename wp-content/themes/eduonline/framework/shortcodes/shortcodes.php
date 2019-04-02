<?php
$elements = array(
	'video_post',
	'title',
	'blog',
	'blog_carousel',
	'search_course',
	'service_box',
	'learn_step',
	'category',
	'map_v3',
	'login_form',
	'register_form',
	'logo',
	'brand',
	'portfolio',
	'lession_content',
);

foreach ($elements as $element) {
	include($element .'/'. $element.'.php');
}

