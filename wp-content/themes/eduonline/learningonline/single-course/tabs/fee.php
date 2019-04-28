<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 11:44
 */

$course = learning_online_get_the_course();

if($course->id == 665){
    $post = get_post(1728);
}else{
    $post = get_post(1386);
}
$content = $post->post_content;
echo do_shortcode($content);