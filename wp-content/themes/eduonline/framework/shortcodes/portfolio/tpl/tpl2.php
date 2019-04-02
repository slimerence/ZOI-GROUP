<?php

	while( $p->have_posts() ) :  $p->the_post();
	$terms = wp_get_post_terms(get_the_ID(), 'gallery_category');

	if ( !empty( $terms ) && !is_wp_error( $terms ) ){

		$term_list = array();

		foreach ( $terms as $term ) {

			$term_list[] = $term->slug;

		}

	}
		$j = (isset($posts_per_page) && isset($paged) ? ($posts_per_page * ($paged-1) + $i) : $i) % 5;
		$thumb = 'preshool-porfolio-home-thumb';
		
		$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'full' );
		if( $full ):
		?>
		<div class="mix grid-item <?php echo esc_attr(implode(' ', $term_list));?>">
			<a href="#" class="tb-open-lighth-box" data-src="<?php echo esc_url( $full[0] );?>">
				<i class="fa fa-search"></i>
			</a>
			<?php the_post_thumbnail( $thumb ); ?>
		</div>
		<?php
		$i++;
		endif;
	endwhile;
 ?>