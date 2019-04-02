<?php
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$jws_theme_custom_menu =  jws_theme_get_object_id('jws_theme_custom_menu');
	$jws_theme_header_fixed = jws_theme_get_object_id('jws_theme_header_fixed');

	
	$jws_theme_header_class = array();
    if($jws_theme_header_fixed) $jws_theme_header_class[] = 'tb-header-fixed';
    if($jws_theme_options['jws_theme_stick_header']) $jws_theme_header_class[] = 'tb-header-stick';

?>
<div class="tb-header-wrap tb-header-v1 tb-header-v2 <?php echo esc_attr(implode(' ', $jws_theme_header_class)); ?>">

	
	<div class="tb-header-widget pull-right hidden-sm">
		<!-- Start Sidebar Right -->
		
		<!-- End Sidebar Right -->
	</div>
	<!-- Start Header Menu -->

	<div class="tb-header-menu tb-header-menu-md">
		<div class="container">
			<div class="tb-header-menu-inner">
				<div class="row">
					<div class="col-xs-10 col-sm-10 tb-logo col-md-2">
						<a href="<?php echo esc_url(home_url()); ?>">
							<?php jws_theme_theme_logo(); ?>
						</a>
					</div>
					<div class=" col-xs-2 col-sm-2 hidden-lg text-right">
						<div class="tb-menu-control-mobi">
							<a href="javascript:void(0)"><i class="fa fa-bars"></i></a>
						</div>

					</div>
					
					<div class="col-xs-7 col-sm-8 col-md-10 col-lg-10 mre-sty-header hidden-sm">
						<div class="tb-menu">
							
							<?php
							$arr = array(
								'theme_location' => 'main_navigation',
								'menu_id' => 'nav',
								'container_class' => 'tb-menu-list',
								'menu_class'      => 'tb-menu-list-inner',
								'echo'            => true,
								'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
								'depth'           => 0,
							);
							if($jws_theme_custom_menu){
								$arr['menu'] = $jws_theme_custom_menu;
							}
							if (has_nav_menu('main_navigation')) {
								wp_nav_menu( $arr );
							}else{ ?>
							<div class="menu-list-default">
								<?php wp_page_menu();?>
							</div>    
							<?php } ?>
							<div class="tb-canval-menu"><span></span></div>
						</div>
						
						<div class="tb-menu-widget">
							<?php if(is_active_sidebar( 'tbtheme-header2-widget1' )){ ?>
								<div class="tb-sidebar tb-sidebar-canval"><?php dynamic_sidebar("tbtheme-header2-widget1");?></div>
							<?php } ?>
							<!-- Start Sidebar Right -->
							<?php if(is_active_sidebar( 'tbtheme-header2-widget2' )){ ?>
								<div class="tb-sidebar tb-menu-sidebar"><?php dynamic_sidebar("tbtheme-header2-widget2");?></div>
							<?php } ?>
							<!-- End Sidebar Right -->
						</div>
					</div>
				</div>
			</div>
		</div>
			
	</div>
	<div style="clear: both"></div>
</div>
<div class="jws_theme_menu_mobi">
	<div class="tb-menu">
		<?php
		$arr = array(
			'theme_location' => 'main_navigation',
			'menu_id' => 'nav',
			'container_class' => 'tb-menu-list tb-menu-mobi-list',
			'menu_class'      => 'tb-menu-list-inner',
			'echo'            => true,
			'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth'           => 0,
		);
		if($jws_theme_custom_menu){
			$arr['menu'] = $jws_theme_custom_menu;
		}
		if (has_nav_menu('main_navigation')) {
			wp_nav_menu( $arr );
		}else{ ?>
		<div class="menu-list-default">
			<?php wp_page_menu();?>
		</div>    
		<?php } ?>
	</div>
</div>
<!-- End Header Menu -->