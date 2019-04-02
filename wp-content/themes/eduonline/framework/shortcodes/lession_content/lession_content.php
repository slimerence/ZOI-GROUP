<?php
function jws_theme_lession_content_func($atts, $content = null) {
    extract(shortcode_atts(array(
		'images' => '',
		'video'  => '',
		'title' => '',
        'el_align' => 'text-center',
        'el_class' => ''
    ), $atts));

	$content = wpb_js_remove_wpautop($content, true);
	
    $class = array();
	$class[] = 'lo-lession-content';
	$class[] = $el_class;
	$class[] = $el_align;

    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
				<div class="lo-video-intro">
					<?php if(! empty( $video )){ ?>
						<iframe width="836" height="470" src="<?php echo esc_url($video); ?>" frameborder="0" allowfullscreen=""></iframe>
					<?php } ?>
				</div>
				<div class="course-lesson-description">
					<?php
						if( ! empty( $title ) )?>
						<h4 class="tb-title">
							<?php if( ! empty( $title ) ) echo '<span class="text">'. $title .'</span>';?>
						</h4>
						<?php 
						if( ! empty( $content ) ) echo '<div class="tb-content">'. $content .'</div>';
						
					?>
				</div>
				<div class="lo-images">
					<ul class="list-inline">
					<?php 
						if( ! empty( $images ) ){
							$images = explode(",", $images);
						}
						foreach($images as $image) {?>
							<li>
								<div class="image-item">
									<?php echo wp_get_attachment_image($image, 'full'); ?>
								</div>
							</li>
						
						<?php } ?>
					</ul>
				</div>
			
		</div>
		
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('lession_content', 'jws_theme_lession_content_func');}
