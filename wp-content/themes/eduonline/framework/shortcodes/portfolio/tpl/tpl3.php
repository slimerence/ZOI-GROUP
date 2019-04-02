<?php
	while( $p->have_posts() ) :  $p->the_post();
		$full = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ),'full' );
		if( $full ):
			$terms = wp_get_post_terms(get_the_ID(), 'gallery_category');

			if ( !empty( $terms ) && !is_wp_error( $terms ) ){

				$term_list = array();

				foreach ( $terms as $term ) {

					$term_list[] = $term->slug;

				}

			}
		?>
		<div class="grid-item mix <?php echo implode(' ',$class_columns ); echo ' '. implode(' ', $term_list );?>">
			<a href="#" class="tb-open-lighth-box" data-src="<?php echo esc_url( $full[0] );?>">
				<i class="fa fa-search"></i>
			</a>
			<?php $thumb = rand(1,10) < 5 ? 'petta-gallery-thumb' : 'petta-gallery-thumb-horizontal'; the_post_thumbnail( $thumb, array('class'=>'img-responsive') ); ?>
		</div>
		<?php
		endif;
		$i++;
	endwhile;
 ?>