<?php
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	if($jws_theme_options['jws_theme_display_footer']){ ?>
	<div class="jws_theme_footer<?php echo (get_post_meta(get_the_ID(), 'jws_theme_footer', true)) ? ' '.esc_attr(get_post_meta(get_the_ID(), 'jws_theme_footer', true)) : ''; ?>">
		<!-- Start Footer Top -->
		<div class="container">
			<?php if($jws_theme_options['jws_theme_footer_top_column']){ ?>
				<div class="footer-top">
					<div class="row same-height">
						<!-- Start Footer Sidebar Top 1 -->
						<?php if($jws_theme_options['jws_theme_footer_top_column']>=1){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_top_col1']); ?>  jws_theme_footer_top_once">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 1")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 1 -->
						<!-- Start Footer Sidebar Top 2 -->
						<?php if($jws_theme_options['jws_theme_footer_top_column']>=2){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_top_col2']); ?> jws_theme_footer_top_two">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 2")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 2 -->
						<!-- Start Footer Sidebar Top 3 -->
						<?php if($jws_theme_options['jws_theme_footer_top_column']>=3){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_top_col3']); ?> jws_theme_footer_top_three">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Top Widget 3")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 3 -->
					</div>
				</div>
			<?php } ?>
			<!-- End Footer Top -->
			<?php if($jws_theme_options['jws_theme_footer_center_column']){ ?>
				<div class="footer-center">
					<div class="row same-height">
						<!-- Start Footer Sidebar Top 1 -->
						<?php if($jws_theme_options['jws_theme_footer_center_column']>=1){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_center_col1']); ?>  jws_theme_footer_center_once">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Center Widget 1")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 1 -->
						<!-- Start Footer Sidebar Top 2 -->
						<?php if($jws_theme_options['jws_theme_footer_center_column']>=2){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_center_col2']); ?> jws_theme_footer_center_two">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Center Widget 2")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 2 -->
						<!-- Start Footer Sidebar Top 3 -->
						<?php if($jws_theme_options['jws_theme_footer_center_column']>=3){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_center_col3']); ?> jws_theme_footer_center_three">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Center Widget 3")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 3 -->
						<!-- Start Footer Sidebar Top 4 -->
						<?php if($jws_theme_options['jws_theme_footer_center_column']>=4){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_center_col4']); ?> jws_theme_footer_center_four">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Center Widget 4")): endif; ?>
							</div>
						<?php } ?>
						<!-- End Footer Sidebar Top 4 -->
					</div>
				</div>
			<?php } ?>
		</div>
		<?php if($jws_theme_options['jws_theme_footer_bottom_column']){ ?>
			<div class="footer-bottom">
				<div class="container">
					<div class="row">
						<!-- Start Footer Sidebar Bottom Left -->
						<?php if($jws_theme_options['jws_theme_footer_bottom_column']>=1){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_bottom_col1']); ?> jws_theme_footer_bottom_once">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Bottom Widget 1")): endif; ?>
							</div>
						<?php } ?>
						<!-- Start Footer Sidebar Bottom Left -->
						<!-- Start Footer Sidebar Bottom Center -->
						<?php if($jws_theme_options['jws_theme_footer_bottom_column']>=2){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_bottom_col2']); ?> jws_theme_footer_bottom_two text-right">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Bottom Widget 2")): endif; ?>
							</div>
						<?php } ?>
						<!-- Start Footer Sidebar Bottom Center -->
						<!-- Start Footer Sidebar Bottom Right -->
						<?php if($jws_theme_options['jws_theme_footer_bottom_column']>=3){ ?>
							<div class="<?php echo esc_attr($jws_theme_options['jws_theme_footer_bottom_col3']); ?> jws_theme_footer_bottom_three">
								<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar("Footer Bottom Widget 3")): endif; ?>
							</div>
						<?php } ?>
						<!-- Start Footer Sidebar Bottom Right -->
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<?php } ?>

<a id="jws_theme_back_to_top">
	<span class="go_up">
		<i class="fa fa-angle-up"></i> 
	</span>
</a>

<?php wp_footer(); ?>
</body>
</html>					