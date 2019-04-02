<?php

	$course = LP()->global['course'];

 ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (has_post_thumbnail()) { ?>
        <div class="tb-blog-image">
            <?php the_post_thumbnail('eduonline-course-related'); ?>
        </div>
    <?php } ?>
	<div class="tb-content">
		<?php if($show_date) { ?>
			<p class="tb-date">
				<?php $date_start = esc_attr( get_post_meta(get_the_ID(), '_lp_date_start', true) ); ?>

				<span><?php echo _e('Starting','eduonline');?></span>
				<?php echo date('d M. Y', strtotime($date_start)); ?>
			</p>
		<?php } ?>
		
		<?php if($show_title) { ?>
			<a href="<?php the_permalink(); ?>"><h4 class="tb-title"><?php the_title(); ?></h4></a>
		<?php } ?>
	
		<?php if($show_excerpt) echo '<div class="tb-blog-excerpt">'.jws_theme_custom_excerpt($excerpt_length , $excerpt_more).'</div>';
			
			if($show_lession){
				echo '<div class="tb-lesson">';
					$items = $course->get_curriculum_items( array( 'group' => true ) );
					$count_lessons  = sizeof( $items['lessons'] );
					if ( $count_lessons ) {
						echo __($count_lessons.' lessons','eduonline');
					} else {
						echo __( "0 lesson", 'eduonline' );
					}
				?>
				<span class="author-name"><?php the_author_posts_link(); ?></span>
				
				<?php echo '</div>';
			}
		?>
		<div class="tb-price">	
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
			
			<?php if($read_more) echo '<a href='. get_the_permalink().' class="tb-read-more">'. esc_attr($read_more_text).'</a>'; ?>

		</div>
	</div>
</article>
