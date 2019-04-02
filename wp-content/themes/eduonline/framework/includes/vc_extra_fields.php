<?php

/*

 * Taxonomy checkbox list field

 */

function jws_theme_taxonomy_settings_field($settings, $value) {

    $terms_fields = array();

    $value_arr = $value;



    if (!is_array($value_arr)) {

        $value_arr = array_map('trim', explode(',', $value_arr));

    }



    if (!empty($settings['taxonomy'])) {

        $terms = get_terms($settings['taxonomy'], 'orderby=count&hide_empty=0');



        if ($terms && !is_wp_error($terms)) {

            foreach ($terms as $term) {

                $terms_fields[] = sprintf(

                        '<label><input onclick="changeCategory(this);" id="%s" class="tb-check-taxonomy %s" type="checkbox" name="%s" value="%s" %s/>%s</label>', $settings['param_name'] . '-' . $term->slug, $settings['param_name'] . ' ' . $settings['type'], $settings['param_name'], $term->term_id, checked(in_array($term->term_id, $value_arr), true, false), $term->name

                );

            }

        }

    }



    return '<div class="tb-taxonomy-block">'

            . '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-checkboxes ' . $settings['param_name'] . ' ' . $settings['type'] . '_field" value="' . $value . '" />'

            . '<div class="tb-taxonomy-terms">'

            . implode($terms_fields)

            . '</div>'

            . '</div>';

}

vc_add_extra_field('jws_theme_taxonomy', 'jws_theme_taxonomy_settings_field');



/*

 * Hidden field

 */



function jws_theme_hidden_settings_field($settings, $value){

   return '<div class="jws_theme_hidden_block">'

             .'<input name="'.$settings['param_name']

             .'" class="wpb_vc_param_value wpb-textinput '

             .$settings['param_name'].' '.$settings['type'].'_field" type="hidden" value="'

             .$value.'"/>'

         .'</div>';

}

vc_add_extra_field('jws_theme_hidden', 'jws_theme_hidden_settings_field');




function vc_jws_taxonomy_settings_field($settings, $value) {
    $dependency = '';

    $value_arr = $value;
    if ( ! is_array($value_arr) ) {
        $value_arr = array_map( 'trim', explode(',', $value_arr) );
    }
    $output = '';
    if( isset( $settings['hide_empty'] ) && $settings['hide_empty'] ){
        $settings['hide_empty'] = 1;
    }else{
        $settings['hide_empty'] = 0;
    }
    if ( ! empty($settings['taxonomy']) ) {
        
        $terms_fields = array();
        if(isset($settings['placeholder']) && $settings['placeholder']){
            $terms_fields[] = "<option value=''>".$settings['placeholder']."</option>";
        }
        
        $terms = get_terms( $settings['taxonomy'] , array('hide_empty' => false, 'parent' => $settings['parent'], 'hide_empty' => $settings['hide_empty'] ));
        if ( $terms && !is_wp_error($terms) ) {
            foreach( $terms as $term ) {
                $selected = (in_array( $term->slug, $value_arr )) ? ' selected="selected"' : '';
                $terms_fields[] = "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
            }
        }
        $size = (!empty($settings['size'])) ? 'size="'.$settings['size'].'"' : '';
        $multiple = (!empty($settings['multiple'])) ? 'multiple="multiple"' : '';
        
        $uniqeID    = uniqid();
        
        $output = '<select id="jws_taxonomy-'.$uniqeID.'" '.$multiple.' '.$size.' name="'.$settings['param_name'].'" class="wpb_vc_param_value wpb-input wpb-select '.$settings['param_name'].' '.$settings['type'].'_field" '.$dependency.'>'
                    .implode( $terms_fields )
                .'</select>';
        $output .= '<style>.select2-container{width:100% !important;z-index:99999;}.select2-drop{z-index:999999 !important;}</style>';
        $output .= '<script type="text/javascript">jQuery("#jws_taxonomy-' . $uniqeID . '").select2();</script>';

    }
    
    return $output;
}

vc_add_extra_field( 'jws_theme_taxonomy_slug', 'vc_jws_taxonomy_settings_field');