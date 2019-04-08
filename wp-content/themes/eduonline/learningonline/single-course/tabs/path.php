<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 11:44
 */

$post = get_post(1374);

$content = $post->post_content;
echo do_shortcode($content);
