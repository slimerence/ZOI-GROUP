<?php
function jws_theme_title_func($atts, $content = null) {
    extract(shortcode_atts(array(
        'title' => '',
		'tpl' => 'tpl',
        'title_align' => 'text-center',
		'icon'    =>'',
        'el_class' => ''
    ), $atts));
	
	
    $class[] = '';
    $class[] = $tpl;
    $title = wp_kses_post( $title );
		ob_start();
		$class[] = "jws-heading";
		$class[] = $title_align;
		?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<h4><?php echo $title;?></h4>
			<?php if( ! empty( $icon ) ){ ?>
			<div class="tb-icon">
				<?php echo wp_get_attachment_image( $icon, 'full', false, array('class'=>'img-responsive') );?>
			</div>
			<?php } ?>
		</div>
		<?php
	
	return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('title', 'jws_theme_title_func'); }
