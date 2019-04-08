<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 11:45
 */

$post = get_post(1301);

$content = $post->post_content;
echo do_shortcode($content);
