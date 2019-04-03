<?php
/**
 * Template for displaying content of landing course
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php
	
    $course = LP()->global['course'];
	
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	
	$show_add_to_cart = (int) isset( $show_add_to_cart ) ? $show_add_to_cart : $jws_theme_options['jws_theme_single_show_add_to_cart_course'];
			
	$show_title = (int) isset( $show_title ) ? $show_title : $jws_theme_options['jws_theme_single_show_title_course'];
	
	$show_excerpt = (int) isset( $show_excerpt ) ? $show_excerpt : $jws_theme_options['jws_theme_single_show_excerpt_course'];
	
	$excerpt_lenght = (int) isset( $excerpt_lenght ) ? $excerpt_lenght : $jws_theme_options['jws_theme_single_excerpt_lenght'];
	
	$excerpt_more = (int) isset( $excerpt_more ) ? $excerpt_more : $jws_theme_options['jws_theme_single_excerpt_more'];
	
	$show_price = (int) isset( $show_price ) ? $show_price : $jws_theme_options['jws_theme_single_show_price_course'];
	
	$show_date = (int) isset( $show_date ) ? $show_date : $jws_theme_options['jws_theme_single_show_date_course'];
	
	$show_lession = (int) isset( $show_lession ) ? $show_lession : $jws_theme_options['jws_theme_single_show_lession'];
	
	$show_duration_time = (int) isset( $show_duration_time ) ? $show_duration_time : $jws_theme_options['jws_theme_single_show_duration_time'];
		
	$image_default = isset($jws_theme_options['tb_blog_image_default']) ? $jws_theme_options['tb_blog_image_default'] : '';

?>

<div class="course-landing-summary">
	<div class="tb-course-top">
		<div class="row">
			
			<div class="col-sm-6 col-md-4 col-lg-3">
				<div class="tb-course-image">
					<?php the_post_thumbnail( 'single_course' ); ?>
					
				</div>
			</div>
			<div class="col-sm6 col-md-8 col-lg-9">
				<div class="tb-course-content">
					
					<?php do_action( 'learning_online_courses_loop_single_item_title' ); 
										
					if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt( $excerpt_lenght ,$excerpt_more).'</div>';
					
					/*do_action( 'learning_online_single_course_students' ); */

					?>
										
					<ul class="tb-course-meta list-inline">
						<?php if($show_date) { ?>
							<li>
								<i class="fa fa-calendar"></i>
								<p class="tb-date">
									<?php $date_start = esc_attr( get_post_meta(get_the_ID(), '_lp_date_start', true) ); ?>
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
						<?php if($show_duration_time) { ?>
							<li>
								<i class="fa fa-hourglass-o"></i>
								<?php $duration_time = esc_attr( get_post_meta(get_the_ID(), '_lp_duration', true) ); 
									echo $duration_time.'(s)';
								?>
							</li>
						<?php }?>

					</ul>
					<div class="tb-pricce-cart">
						<?php if(false):; ?>
					        <?php do_action( 'learning_online_courses_loop_single_item_action' ); ?>
                        <?php endif ?>
                        <a href="/apply-now" class="button enroll-button">
                            <?php do_action( 'learning_online_before_enroll_button' ); ?>
                            <?php echo $enroll_button_text; ?>
                            <?php do_action( 'learning_online_after_enroll_button' ); ?>
                        </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php //do_action( 'learning_online_course_tabs' ); 
	do_action( 'learning_online_single_course_tabs' ); 
	 
	jws_theme_course_sharing();
	
	do_action( 'jws_theme_output_related_courses' ); 
	
	?>


</div>

