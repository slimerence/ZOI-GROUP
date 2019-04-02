<?php

$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

if ( !empty( $terms ) && !is_wp_error( $terms ) ){

	$term_list = array();

	foreach ( $terms as $term ) {

		$term_list[] = $term->slug;

	}

}

?>

<div class="mix <?php echo esc_attr(implode(' ', $class_columns)).' '.esc_attr(implode(' ', $term_list)); ?>" data-myorder="<?php echo get_the_ID(); ?>">

	<div class="tb-portfolio-item <?php echo esc_attr('tb-col-'.$columns) ?>">

		<div class="tb-thumb">

			<?php if ( has_post_thumbnail() ) { ?>
			<div class="thumb-hover-effect">
				<?php the_post_thumbnail('eduonline-portfolio-thumb', array('class'=>'img-responsive'));?>
			</div>
			<?php } ?>

			<?php if($show_readmore) { ?>

				<div class="tb-readmore">

					<a href="<?php the_permalink(); ?>">+</a>

				</div>

			<?php } ?>

		</div>

		<div class="tb-content text-center">
			<?php if($show_category) { ?>

				<span class="tb-categories"><?php the_terms(get_the_ID(), 'portfolio_category', '' , ', ' ); ?></span>

			<?php } ?>

			<?php if($show_title) {
				$title = get_post_meta( get_the_ID(), 'jws_theme_source_project', true);
				$title = ! empty( $title ) ? $title : get_the_title();
				?>

				<h5 class="tb-title"><?php echo esc_attr( $title ); ?></h5>

			<?php } ?>

		</div>

	</div>
</div>