<?php get_header(); ?>
<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
$jws_theme_show_page_comment = (int) isset($jws_theme_options['jws_theme_show_page_comment']) ?  $jws_theme_options['jws_theme_show_page_comment']: 1;
?>
	<div class="main-content">
		<?php while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>
			<div style="clear: both;"></div>
			
			<?php if($jws_theme_show_page_comment){ ?>
					
					<?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
				
			<?php } ?>

		<?php endwhile; // end of the loop. ?>
		
	</div>
<?php get_footer(); ?> 