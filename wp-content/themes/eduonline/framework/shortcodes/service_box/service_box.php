<?php
function jws_theme_service_box_func($atts, $content = null) {
    extract(shortcode_atts(array(
		'icon' => '',
		'title' => '',
		'a_title' => '',
		'b_title' => '',
		'text_button' => '',
		'color'  =>'',
        'ex_link' => '',
        'el_align' => 'text-center',
        'tpl' => 'tpl',
        'el_class' => ''
    ), $atts));

	$content = wpb_js_remove_wpautop($content, true);
	
    $class = $child_class = array();
	$class[] = 'tb-service-wrap';
	$class[] = $el_class;
	$child_class[] = $el_align;
	$child_class[] = $tpl;
	if($tpl == 'tpl4') $child_class[] = 'tpl';
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		
			<?php if( $tpl == 'tpl1' || $tpl == 'tpl2'):
				wp_enqueue_script('waypoints', JWS_THEME_URI_PATH . '/assets/js/waypoints.min.js',array(),"1");
				wp_enqueue_script('counterup', JWS_THEME_URI_PATH . '/assets/js/jquery.counterup.min.js',array(),"1");
				$child_class[] = 'tb-counter';
			?>
				<div class="tb-service <?php echo esc_attr(implode(' ', $child_class)); ?>">
					<?php
						$max = intval( $title );
						if( ! empty( $title ) )?>
						<h3 class="tb-title">
							<?php if( ! empty( $b_title ) ) echo '<span class="text">'. $b_title .'</span>';?>
							<span class="counter"> <?php echo number_format($max); ?></span>
							
							<?php  if( ! empty( $a_title ) ) echo '<span class="text">'. $a_title .'</span>'; ?>
						</h3>
						<?php 
						if( ! empty( $content ) ) echo '<div class="tb-content">'. $content .'</div>';
						if( ! empty( $text_button ) ){ ?> 
							<a class="" href="<?php echo esc_url($ex_link); ?>"><?php echo esc_attr($text_button); ?></a>
						<?php }
					?>
				</div>
			
			<?php elseif( $tpl == 'tpl3'): ?>
		
				<div class="tb-service <?php echo esc_attr(implode(' ', $child_class)); ?>">
					
						<h3 class="tb-title">
							<?php if( ! empty( $b_title ) ) echo '<span class="text1">'. $b_title .'</span>';?>
							<?php if( ! empty( $title ) ) {?><span class="tb-counter"> <?php echo $title; ?></span><?php } if( ! empty( $a_title ) ) echo '<span class="text2">'. $a_title .'</span>'; ?>
						</h3>
						<?php
						if( ! empty( $content ) ) echo '<div class="tb-content">'. $content .'</div>';
						if( ! empty( $text_button ) ){ ?> 
							<a class="" href="<?php echo esc_url($ex_link); ?>"><?php echo esc_attr($text_button); ?></a>
						<?php }
					?>
				</div>
			<?php else: ?>
			
				<div class="tb-service <?php echo esc_attr(implode(' ', $child_class)); ?>">
					<?php

						if( ! empty( $icon ) ){ ?>
						<div class="tb-icon" <?php echo 'style ="color:'. esc_attr($color).'"';?> >
							<?php echo '<i class="'. esc_attr($icon) .'"></i>'; ?>
						</div>
						<?php }?>
						<div class="tb-left"><?php
						if( ! empty( $title ) ) echo '<h3 class="tb-title" style ="color:'. esc_attr($color).'">'.esc_html($title).'</h3><span class="line-bottom" style ="background-color:'. esc_attr($color).'"></span>';
						if( ! empty( $content ) ) echo '<div class="tb-content">'.$content.'</div>';
						?>
						</div>
				</div>
			<?php endif; ?>
		</div>
		
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('service_box', 'jws_theme_service_box_func');}
