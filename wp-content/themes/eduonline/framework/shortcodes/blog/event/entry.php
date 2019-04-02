
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="tb-event-content">
		<?php 
			$event_day = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_event_day', true) );
			$start = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_start_time', true) );
			$end = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_end_time', true) );
			$address = esc_attr( get_post_meta(get_the_ID(), 'jws_theme_address', true) );
?>
		<p class="tb-event-day"><span><?php echo date('d', strtotime($event_day));?></span><span><?php echo date('M', strtotime($event_day)); ?></span></p>
		<div class="tb-info-block">
			<?php
			//echo jws_theme_post_cate();
			if($show_title) echo jws_theme_title_render(); 
			?>
			<ul>
				<?php if( $start && $end){ ?>
				<li><i class="fa fa-clock-o"></i>
					<span><?php echo $start .' - '. $end; ?></span>
				</li>
				<?php } if($address) { ?>
				<li><i class="fa fa-map-marker"></i>
					<span><?php echo $address; ?></span>
				</li>
				<?php } ?>
			</ul>
			
		</div>
	</div>
</article>
