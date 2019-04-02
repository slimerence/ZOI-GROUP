<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
 
	$event_day = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_event_day', true) );
	$start = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_start_time', true) );
	$end = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_end_time', true) );
	$address = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_address', true) );
	$phone = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_phone', true) );
	
	wp_enqueue_script('jq.countdown.min', JWS_THEME_URI_PATH . '/assets/js/jquery.countdown.js');
	
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('same-height'); ?>>
	<div class="row">
		<div class="col-md-5">
			<div class="tb-event-image">
				<?php the_post_thumbnail( 'event-single-thumb' ); ?>
				
			</div>
		</div>
		<div class="col-md-7">
			<div class="tb-event-content">
				<?php echo jws_theme_title_render(); ?>
				<div class="tb-image-content">
					<div class="row">
						<div class="col-md-6">
							<ul>
								<li><i class="fa fa-clock-o"></i>
								<span><?php echo date('l, ', strtotime($event_day)); ?></span>
								<?php if( $start && $end){ ?>
										<span><?php echo $start .' - '. $end; ?></span>
								<?php }?></li>
								<?php  if($address) { ?>
									<li><i class="fa fa-map-marker"></i><span><?php echo $address; ?></span></li>
								<?php } ?>
								
								<?php  if($phone) { ?>
									<li><div class="tb-event-phone"><i class="fa fa-phone"></i><?php echo $phone; ?></div></li>
								<?php } ?>
							</ul>
						</div>
						<div class="col-md-6">
							<?php  if($event_day) { ?>
								<div class="jws-countdown-js" data-countdown="<?php echo esc_attr($event_day); ?>"><?php _e('Countdown Element','eduonline'); ?></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt( -1 , '').'</div>'; ?>
			
				<?php $event_social = apply_filters( 'the_content', get_post_meta( get_the_ID(), 'jws_theme_event_social', true ) );
					if( ! empty( $event_social ) ):
				 ?>
					<div class="tb-event-social">
						<?php jws_theme_course_sharing(); ?>
					</div>
				<?php endif;

				?>
				
			</div>
		</div>
	</div>
</article>
