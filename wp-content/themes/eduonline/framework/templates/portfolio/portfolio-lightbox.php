<?php
$show_readmore  = isset( $show_readmore ) ? $show_readmore  : 0;


$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

if ( !empty( $terms ) && !is_wp_error( $terms ) ){

	$term_list = array();

	foreach ( $terms as $term ) {

		$term_list[] = $term->slug;

	}

}
if( ! isset( $class_columns) ) $class_columns = $columns = '';
?>

<div class="mix <?php if( !is_single() ){ echo esc_attr(implode(' ', $class_columns)).' '.esc_attr(implode(' ', $term_list)); } ?>" data-myorder="<?php echo get_the_ID(); ?>">

	<div class="tb-portfolio-item <?php echo esc_attr('tb-col-'.$columns) ?>">

		<div class="item-content">

			<?php if ( has_post_thumbnail() ) {
				$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'full' );
				?>
				<div class="colorbox-wrap">
					<div class="colorbox-inner">
						<a class="cb-popup view-image" href="<?php echo esc_url( $full[0] );?>">
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>
				<a class="thumb-hover-effect" href="<?php the_permalink();?>">
					<?php the_post_thumbnail('preshool-porfolio-home-thumb', array('class'=>'img-responsive'));?>

				</a>
			<?php } ?>

		</div>


	</div>
</div>