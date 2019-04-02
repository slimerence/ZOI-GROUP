<?php
function jws_theme_learn_step_func($atts, $content = null) {
    extract(shortcode_atts(array(
		'step' => '1',
        'title1' => '',
        'desc1' => '',
        'title2' => '',
        'desc2' => '',
        'title3' => '',
        'desc3' => '',
        'title4' => '',
        'desc4' => '',
        'title5' => '',
        'desc5' => '',
        'title6' => '',
        'desc6' => '',
        'el_class' => ''
    ), $atts));
	
	
    $titles = $decs = $class = array();
	$class[] = 'tb-learn_step-child';
	//$class[] = $tpl;
	$class[] = $el_class;
	if($title1){ $titles[] = $title1; $decs[] = $desc1;}
	if($title2){ $titles[] = $title2; $decs[] = $desc2;}
	if($title3){ $titles[] = $title3; $decs[] = $desc3;}
	if($title4){ $titles[] = $title4; $decs[] = $desc4;}
	if($title5){ $titles[] = $title5; $decs[] = $desc5;}
	if($title6){ $titles[] = $title6; $decs[] = $desc6;}
    ob_start();
    ?>
		<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
			<?php
			
				echo '<div class="tb-step-register"><div class="row">';
				
				$n = (sizeof($titles) > sizeof($decs)) ? sizeof($decs) : sizeof($decs);
				$column = ($n == 5) ? 'col-20' : 'col-md-'. 12/$n .'';
				for( $i = 0; $i < $n; $i++) {
				?>
					<div class="col-sm-6 <?php echo esc_attr($column); ?>">
						<div class="tb-step-item">
							<span><?php echo '0'.($i + 1);?></span>
							<h4><?php echo $titles[$i];?></h4>
							<p class="desc"><?php echo $decs[$i];?></p>
						</div>
					</div>
				<?php
				}
				echo '</div></div>';
				
			?>
			
		</div>
		<div class="clear"></div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('step_register', 'jws_theme_learn_step_func');}
