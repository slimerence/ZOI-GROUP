<?php
	
    $course = LP()->global['course'];
	
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	
	$show_add_to_cart = (int) isset( $show_add_to_cart ) ? $show_add_to_cart : $jws_theme_options['jws_theme_archive_show_add_to_cart_course'];
			
	$show_title = (int) isset( $show_title ) ? $show_title : $jws_theme_options['jws_theme_archive_show_title_course'];
	
	$show_excerpt = (int) isset( $show_excerpt ) ? $show_excerpt : $jws_theme_options['jws_theme_archive_show_excerpt_course'];

	$excerpt_length = (int) isset( $excerpt_length ) ? $excerpt_length : $jws_theme_options['jws_theme_archive_excerpt_lenght'];
	
	$excerpt_more = (int) isset( $excerpt_more ) ? $excerpt_more : $jws_theme_options['jws_theme_archive_excerpt_more'];
	
	$show_price = (int) isset( $show_price ) ? $show_price : $jws_theme_options['jws_theme_archive_show_price_course'];
	
	$show_date = (int) isset( $show_date ) ? $show_date : $jws_theme_options['jws_theme_archive_show_date_course'];
	
	$show_lession = (int) isset( $show_lession ) ? $show_lession : $jws_theme_options['jws_theme_archive_show_lession'];
	
	$show_duration_time = (int) isset( $show_duration_time ) ? $show_duration_time : $jws_theme_options['jws_theme_archive_show_duration_time'];
		
	$image_default = isset($jws_theme_options['tb_blog_image_default']) ? $jws_theme_options['tb_blog_image_default'] : '';

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if (has_post_thumbnail() || $image_default) { ?>
        <div class="tb-blog-image">
            <?php
			$image_full = '';
			if(has_post_thumbnail()){
				the_post_thumbnail('course_thumbnail');
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
			?>
        </div>
    <?php } ?>
	<div class="tb-blog-content">

		<div class="tb-info-block">
			
			<?php
			//echo jws_theme_post_cate();
								
			if($show_title) echo jws_theme_title_render(); 
			if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>';?>
			<ul class="tb-course-meta list-inline">
			<?php $date_start = esc_attr( get_post_meta(get_the_ID(), '_lp_date_start', true) ); ?>

			<?php if($show_date && $date_start) { ?>
				<li>
					<i class="fa fa-calendar"></i>
					<p class="tb-date">
						
						<span><?php if(! is_archive())echo _e('Starting from','eduonline');?></span>
						<?php echo date('M, d Y', strtotime($date_start)); ?>
					</p>
				</li>
			<?php }?>
			<?php if($show_lession) { ?>
				<li>
					<i class="fa fa-book"></i><?php
					$items = $course->get_curriculum_items( array( 'group' => true ) );
					$count_lessons  = sizeof( $items['lessons'] );
					if ( $count_lessons ) {
						echo __($count_lessons.' lessons','eduonline');
					} else {
						echo __( "0 lesson", 'eduonline' );
					}
					?>
				</li>
			<?php }?>
			<?php $duration_time = esc_attr( get_post_meta(get_the_ID(), '_lp_duration', true) );  
			if( $show_duration_time && $duration_time ) { ?>
				<li>
					<i class="fa fa-hourglass-o"></i>
					<?php 
						echo $duration_time.'(s)';
					?>
				</li>
			<?php }?>
			</ul>
			
		</div>
		<div class="tb-price-cart">
			<?php if ($show_price && ($price_html = $course->get_price_html())) : ?>

				<span class="course-price"><?php echo $price_html; ?></span>
				<?php 
				if ( $course->get_origin_price() != $course->get_price() ) {
					$origin_price_html = $course->get_origin_price_html();
					?>
				<span class="course-origin-price"><?php echo $origin_price_html; ?></span>
					<?php
				}
				?>
			<?php endif; ?>
			<?php do_action( 'learningonline_button_buy_courser' ); ?>
		</div>
	</div>
	<div class="tb-price-cart">
			
		<?php do_action( 'learning_online_button_buy_courser' ); ?>
	</div>
	<div style="clear: both"></div>
</article>
