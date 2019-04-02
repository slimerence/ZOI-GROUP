<?php
function jws_theme_logo_func($atts) {
    $el_align =$animation = '';
    $class = array('tb-logo tb-custom-logo');
    extract(shortcode_atts(array(
        'el_align' => 'text-center',
        'color' => '',
        'font_size' => '',
        'animation' => '',
        'image_logo' => '',
        'el_class' => ''
    ), $atts));

   $class[] = $el_align;
   $class[] = $el_class;
   $class[] = getCSSAnimation($animation);
   $logo = '';
   if( !empty( $image_logo ) ){
      $logo = wp_get_attachment_image_src($image_logo, 'full');
      if( $logo ){
        $logo = $logo[0];
      }
   }
   ob_start();
   ?>
   <div class="<?php echo esc_attr( implode( ' ', $class ) );?>">
        <a href="<?php echo esc_url(home_url()); ?>" style="color:<?php echo esc_attr( $color );?>;font-size:<?php echo esc_attr( $font_size );?>">
            <?php jws_theme_theme_logo( $logo ); ?>
        </a>
    </div>
    <?php
    return ob_get_clean();
}

if(function_exists('insert_shortcode')) { insert_shortcode('logo', 'jws_theme_logo_func'); }
