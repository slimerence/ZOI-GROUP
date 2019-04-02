<?php
function jws_theme_theme_video($params, $content = null){
	extract(shortcode_atts(array(
		'desc' => '',
		'sub_desc' =>'',
		'video_link' =>'',
		'height' => 200,
		'width' => '100%',
		'el_class' =>'',
	), $params));

	$class = array();
    $class[] = 'jws_video_featured';
    $class[] = $el_class;
	wp_enqueue_script('fitvids', JWS_THEME_URI_PATH_FR . "/shortcodes/video/fitvids.js");
	
	$video = parse_url($content);
	ob_start();
    ?>
		<div class="text-center <?php echo esc_attr(implode(' ', $class)); ?>">
			<?php 
			if( ! empty( $desc ) ) echo '<h3 class="jws-video-desc">'.$desc .'</h3>';
			if( ! empty( $sub_desc ) ) echo '<h4 class="jws-video-sub-desc">'.$sub_desc .'</h4>';
			if(! empty( $video_link )){ 
				echo '<a class="video-featured-popup"  data-toggle="tooltip" data-placement="top" title="'. __("View video","eduonline") .'" href="'. esc_url($video_link) .'"><span class="fa fa-play"></span></a>';
			}
			?>
		</div>
			
	<?php
	 return ob_get_clean();

}

if(function_exists('insert_shortcode')) { insert_shortcode('tb-video', 'jws_theme_theme_video'); }
