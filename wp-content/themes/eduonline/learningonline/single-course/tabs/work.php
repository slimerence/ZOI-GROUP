<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/4/8
 * Time: 11:44
 */

$content=apply_filters('the_content', get_post_field('post_content', 1238));


echo $content;

