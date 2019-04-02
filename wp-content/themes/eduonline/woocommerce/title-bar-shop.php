<?php
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$jws_theme_show_page_title_shop = isset($jws_theme_options['jws_theme_show_page_title_shop']) ? $jws_theme_options['jws_theme_show_page_title_shop'] : 0;
	$jws_theme_show_page_breadcrumb_shop = isset($jws_theme_options['jws_theme_show_page_breadcrumb_shop']) ? $jws_theme_options['jws_theme_show_page_breadcrumb_shop'] : 0;
	$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
	$tpl = isset($jws_theme_options['jws_theme_title_bar_layout']) ? $jws_theme_options['jws_theme_title_bar_layout'] : 'tpl1';
	$class = array();
	$class[] = 'title-bar';
	$class[] = $tpl;
	if($tpl == 'tpl1'){
		if($jws_theme_show_page_title_shop && $jws_theme_show_page_breadcrumb_shop){
			$cl_page_title = $cl_page_breadcrumb = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
		}else{
			if($jws_theme_show_page_title_shop){
				$cl_page_title = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			}
			if($jws_theme_show_page_breadcrumb_shop){
				$cl_page_breadcrumb = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
			}
		}
	}
?>
<?php if($jws_theme_show_page_title_shop || $jws_theme_show_page_breadcrumb_shop){ ?>
	<div class="<?php echo esc_attr(implode(' ', $class)); ?>">
		<div class="container container-height">
			<div class="row row-height">
				<?php if($jws_theme_show_page_title_shop){ ?>
					<div class="<?php echo esc_attr($cl_page_title); ?> col-height col-middle">
						<h1 class="page-title"><?php echo jws_theme_woocommerce_page_title(); ?></h1>
					</div>
				<?php } ?>
				<?php if($jws_theme_show_page_breadcrumb_shop){ ?>
					<div class="<?php echo esc_attr($cl_page_breadcrumb); ?> col-height col-middle">
						<?php woocommerce_breadcrumb(); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>