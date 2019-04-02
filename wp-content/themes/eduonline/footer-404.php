<?php $jws_theme_options = $GLOBALS['jws_theme_options'];
	$post_id = isset( $jws_theme_options['jws_theme_error404_page_id'] ) ? intval( $jws_theme_options['jws_theme_error404_page_id'] ) : 0;
?>
<?php
	$jws_theme_display_footer = isset( $post_id ) && get_post_meta( $post_id, 'jws_theme_display_footer', true )!==false ? get_post_meta( $post_id, 'jws_theme_display_footer', true ) : $jws_theme_options['jws_theme_error404_display_footer'];
?>
<?php if( $jws_theme_display_footer ) get_footer(); ?>
<a id="jws_theme_back_to_top">
	<span class="go_up">
		<i class="fa fa-angle-up"></i> 
	</span>
</a>
<?php wp_footer(); ?>
</body>
</html>