<?php
function ro_brand_logo_func($atts) {
    extract(shortcode_atts(array(
        'logo' => '',
        'logo_active' => '',
        'logo_url' => '#',
        'el_class' => ''
    ), $atts));

    $class = array();
    $class[] = 'ro-brand-logo-wrap';
    $class[] = $el_class;
	
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<a href="<?php echo esc_url($logo_url); ?>">
				<div class="ro-brand-logo">
					<?php echo wp_get_attachment_image( $logo, 'full' ); ?>
					<?php echo wp_get_attachment_image( $logo_active, 'full' ); ?>
				</div>
			</a>
		</div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('brand_logo', 'ro_brand_logo_func'); }
