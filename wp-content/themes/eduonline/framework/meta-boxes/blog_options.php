<div id="tb-blog-loading" class="jws_theme_loading" style="display: block;">
	<div id="followingBallsG">
	<div id="followingBallsG_1" class="followingBallsG">
	</div>
	<div id="followingBallsG_2" class="followingBallsG">
	</div>
	<div id="followingBallsG_3" class="followingBallsG">
	</div>
	<div id="followingBallsG_4" class="followingBallsG">
	</div>
	</div>
</div>
<div id="tb-blog-metabox" class='jws_theme_metabox' style="display: none;">
	<div id="tb-tab-blog" class='categorydiv'>
		<ul class='category-tabs'>
		   <li class='tb-tab'><a href="#tabs-header"><i class="dashicons dashicons-menu"></i> <?php echo _e('HEADER','eduonline');?></a></li>
		   <li class='tb-tab'><a href="#tabs-title-bar"><i class="dashicons dashicons-menu"></i> <?php echo _e('TITLE BAR','eduonline');?></a></li>
		   <li class='tb-tab'><a href="#tabs-footer"><i class="dashicons dashicons-menu"></i> <?php echo _e('Footer','eduonline');?></a></li>
		</ul>
		<div class='tb-tabs-panel'>
			<div id="tabs-header">
				<?php
					$headers = array('global' => 'Global', 'v1' => 'Header 1', 'v2' => 'Header 2');
					$this->select('header_layout',
							'Header',
							$headers,
							'',
							''
					);
					$this->upload(
						'custom_logo',
						esc_html_e('Custom Header Logo','venus'),
						''
					);
					$this->select('header_fixed',
							'Header Fixed',
							array('' => 'No', '1' => 'Yes, please'),
							'',
							''
					);
				?>
				
				<p class="cs_info"><i class="dashicons dashicons-megaphone"></i><?php echo _e('Main Navigation','eduonline'); ?></p>
				<?php
				$menus = array('' => 'Global');
				$obj_menus = wp_get_nav_menus();
				foreach ($obj_menus as $obj_menu){
					$menus[$obj_menu->term_id] = $obj_menu->name;
				}
				$this->select('custom_menu',
						'Select Menu',
						$menus,
						'',
						''
				);
				?>
				
			</div>
			<div id="tabs-title-bar">
				<?php 
					$this->select('page_title_bar',
						'Title Bar',
						array('0' => 'No', '1' => 'Yes, please'),
						'',
						'Show title bar on page'
					);
				?>
			</div>
			<div id="tabs-footer">
				<?php
					$this->select('display_footer',
							'Display Footer',
							array('1' => 'Yes, please', 0 => 'No'),
							'',
							''
					);
				?>
			</div>
		</div>
	</div>
</div>
