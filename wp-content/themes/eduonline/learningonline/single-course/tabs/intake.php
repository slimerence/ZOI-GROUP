<?php
/**
 * Created by PhpStorm.
 * User: Claude
 * Date: 2019/4/26
 * Time: 20:08
 */
$course = learning_online_get_the_course();

if($course->id == 665){
    $post = get_post(1693);
}else{
    $post = get_post(1693);
}
$content = $post->post_content;
echo do_shortcode($content);