<?php
function ro_category_slider_func($atts, $content = null) {
	 extract(shortcode_atts(array(
		'tpl' => 'tpl1',
        'el_class' => '',
		'show_title' => 1,
		'number'   => -1,
		'columns'	=> 4,
		'show_number' => 1,
		'show_image' => 1,
		
    ), $atts));
			
    $class = array();
    $class[] = 'tb-category tb-blog-carousel';
	$class[] = 'tb-category-carousel'. intval( $columns );
    $class[] = $el_class;
    $class[] = $tpl;
	
    ob_start();
	
    ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<?php
			$argss = array(
				'number' => $number,
				'orderby'    => 'title',
				'order'      => 'ASC',
				'exclude'    => 1,//remove uncategory
				'hide_empty' => true,
			);
			$terms = get_terms( 'course_category', $argss );
			$count = count($terms);
			if($tpl == 'tpl1'){?>
			<div class="owl-carousel">
			<?php } $i = 0;
				foreach ($terms as $term) {
					if($i % 2 == 0 && $tpl == 'tpl1') echo '<div class="owl-carousel-item">';
					$i++;
				?>
					<div class="tb-category-item text-center">
						<div class="tb-category-detail">
							<?php if($show_image){
								$thumbnail_id = get_learningonline_term_meta($term->term_id, 'thumbnail_id', true);
								$image = wp_get_attachment_url($thumbnail_id);
								echo "<div class='tb-image'><img src='{$image}' alt='' /></div>";
							}?>
							<div class="tb-category-content">
								<?php if($show_title) echo '<a href="' . get_term_link($term->name, 'course_category') . '">' . $term->name . '</a>'; ?>
								<?php if($show_number) echo '<p class="get_count">'.$term->count.' '.__('courses','eduonline').'</p>'; ?>
							</div>
							
						</div>
					</div>
					
				<?php 
					if( ($i % 2 == 0 || $i == $count) && $tpl == 'tpl1' ) echo '</div>';
				} if($tpl == 'tpl1'){	?>
			</div>
			<?php } ?>
			<div style="clear: both"></div>
	</div>
    <?php
    return ob_get_clean();
}
if(function_exists('insert_shortcode')) { insert_shortcode('tb-category', 'ro_category_slider_func');}
