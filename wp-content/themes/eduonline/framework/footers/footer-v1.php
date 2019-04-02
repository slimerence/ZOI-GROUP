<?php
$jws_theme_options = $GLOBALS['jws_theme_options'];
?>
	<?php
		$jws_theme_display_footer = jws_theme_get_object_id('jws_theme_display_footer', true);
		if( $jws_theme_display_footer ){
			$jws_theme_footer_layout = jws_theme_get_object_id('jws_theme_footer_layout', true);
			$jws_theme_footer_full = jws_theme_get_object_id('jws_theme_footer_full');
	 ?>
	<div class="jws_theme_footer <?php if( $jws_theme_footer_full ) echo 'tb-layout-fullwidth ';echo (get_post_meta(get_the_ID(), 'jws_theme_footer', true)) ? ' '.esc_attr(get_post_meta(get_the_ID(), 'jws_theme_footer', true)) : ''; ?>">
		
		<!-- Start Footer Bottom -->
		<div class="footer-bottom">
		<?php if( ! $jws_theme_footer_full ) echo '<div class="container">'; ?>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 jws_theme_footer_bottom_left">
					<?php if(is_active_sidebar('tbtheme-bottom-left')){ dynamic_sidebar("tbtheme-bottom-left"); }?>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 jws_theme_footer_bottom_right">
					<?php if(is_active_sidebar('tbtheme-bottom-right')){ dynamic_sidebar("tbtheme-before-footer-2"); }?>
				</div>
			</div>
		</div>
		<?php if( ! $jws_theme_footer_full ) echo '</div>'; ?>
	</div>
	<?php }?>
</div><!-- #wrap -->
<div style="display: none;">
	<div id="jws_theme_send_mail" class="tb-send-mail-wrap">
		<?php if(is_active_sidebar('tbtheme-popup-newsletter-sidebar')){ dynamic_sidebar("tbtheme-popup-newsletter-sidebar"); }?>
	</div>
</div>