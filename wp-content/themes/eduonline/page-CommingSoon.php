<?php
/*
Template Name: Comming Soon Template
*/
get_header('404');
?>
<div class="main-content">
	<?php while ( have_posts() ) : the_post(); ?>

		<?php the_content(); ?>
	<?php endwhile; // end of the loop. ?>
</div>
<?php get_footer('404'); ?>