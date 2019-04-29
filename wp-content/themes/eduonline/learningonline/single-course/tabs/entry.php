<?php
/**
 * Created by PhpStorm.
 * User: Claude
 * Date: 2019/4/26
 * Time: 20:08
 */

$post = get_post(1696);

$content = $post->post_content;
echo do_shortcode($content);