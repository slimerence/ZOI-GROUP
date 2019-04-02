<?php
global $tb_options;

$course = LP()->global['course'];

$image_default = isset($tb_options['tb_blog_image_default']) ? $tb_options['tb_blog_image_default'] : '';
?>
<article <?php post_class(); ?>>
    <?php if (has_post_thumbnail() || $image_default) { ?>
        <div class="tb-blog-image">
            <?php
			$image_full = '';
			if(has_post_thumbnail()){
				the_post_thumbnail('eduonline-course-overlay');
			}else{
				if($image_default['url']){
					$image_full = $image_default['url'];
					if($tb_blog_crop_image){
						$image_resize = matthewruddy_image_resize( $image_default['url'], $width_image, $height_image, true, false );
						echo '<img style="width:100%;" class="bt-image-cropped" src="'. esc_attr($image_resize['url']) .'" alt="">';
					}else{
						echo '<img alt="Image-Default" class="attachment-thumbnail wp-post-image" src="'. esc_attr($image_default['url']) .'">';
					}
				}
			}
			if($show_date && $post_format =='free'){
			
				echo jws_theme_date_course();
			}
			?>
			
        </div>
    <?php } ?>
	<div class="tb_blog_content tb-blog-standard">

		<div class="tb-info-block">
			
			<?php
			//echo jws_theme_post_cate();
			if($show_lession){
				echo '<div class="tb-lesson">';
					$items = $course->get_curriculum_items( array( 'group' => true ) );
					$count_lessons  = sizeof( $items['lessons'] );
					if ( $count_lessons ) {
						echo __($count_lessons.' lessons','eduonline');
					} else {
						echo __( "0 lesson", 'eduonline' );
					}
				echo '</div>';
			}
			if($show_title) echo jws_theme_title_render(); 
			if($show_date && $post_format != 'free') { ?>
				<p class="tb-date">
					<?php $date_start = esc_attr( get_post_meta(get_the_ID(), '_lp_date_start', true) ); ?>
					<span><?php echo _e('Starting from','eduonline');?></span>
					<?php echo date('M, d Y', strtotime($date_start)); ?>
				</p>
			<?php }
			//if($show_info) echo jws_theme_info_bar_render(); ?>
		</div>
		<?php if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
		<?php if($read_more) echo '<a href='. get_the_permalink().' class="tb-read-more">'. esc_attr($read_more_text).'</a>'; ?>
	</div>
</article>
