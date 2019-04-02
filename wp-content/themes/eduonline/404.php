<?php
/*
Template Name: 404 Template
*/
get_header('404');
$jws_theme_options = $GLOBALS['jws_theme_options'];
?>

<div class="main-content">
	<div class="tb-error404-wrap text-center" >
		<?php
		$page404 = isset( $jws_theme_options['jws_theme_error404_page_id'] ) ? intval( $jws_theme_options['jws_theme_error404_page_id'] ) : 0;
		echo apply_filters( 'the_content', get_post_field( 'post_content', $page404 ) );
		
		?>
	</div>
</div>
<?php get_footer('404'); ?>