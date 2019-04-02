<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (has_post_thumbnail()) { ?>
        <div class="tb-blog-image">
            <?php the_post_thumbnail('eduonline-course-medium'); ?>
        </div>
    <?php } ?>
	<div class="tb-content text-center">
		<?php if($show_title) { ?>
			<a href="<?php the_permalink(); ?>"><h4 class="tb-title"><?php the_title(); ?></h4></a>
		<?php } ?>
		<?php if($show_date) { ?>
			<p class="tb-date">
				<?php $date_start = esc_attr( get_post_meta(get_the_ID(), '_lp_date_start', true) ); ?>

				<span><?php echo _e('Starting from','eduonline');?></span>
				<?php echo date('M, d Y', strtotime($date_start)); ?>
			</p>
		<?php } ?>
		
	</div>
</article>
