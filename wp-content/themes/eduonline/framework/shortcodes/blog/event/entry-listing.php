<?php 
	$event_day = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_event_day', true) );
	$start = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_start_time', true) );
	$end = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_end_time', true) );
	$address = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_address', true) );
	$phone = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_phone', true) );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('same-height'); ?>>
	<div class="tb-event-image">
		<?php the_post_thumbnail( 'event-listing-thumb' ); ?>
		<div class="tb-image-content">
			<ul>
			<?php  if($phone) { ?>
				<li><div class="tb-event-phone"><i class="fa fa-phone"></i><?php echo $phone; ?></div></li>
			<?php } ?>
			<li>
			<span><?php echo date('l, ', strtotime($event_day)); ?></span>
			<?php if( $start && $end){ ?>
					<span><?php echo $start .' - '. $end; ?></span>
			<?php }?></li>
			<?php  if($address) { ?>
				<li><div><?php echo $address; ?></div></li>
			<?php } ?>
			<?php  if($event_day) { ?>
				<li><div class="jws-countdown-js" data-countdown="<?php echo esc_attr($event_day); ?>"><?php _e('Countdown Element','eduonline'); ?></div></li>
			<?php } ?>
			</ul>
		</div>
	</div>
	<div class="tb-event-content">
		<?php if($show_title) echo jws_theme_title_render(); ?>
		<?php if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>'; ?>
	
		<?php $event_social = apply_filters( 'the_content', get_post_meta( get_the_ID(), 'jws_theme_event_social', true ) );
			if( ! empty( $event_social ) ):
		 ?>
			<div class="tb-event-social">
				<span><?php echo __('Socials: ','eduonline'); ?></span>
				<?php echo $event_social; ?>
			</div>
		<?php endif;

		?>
		
	</div>
	<div style="clear: both"></div>
</article>
