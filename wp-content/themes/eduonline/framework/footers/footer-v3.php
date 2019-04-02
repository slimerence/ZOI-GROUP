	<?php
		$jws_theme_display_footer = jws_theme_get_object_id('jws_theme_display_footer', true);
	if( $jws_theme_display_footer ){
			$jws_theme_footer_layout = jws_theme_get_object_id('jws_theme_footer_layout', true);
			$jws_theme_footer_full = jws_theme_get_object_id('jws_theme_footer_full');
	 ?>
	<div class="jws_theme_footer tb-footer-v3 <?php if( $jws_theme_footer_full ) echo 'tb-layout-fullwidth ';if(jws_theme_get_object_id('jws_theme_footer')) echo jws_theme_get_object_id('jws_theme_footer'); ?>">
		<?php if( is_active_sidebar('tbtheme-before-footer-1') || is_active_sidebar('tbtheme-before-footer-2') ): ?>
		<div class="footer-header">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_before_footer_1">
						<?php if(is_active_sidebar('tbtheme-before-footer-1')){ dynamic_sidebar("tbtheme-before-footer-1"); } ?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_before_footer_2">
						<?php if(is_active_sidebar('tbtheme-before-footer-2')){ dynamic_sidebar("tbtheme-before-footer-2");} ?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_before_footer_3">
						<?php if(is_active_sidebar('tbtheme-before-footer-3')){ dynamic_sidebar("tbtheme-before-footer-3");} ?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_before_footer_4 text-right">
						<?php if(is_active_sidebar('tbtheme-before-footer-4')){ dynamic_sidebar("tbtheme-before-footer-4");} ?>
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!-- Start Footer Top -->
		<div class="footer-top">
			<div class="container">
				<div class="row same-height">
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_footer_top_one">
						<?php if(is_active_sidebar('tbtheme-footer-top-1')){ dynamic_sidebar("tbtheme-footer-top-1"); } ?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_footer_top_two">
						<?php if(is_active_sidebar('tbtheme-footer-top-2')){ dynamic_sidebar("tbtheme-footer-top-2"); }?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_footer_top_three">
						<?php if(is_active_sidebar('tbtheme-footer-top-3')){ dynamic_sidebar("tbtheme-footer-top-3"); }?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-3 jws_theme_footer_top_four">
						<?php if(is_active_sidebar('tbtheme-footer-top-4')){ dynamic_sidebar("tbtheme-footer-top-4"); }?>
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		
		<!-- Start Footer Bottom -->
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 jws_theme_footer_bottom_left">
						<?php if(is_active_sidebar('tbtheme-bottom-left')){ dynamic_sidebar("tbtheme-bottom-left"); }?>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 jws_theme_footer_bottom_right">
						<?php if(is_active_sidebar('tbtheme-bottom-right')){ dynamic_sidebar("tbtheme-bottom-right"); }?>
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Bottom -->
	</div>
	<?php }
	?>
</div><!-- #wrap -->
<div id="tb-send_mail" class="tb-send-mail-wrap">
	<div class="tb-mail-inner">
		<?php if(is_active_sidebar('tbtheme-popup-newsletter-sidebar')){ dynamic_sidebar("tbtheme-popup-newsletter-sidebar"); }?>
		<a href="#tb-send_mail" id="tb-close-newsletter" class="tb-close-lightbox">x</a>
	</div>
</div>