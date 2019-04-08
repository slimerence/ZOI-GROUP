<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 11:44
 */

$post = get_post(1238);

$content = $post->post_content;
$output =  do_shortcode($post['post_content']);
var_dump($output);

echo $output;