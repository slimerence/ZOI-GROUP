<?php global $jws_theme_options; ?>
<div id="panel-style-selector">
	<div class="panel-wrapper">
		<div class="panel-selector-open"><i class="pe-7s-config pe-spin"></i></div>
		<div class="panel-selector-body clearfix">
			<section class="panel-selector-section clearfix">
				<div class="panel-selector-row clearfix">
					<a class="to_buy_now text-center" href="https://themeforest.net/item/eduonline-multipurpose-business-wordpress-theme-for-infants-nurseries-and-play-school/16259973">BUY NOW</a>
				</div>
			</section>
			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">Layout</h3>

				<div class="panel-selector-row clearfix">
				<?php $boxed = $jws_theme_options['jws_theme_body_layout']== 'boxed'; ?>
					<a data-type="layout" data-value="wide" href="#" class="panel-selector-btn<?php if( ! $boxed ) echo ' active'?>">Wide</a>
					<a data-type="layout" data-value="boxed" href="#" class="panel-selector-btn<?php if( $boxed ) echo ' active'?>">Boxed</a>
				</div>
			</section>
			
			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">PRIMARY COLOR EXAMPLES</h3>

				<div class="panel-selector-row clearfix">
					<ul class="panel-primary-color">
						<li class="" style="background-color:<?php echo $jws_theme_options['jws_theme_primary_color'];?>" data-color="<?php echo $jws_theme_options['jws_theme_primary_color'];?>" class="active"></li>
						<li style="background-color:#eaa24e" data-color="#eaa24e"></li>
						<li style="background-color:#bb3695" data-color="#bb3695"></li>
						<li style="background-color:#9ebe3b" data-color="#9ebe3b"></li>
						<li style="background-color:#9b59b6" data-color="#9b59b6"></li>
						<li style="background-color:#53b5f6" data-color="#53b5f6"></li>
					</ul>
				</div>			
				<h3 class="panel-selector-title">SECONDARY COLOR EXAMPLES</h3>
				<div class="panel-selector-row clearfix">
					<ul class="panel-secondary-color">
						<li class="" style="background-color: <?php echo $jws_theme_options['jws_theme_secondary_color'];?>" data-color="<?php echo $jws_theme_options['jws_theme_secondary_color'];?>" class="active"></li>
						<li style="background-color:#ff3371" data-color="#ff3371"></li>
						<li style="background-color:#54b5bc" data-color="#54b5bc"></li>
						<li style="background-color:#eb7039" data-color="#eb7039"></li>
						<li style="background-color:#9b59b6" data-color="#9b59b6"></li>
						<li style="background-color:#53b5f6" data-color="#53b5f6"></li>
					</ul>
				</div>
			</section>
			<section class="panel-selector-section clearfix">
				<h3 class="panel-selector-title">Background</h3>

				<div class="panel-selector-row clearfix">
					<ul class="panel-primary-background">
						<li class="pattern-0" data-name="pattern-1.png" data-type="pattern" style="background-position: 0px 0px;"></li>
						<li class="pattern-1" data-name="pattern-2.png" data-type="pattern" style="background-position: -45px 0px;"></li>
						<li class="pattern-2" data-name="pattern-3.png" data-type="pattern" style="background-position: -90px 0px;"></li>
						<li class="pattern-3" data-name="pattern-4.png" data-type="pattern" style="background-position: -135px 0px;"></li>
						<li class="pattern-4" data-name="pattern-5.png" data-type="pattern" style="background-position: -180px 0px;"></li>
						<li class="pattern-5" data-name="pattern-6.png" data-type="pattern" style="background-position: -225px 0px;"></li>
					</ul>
				</div>
			</section>
			<section class="panel-selector-section clearfix">
				<div class="panel-selector-row text-center">
					<a id="panel-selector-reset" href="#" class="panel-selector-btn">Reset</a>
				</div>
			</section>
		</div>
	</div>
</div>