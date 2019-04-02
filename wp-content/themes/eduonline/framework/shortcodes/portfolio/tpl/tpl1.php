<?php

	$lists_thumb = array('preshool-porfolio-home-thumb'=>array(0,2,3,5,6),'preshool-porfolio-home-medium-verticle'=>array(1,4));
	while( $p->have_posts() ) :  $p->the_post();
		$terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

		if ( !empty( $terms ) && !is_wp_error( $terms ) ){

			$term_list = array();

			foreach ( $terms as $term ) {

				$term_list[] = $term->slug;

			}

		}
		$j = $i % 7;
		$thumb = 'preshool-porfolio-home-thumb';
		foreach( $lists_thumb as $k=>$thumbs ){
			if( array_search( $j, $thumbs) !== false ){
				$thumb = $k;
				break;
			}
		}
		//var_dump($thumb);
		$width = jws_theme_get_image_width( $thumb );
		$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'full' );
		if( $full ):
		
		?>
		<div style="width:<?php echo intval( $width/373 ) * 30;?>%" class="mix grid-item <?php echo esc_attr(implode(' ', $term_list));?>">
			<div class="item-content">
				<div class="colorbox-wrap">
					<div class="colorbox-inner">
						<a class="cb-popup view-image" href="<?php echo esc_url( $full[0] );?>">
							<i class="fa fa-plus"></i>
						</a>
					</div>
				</div>
				<?php the_post_thumbnail( $thumb ); ?>
			</div>
		</div>
		<?php
		$i++;
		endif;
	endwhile;
 ?>