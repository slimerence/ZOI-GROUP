<?php

	$lists_thumb = array('portfolio-vertical-thumb'=>array(1,5),'portfolio-normal-thumb'=>array(2,3),'portfolio-big-thumb'=> array(0,4));
	
	while( $p->have_posts() ) :  $p->the_post();
		$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'full' );
		if( $full ):
			$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

			if ( !empty( $terms ) && !is_wp_error( $terms ) ){

				$term_list = array();

				foreach ( $terms as $term ) {

					$term_list[] = $term->slug;

				}

			}
			$j = $i % 6;
			$thumb = 'portfolio-normal-thumb';
			foreach( $lists_thumb as $k=>$thumbs ){
				
				if( array_search( $j, $thumbs) !== false ){
					$thumb = $k;
					break;
				}
			}
			//$width = tb_get_image_width( $thumb );
		?>
		<div class="grid-item mix <?php echo ' '. implode(' ', $term_list );?>">
			<div class="item-content">
			<div class="colorbox-wrap">
				<div class="colorbox-inner">
					<a class="view-image" href="<?php the_permalink(); ?>">
						<i class="fa fa-plus"></i>
					</a>
				</div>
			</div>
			<?php the_post_thumbnail( $thumb ); ?>
			</div>
			
		</div>
		<?php
		endif;
		$i++;
	endwhile;
 ?>