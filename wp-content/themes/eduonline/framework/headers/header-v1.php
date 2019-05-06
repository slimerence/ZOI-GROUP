<?php
	$jws_theme_options = $GLOBALS['jws_theme_options'];
	$jws_theme_custom_menu =  jws_theme_get_object_id('jws_theme_custom_menu');
	$jws_theme_header_fixed = jws_theme_get_object_id('jws_theme_header_fixed');

	
	$jws_theme_header_class = array();
    if($jws_theme_header_fixed) $jws_theme_header_class[] = 'tb-header-fixed';
    if($jws_theme_options['jws_theme_stick_header']) $jws_theme_header_class[] = 'tb-header-stick';

?>
<div class="top-bar hidden-sm hidden-xs" style="background-color: #44a676;" >
    <div class="top-right">
        <a href="tel:+610383474100" target="_blank">
            <i class="fa fa-phone"></i>
            +61 3 8347 4100
        </a>
    </div>
    <div class="top-right">
        <a href="mailto:info@zoi.vic.edu.au" target="_blank">
            <i class="fa fa-envelope"></i>
            info@zoi.vic.edu.au
        </a>
    </div>
    <div class="top-right">
        <a href="https://apps.wisenet.co/login.aspx" target="_blank">
            <i class="fa fa-user"></i>
            My Zoi
        </a>
    </div>
    <div class="top-right">
        <a href="https://www.instagram.com/zoi_education/" target="_blank">
            <i class="fa fa-instagram"></i>
        </a>
        <a href="https://twitter.com/Zoi_Education" target="_blank">
            <i class="fa fa-twitter"></i>
        </a>
        <a href="https://www.facebook.com/ZoiTraining" target="_blank">
            <i class="fa fa-facebook"></i>
        </a>
        <a href="https://mp.weixin.qq.com/s/-1uV54NhZB87e76jEoTzfg" target="_blank">
            <i class="fa fa-wechat"></i>
        </a>
    </div>
</div>

<div class="tb-header-wrap tb-header-v1 <?php echo esc_attr(implode(' ', $jws_theme_header_class)); ?>">

	<div class="tb-logo logo-hidden-mobi pull-left hidden-sm hidden-xs">
		<a href="<?php echo esc_url(home_url()); ?>">
			<?php jws_theme_theme_logo(); ?>
		</a>
	</div>
	
	<div class="tb-header-widget pull-right hidden-sm hidden-xs">
		<!-- Start Sidebar Right -->
		<?php if(is_active_sidebar( 'tbtheme-header1-widget2' )){ ?>
			<div class="tb-sidebar tb-sidebar-right"><?php dynamic_sidebar("tbtheme-header1-widget2");?></div>
		<?php } ?>
		<!-- End Sidebar Right -->
	</div>
	<!-- Start Header Menu -->

	<div class="tb-header-menu tb-header-menu-md">
		<div class="container">
			<div class="tb-header-menu-inner">
				<div class="row">
					<div class="col-xs-10 col-sm-10 tb-logo logo-hidden-mobi">
						<a href="<?php echo esc_url(home_url()); ?>">
							<?php jws_theme_theme_logo(); ?>
						</a>
					</div>
					
					<div class="col-xs-7 col-sm-8 col-md-12 col-lg-12 mre-sty-header hidden-sm hidden-xs">
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
						</div>
						<div class="tb-menu-widget">
							<!-- Start Sidebar Right -->
							<?php if(is_active_sidebar( 'tbtheme-header1-widget1' )){ ?>
								<div class="tb-sidebar tb-menu-sidebar"><?php dynamic_sidebar("tbtheme-header1-widget1");?></div>
							<?php } ?>
							<!-- End Sidebar Right -->
						</div>
					</div>
					<div class=" col-xs-2 col-sm-2 hidden-lg text-right">
						<div class="tb-menu-control-mobi">
							<a href="javascript:void(0)"><i class="fa fa-bars"></i></a>
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
			'menu_id' => 'nav1',
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