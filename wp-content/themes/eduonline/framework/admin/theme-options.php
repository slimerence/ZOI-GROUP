<?php
    /**
     * ReduxFramework Theme Config File
     * For full documentation, please visit: https://docs.reduxframework.com
     * */

    if ( ! class_exists( 'Redux_Framework_theme_config' ) ) {

class Redux_Framework_theme_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }
				add_action( 'admin_enqueue_scripts', array( $this, 'tbtheme_add_scripts' ));

            }
			public function tbtheme_add_scripts(){
				wp_enqueue_script( 'action', JWS_THEME_URI_PATH_ADMIN.'/assets/js/action.js', false );
				wp_enqueue_style( 'style_admin', JWS_THEME_URI_PATH_ADMIN.'/assets/css/style_admin.css', false );
			}
            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                //$this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'eduonline' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'eduonline' ),
                    'icon'   => 'el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }

            public function setSections() {

                /**
                 * Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
                 * */
                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'eduonline' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'eduonline' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'eduonline' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo esc_attr($this->theme->display( 'Name' )); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'eduonline' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'eduonline' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'eduonline' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo esc_attr($this->theme->display( 'Description' )); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'eduonline' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'eduonline' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

                $sampleHTML = '';
                if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
                    Redux_Functions::initWpFilesystem();

                    global $wp_filesystem;

                    $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
                }
				
				$of_options_fontsize = array("8px" => "8px", "9px" => "9px", "10px" => "10px", "11px" => "11px", "12px" => "12px", "13px" => "13px", "14px" => "14px", "15px" => "15px", "16px" => "16px", "17px" => "17px", "18px" => "18px", "19px" => "19px", "20px" => "20px", "21px" => "21px", "22px" => "22px", "23px" => "23px", "24px" => "24px", "25px" => "25px", "26px" => "26px", "27px" => "27px", "28px" => "28px", "29px" => "29px", "30px" => "30px", "31px" => "31px", "32px" => "32px", "33px" => "33px", "34px" => "34px", "35px" => "35px", "36px" => "36px", "37px" => "37px", "38px" => "38px", "39px" => "39px", "40px" => "40px");
				$of_options_fontweight = array("100" => "100", "200" => "200", "300" => "300", "400" => "400", "500" => "500", "600" => "600", "700" => "700");
				$of_options_font = array("1" => "Google Font", "2" => "Standard Font", "3" => "Custom Font");
				//Google font API
				$of_options_google_font = array();
				if (is_admin()) {
					$results = '';
					//$whitelist = array('127.0.0.1','::1');
					//if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
						$results = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?sort=alpha&key=AIzaSyDnf-ujK_DUCihfvzqdlBokan6zbnrJbi0');
						if (!is_wp_error($results)) {
								$results = json_decode($results['body']);
								if(isset($results->items)){
									foreach ($results->items as $font) {
										$of_options_google_font[$font->family] = $font->family;
									}
								}
						}
					//}
				}
				//Standard Fonts
				$of_options_standard_fonts = array(
					'Arial, Helvetica, sans-serif' => 'Arial, Helvetica, sans-serif',
					"'Arial Black', Gadget, sans-serif" => "'Arial Black', Gadget, sans-serif",
					"'Bookman Old Style', serif" => "'Bookman Old Style', serif",
					"'Comic Sans MS', cursive" => "'Comic Sans MS', cursive",
					"Courier, monospace" => "Courier, monospace",
					"Garamond, serif" => "Garamond, serif",
					"Georgia, serif" => "Georgia, serif",
					"Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
					"'Lucida Console', Monaco, monospace" => "'Lucida Console', Monaco, monospace",
					"'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
					"'MS Sans Serif', Geneva, sans-serif" => "'MS Sans Serif', Geneva, sans-serif",
					"'MS Serif', 'New York', sans-serif" => "'MS Serif', 'New York', sans-serif",
					"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "'Palatino Linotype', 'Book Antiqua', Palatino, serif",
					"Tahoma, Geneva, sans-serif" => "Tahoma, Geneva, sans-serif",
					"'Times New Roman', Times, serif" => "'Times New Roman', Times, serif",
					"'Trebuchet MS', Helvetica, sans-serif" => "'Trebuchet MS', Helvetica, sans-serif",
					"Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
				);
				// Custom Font
				$fonts = array();
				$of_options_custom_fonts = array();
				$font_path = get_template_directory() . "/fonts";
				if (!$handle = opendir($font_path)) {
					$fonts = array();
				} else {
					while (false !== ($file = readdir($handle))) {
						if (strpos($file, ".ttf") !== false ||
							strpos($file, ".eot") !== false ||
							strpos($file, ".svg") !== false ||
							strpos($file, ".woff") !== false
						) {
							$fonts[] = $file;
						}
					}
				}
				closedir($handle);

				foreach ($fonts as $font) {
					$font_name = str_replace(array('.ttf', '.eot', '.svg', '.woff'), '', $font);
					$of_options_custom_fonts[$font_name] = $font_name;
				}
				/* remove dup item */
				$of_options_custom_fonts = array_unique($of_options_custom_fonts);

                //lists page
                $lists_page = array();
                $args_page = array(
                    'sort_order' => 'asc',
                    'sort_column' => 'post_title',
                    'hierarchical' => 1,
                    'exclude' => '',
                    'include' => '',
                    'meta_key' => '',
                    'meta_value' => '',
                    'authors' => '',
                    'child_of' => 0,
                    'parent' => -1,
                    'exclude_tree' => '',
                    'number' => '',
                    'offset' => 0,
                    'post_type' => 'page',
                    'post_status' => 'publish'
                );
                $pages = get_pages( $args_page );

                foreach( $pages as $p ){
                    $lists_page[ $p->ID ] = esc_attr( $p->post_title );
                }
				
				/*General Setting*/
				$this->sections[] = array(
                    'title'  => __( 'General Setting', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-cogs',
                    'fields' => array(
						array(
                            'id'       => 'jws_theme_less',
                            'type'     => 'switch',
                            'title'    => __( 'Less Design', 'eduonline' ),
                            'subtitle' => __( 'Use the less design features.', 'eduonline' ),
							'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_box_style',
                            'type'     => 'switch',
                            'title'    => __( 'Show Box Style', 'eduonline' ),
                            'subtitle' => __( 'Show Box style options', 'eduonline' ),
                            'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_show_popup',
                            'type'     => 'switch',
                            'title'    => __( 'Show Newsletter Popup onload', 'eduonline' ),
                            'subtitle' => __( 'Show Newsletter popup on load', 'eduonline' ),
                            'default'  => false,
                        ),
                        array( 
                            'id'       => 'jws_theme_body_layout',
                            'type'     => 'select',
                                'title'    => __('Choose Body Layout', 'eduonline'),
                                'subtitle' => __('Select body layout.', 'eduonline'),
                                'options'  => array(
                                    'wide'=>__('Wide', 'eduonline'),
                                    'boxed'=>__('Boxed', 'eduonline')
                                ),
                                'default'  => 'wide'
                        ),
						array(
							'id'       => 'jws_theme_smoothscroll',
							'type'     => 'switch',
							'title'    => __( 'Smoothscroll', 'eduonline' ),
							'subtitle' => __( 'Use the smoothscroll in your site.', 'eduonline' ),
							'default'  => true,
						),
						array(
							'id'       => 'jws_theme_background',
							'type'     => 'background',
							'title'    => __('Body Background', 'eduonline'),
							'subtitle' => __('Body background with image, color, etc.', 'eduonline'),
							'default'  => array(
								'background-color' => '#ffffff',
							),
							'output' => array('body'),
						),
					)
					
				);
				/*Logo*/
				$this->sections[] = array(
                    'title'  => __( 'Logo', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-viadeo',
                    'fields' => array(
						array(
							'id'       => 'jws_theme_favicon_image',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Favicon Image', 'eduonline'),
							'subtitle' => __('Select an image file for your favicon.', 'eduonline'),
							'default'  => array(
								'url'	=> JWS_THEME_URI_PATH.'/favicon.ico'
							),
						),
						array(
							'id'       => 'jws_theme_logo_image',
							'type'     => 'media',
							'url'      => true,
							'title'    => __('Logo Image', 'eduonline'),
							'subtitle' => __('Select an image file for your logo instead of text.', 'eduonline'),
							'default'  => array(
								'url'	=> JWS_THEME_URI_PATH.'/assets/images/logo.png'
							),
						)
					)
				);
				
				/* Header Options */
				$this->sections[] = array(
                    'title'  => __( 'Header', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-file-edit',
                    'fields' => array(
						array( 
							'id'       => 'jws_theme_header_layout',
							'type'     => 'image_select',
							'title'    => __('Header Layout', 'eduonline'),
							'subtitle' => __('Select header layout in your site.', 'eduonline'),
							'options'  => array(
                                'v1'    => array(
                                    'alt'   => 'Header 1',
                                    'img'   => JWS_THEME_URI_PATH.'/assets/images/headers/header-v1.jpg'
                                ),
								'v2'	=> array(
									'alt'   => 'Header 2',
									'img'   => JWS_THEME_URI_PATH.'/assets/images/headers/header-v2.jpg'
								),
							),
							'default' => 'v1'
						),
						/* Header Sticky */
						array(
                            'id'       => 'jws_theme_stick_header',
                            'type'     => 'switch',
                            'title'    => __( 'Sticky Header', 'eduonline' ),
                            'subtitle' => __( 'Enable a fixed header when scrolling.', 'eduonline' ),
							'default'  => false,
                        ),
						/* Header Sticky */
					)
				);
				/* Header Options */
				
				/*Main Menu*/
				$this->sections[] = array(
                    'title'  => __( 'Main Menu', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-list',
                    'fields' => array(
						array(
							'id'          => 'jws_theme_menu_font_size_firts_level',
							'type'        => 'typography', 
							'title'       => __('Typography', 'eduonline'),
							'color'      => false, 
							'font-weight' => false, 
							'subsets' => false,
							'font-backup' => false,
							'line-height' => false,
							'subtitle' => __('Typography option with firts level item in menu. Default: 14px, ex: 14px.', 'eduonline'),
							'default'     => array(
								'font-size'   => '14px',
								'font-family' => 'Noto Sans',
								'font-weight' => 400,
							),
							'output' => array('#nav > li > a'),
						),
						array(
							'id'          => 'jws_theme_menu_font_size_sub_level',
							'type'        => 'typography', 
							'title'       => __('Typography', 'eduonline'),
							'color'      => false, 
							'font-weight' => true, 
							'subsets' => false,
							'font-backup' => false,
							'subtitle' => __('Typography option with sub level item in menu.', 'eduonline'),
							'default'     => array(
								'font-family' => 'Noto Sans',
								'font-size'   => '14px',
								'line-height' => '44px',
								'font-weight' => '400',
							),
							'output' => array('#nav > li > ul li a'),
						),
						array(
							'id' => 'jws_theme_menu_padding',
							'title' => 'Menu Padding',
							'subtitle' => __('Please, Enter padding For Menu.', 'eduonline'),
							'type' => 'spacing',
							'units' => array('px'),
							'output' => array('#nav > li > a'),
							'default' => array(
								'padding-top'     => '0', 
								'padding-right'   => '23px', 
								'padding-bottom'  => '0', 
								'padding-left'    => '23px',
								'units'          => 'px', 
							)
						),
					)
					
				);
/*Footer*/		
				$this->sections[] = array(
					'title'  => __( 'Menu Color', 'eduonline' ),
					'desc'   => __( '', 'eduonline' ),
					'icon'   => '',
					'subsection' => true,
					'fields' => array(
					array(
						'id'       => 'tb_main_menu_color_level1',
						'type'     => 'link_color',
						'title'    => __('Main Menu Font Color _ First Level', 'eduonline'),
						'subtitle' => __('Controls the text color of first level menu items.', 'eduonline'),
						'validate' => 'color',
						'default'  => array(
							'regular'  => '#363636', // blue
							'hover'    => '#448ccb',
							'active'    => '#448ccb',
						),
					),
					
					array(
						'id'       => 'tb_main_menu_color_sub_level',
						'type'     => 'link_color',
						'title'    => __('Main Menu Color _ SubLevel', 'eduonline'),
						'subtitle' => __('Controls the color of the menu sublevel.', 'eduonline'),
						'validate' => 'color',
						'default'  => array(
							'regular'  => '#fff', // blue
							'hover'    => '#aaa',
							'active'    => '#aaa',
						),
					),
					array(
							'id'       => 'tb_main_menu_separator_color_sub_level',
							'type'     => 'color',
							'title'    => __('Main Menu Separator Color _ SubLevel', 'eduonline'),
							'subtitle' => __('Controls the color of the menu separator sublevel. (default: #fff).', 'eduonline'),
							'default'  => '#fff',
							'validate' => 'color',
						),
					array(
						'id'       => 'tb_main_menu_bg_sub_level',
						'type'     => 'background',
						'background-color' => true,
						'background-repeat' => false,
						'background-attachment' => false,
						'background-position' => false,
						'background-image' => false,
						'background-clip' => false,
						'background-origin' => false,
						'background-size' => false,
						'preview' => false,
						'background-size' => false,
						'background-size' => false,
						'title'    => __('Main Menu Background Color _ SubLevel', 'eduonline'),
						'subtitle' => __('Controls the color of the menu sublevel background', 'eduonline'),
						'default'  => array('background-color' => '#448ccb'),
						'validate' => 'color',
						'output' => array('#nav > li ul'),
					),
					
					)
				);
                $this->sections[] = array(
                    'title'  => __( '404 Page', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el el-error',
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_error404_page_id',
                            'type'     => 'select',
                            'title'    => __('Page 404 Template', 'eduonline'),
                            'subtitle' => __('Select 404 page.', 'eduonline'),
                            'options'  => $lists_page
                        ),
                        array(
                            'id'       => 'jws_theme_error404_display_header',
                            'type'     => 'switch',
                            'title'    => __( 'Display Header', 'eduonline' ),
                            'subtitle' => __( 'Display header.', 'eduonline' ),
                            'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_error404_display_top_sidebar',
                            'type'     => 'switch',
                            'title'    => __( 'Display Top Sidebar', 'eduonline' ),
                            'subtitle' => __( 'Display Top Sidebar.', 'eduonline' ),
                            'default'  => false
                        ),
                        array(
                            'id'       => 'jws_theme_error404_display_title',
                            'type'     => 'switch',
                            'title'    => __( 'Display Page title', 'eduonline' ),
                            'subtitle' => __( 'Display Page title.', 'eduonline' ),
                            'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_error404_display_footer',
                            'type'     => 'switch',
                            'title'    => __( 'Display Footer', 'eduonline' ),
                            'subtitle' => __( 'Display Footer.', 'eduonline' ),
                            'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_error404_bg',
                            'type'     => 'background',
                            'title'    => __('404 Page Background', 'eduonline'),
                            'subtitle' => __('404 page background with image, color, etc.', 'eduonline'),
                            'default'  => array(
                                'background-image' => JWS_THEME_URI_PATH.'/assets/images/404-page/404.jpg',
                            ),
                            'output' => array('.tb-error404-wrap'),
                        )
                        
                    )
                    
                );
				/*Footer*/
                $this->sections[] = array(
                    'title'  => __( 'Footer', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-file-edit',
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_display_footer',
                            'type'     => 'switch',
                            'title'    => __( 'Display Footer', 'eduonline' ),
                            'subtitle' => __( 'Display footer.', 'eduonline' ),
                            'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_footer_bg',
                            'type'     => 'background',
                            'title'    => __('Footer Background', 'eduonline'),
                            'subtitle' => __('Footer background with image, color, etc.', 'eduonline'),
                            'default'  => array(
                                'background-color' => '#3d3d47',
                                'background-image' => '',
                                'background-repeat'=>'no-repeat',
                                'background-position'=>'center top',
                            ),
                            'output' => array('.jws_theme_footer'),
                        ),
                        array(
                            'id' => 'jws_theme_footer_margin',
                            'title' => 'Footer Margin',
                            'subtitle' => __('Please, Enter margin of Footer.', 'eduonline'),
                            'type' => 'spacing',
                            'mode' => 'margin',
                            'units' => array('px'),
                            'output' => array('.jws_theme_footer'),
                            'default' => array(
                                'margin-top'     => '0', 
                                'margin-right'   => '0', 
                                'margin-bottom'  => '0', 
                                'margin-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
                        array(
                            'id' => 'jws_theme_footer_padding',
                            'title' => 'Footer Padding',
                            'subtitle' => __('Please, Enter padding of Footer.', 'eduonline'),
                            'type' => 'spacing',
                            'units' => array('px'),
                            'output' => array('.jws_theme_footer'),
                            'default' => array(
                                'padding-top'     => '0', 
                                'padding-right'   => '0', 
                                'padding-bottom'  => '0', 
                                'padding-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
                        
                    )
                    
                );
                $this->sections[] = array(
                    'title'  => __( 'Footer Top', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-file-edit',
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_footer_top_bg',
                            'type'     => 'background',
                            'title'    => __('Footer Background', 'eduonline'),
                            'subtitle' => __('Footer background with image, color, etc.', 'eduonline'),
                            'default'  => array(
                                 'background-color' => 'transparent',
                            ),
                            'output' => array('.jws_theme_footer .footer-top'),
                        ),
                        array(
                            'id' => 'jws_theme_footer_top_margin',
                            'title' => 'Footer Top Margin',
                            'subtitle' => __('Please, Enter margin of Footer Top.', 'eduonline'),
                            'type' => 'spacing',
                            'mode' => 'margin',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-top'),
                            'default' => array(
                                'margin-top'     => '0', 
                                'margin-right'   => '0', 
                                'margin-bottom'  => '0', 
                                'margin-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
                        array(
                            'id' => 'jws_theme_footer_top_padding',
                            'title' => 'Footer Top Padding',
                            'subtitle' => __('Please, Enter padding of Footer Top.', 'eduonline'),
                            'type' => 'spacing',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-top'),
                            'default' => array(
                                'padding-top'     => '60px', 
                                'padding-right'   => '0', 
                                'padding-bottom'  => '20px', 
                                'padding-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
						array(
							'id'       => 'jws_theme_footer_top_column',
							'type'     => 'select',
							'title'    => __('Footer Top Columns', 'eduonline'),
							'subtitle' => __('Select column of footer top.', 'eduonline'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns',
								'3' => '3 Columns'
							),
							'default'  => '1',
						),
						array(
							'id'       => 'jws_theme_footer_top_col1',
							'type'     => 'text',
							'title'    => __('Footer Top Column 1', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-12 col-md-12 col-lg-12 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center',
							'required' => array('jws_theme_footer_top_column','>=','1')
						),
						array(
							'id'       => 'jws_theme_footer_top_col2',
							'type'     => 'text',
							'title'    => __('Footer Top Column 2', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
							'required' => array('jws_theme_footer_top_column','>=','2')
						),
						array(
							'id'       => 'jws_theme_footer_top_col3',
							'type'     => 'text',
							'title'    => __('Footer Top Column 3', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
							'required' => array('jws_theme_footer_top_column','>=','3')
						),
					)
                    
                );
                $this->sections[] = array(
                    'title'  => __( 'Footer Center', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-file-edit',
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_footer_center_bg',
                            'type'     => 'background',
                            'title'    => __('Footer Background', 'eduonline'),
                            'subtitle' => __('Footer background with image, color, etc.', 'eduonline'),
                            'default'  => array(
                                 'background-color' => 'transparent',
                            ),
                            'output' => array('.jws_theme_footer .footer-center'),
                        ),
                        array(
                            'id' => 'jws_theme_footer_center_margin',
                            'title' => 'Footer Center Margin',
                            'subtitle' => __('Please, Enter margin of Footer Center.', 'eduonline'),
                            'type' => 'spacing',
                            'mode' => 'margin',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-center'),
                            'default' => array(
                                'margin-top'     => '46px', 
                                'margin-right'   => '0', 
                                'margin-bottom'  => '90px', 
                                'margin-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
                        array(
                            'id' => 'jws_theme_footer_center_padding',
                            'title' => 'Footer Center Padding',
                            'subtitle' => __('Please, Enter padding of Footer Center.', 'eduonline'),
                            'type' => 'spacing',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-center'),
                            'default' => array(
                                'padding-top'     => '0', 
                                'padding-right'   => '0', 
                                'padding-bottom'  => '0',
                                'padding-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
						array(
							'id'       => 'jws_theme_footer_center_column',
							'type'     => 'select',
							'title'    => __('Footer Center Columns', 'eduonline'),
							'subtitle' => __('Select column of footer center.', 'eduonline'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns',
								'3' => '3 Columns',
								'4' => '4 Columns',
								'5' => '5 Columns'
							),
							'default'  => '4',
						),
						array(
							'id'       => 'jws_theme_footer_center_col1',
							'type'     => 'text',
							'title'    => __('Footer Center Column 1', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
							'required' => array('jws_theme_footer_center_column','>=','1')
						),
						array(
							'id'       => 'jws_theme_footer_center_col2',
							'type'     => 'text',
							'title'    => __('Footer Center Column 2', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-4',
							'required' => array('jws_theme_footer_center_column','>=','2')
						),
						array(
							'id'       => 'jws_theme_footer_center_col3',
							'type'     => 'text',
							'title'    => __('Footer Center Column 3', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-2',
							'required' => array('jws_theme_footer_center_column','>=','3')
						),
						array(
							'id'       => 'jws_theme_footer_center_col4',
							'type'     => 'text',
							'title'    => __('Footer Center Column 4', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
							'required' => array('jws_theme_footer_center_column','>=','4')
						),
						array(
							'id'       => 'jws_theme_footer_center_col5',
							'type'     => 'text',
							'title'    => __('Footer Center Column 5', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-3 col-lg-3 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-3 col-lg-3',
							'required' => array('jws_theme_footer_center_column','>=','5')
						),
                    )
                );
                $this->sections[] = array(
                    'title'  => __( 'Footer Bottom', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-file-edit',
                    'subsection' => true,
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_footer_bottom_bg',
                            'type'     => 'background',
                            'title'    => __('Footer Background', 'eduonline'),
                            'subtitle' => __('Footer background with image, color, etc.', 'eduonline'),
                            'default'  => array(
                                'background-color' => '#252525',
                            ),
                            'output' => array('.jws_theme_footer .footer-bottom'),
                        ),
                        array(
                            'id' => 'jws_theme_footer_bottom_margin',
                            'title' => 'Footer Bottom Margin',
                            'subtitle' => __('Please, Enter margin of Footer Bottom.', 'eduonline'),
                            'type' => 'spacing',
                            'mode' => 'margin',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-bottom'),
                            'default' => array(
                                'margin-top'     => '0', 
                                'margin-right'   => '0', 
                                'margin-bottom'  => '0', 
                                'margin-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
                        array(
                            'id' => 'jws_theme_footer_bottom_padding',
                            'title' => 'Footer Bottom Padding',
                            'subtitle' => __('Please, Enter padding of Footer Bottom.', 'eduonline'),
                            'type' => 'spacing',
                            'units' => array('px'),
                            'output'  => array('.jws_theme_footer .footer-bottom'),
                            'default' => array(
                                'padding-top'     => '20px', 
                                'padding-right'   => '0', 
                                'padding-bottom'  => '20px', 
                                'padding-left'    => '0',
                                'units'          => 'px', 
                            )
                        ),
						array(
							'id'       => 'jws_theme_footer_bottom_column',
							'type'     => 'select',
							'title'    => __('Footer Bottom Columns', 'eduonline'),
							'subtitle' => __('Select column of footer top.', 'eduonline'),
							'options'  => array(
								'1' => '1 Column',
								'2' => '2 Columns'
							),
							'default'  => '1',
						),
						array(
							'id'       => 'jws_theme_footer_bottom_col1',
							'type'     => 'text',
							'title'    => __('Footer Bottom Column 1', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-6 col-lg-6 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center',
							'required' => array('jws_theme_footer_bottom_column','>=','1')
						),
						array(
							'id'       => 'jws_theme_footer_bottom_col2',
							'type'     => 'text',
							'title'    => __('Footer Bottom Column 2', 'eduonline'),
							'subtitle' => __('Please, Enter class bootstrap and extra class. Ex: col-xs-12 col-sm-6 col-md-6 col-lg-6 el-class.', 'eduonline'),
							'default'  => 'col-xs-12 col-sm-6 col-md-6 col-lg-6',
							'required' => array('jws_theme_footer_bottom_column','>=','2')
						),
                    )
                );
                /*Styling Setting*/
                $this->sections[] = array(
                    'title'  => __( 'Styling Options', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-tint',
                    'fields' => array(
                        array(
                            'id'       => 'jws_theme_primary_color',
                            'type'     => 'color',
                            'title'    => __('Primary Color', 'eduonline'),
                            'subtitle' => __('Controls several items, ex: link hovers, highlights, and more. (default: #eaa24e).', 'eduonline'),
                            'default'  => '#448ccb',
                            'validate' => 'color',
                        ),
                    )
                );
				
				/* Typography Setting */
				$this->sections[] = array(
                    'title'  => __( 'Typography', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-font',
                    'fields' => array(
						/*Body font*/
						array(
							'id'          => 'jws_theme_body_font',
							'type'        => 'typography', 
							'title'       => __('Body Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'output'      => array('body'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#898989',
								'font-family' => 'Noto Sans',
								'font-size'   => '13px', 
								'line-height' => '21px',
								'font-weight' => 400,
							),
						),
						array(
							'id'          => 'jws_theme_h1_font',
							'type'        => 'typography', 
							'title'       => __('H1 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h1'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#222222',
								'font-family' => 'Noto Sans',
								'font-size'   => '46px', 
								'line-height' => '40px',
								'font-weight' => 700,
							),
						),
						array(
							'id'          => 'jws_theme_h2_font',
							'type'        => 'typography', 
							'title'       => __('H2 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h2'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#222222', 
								'font-family' => 'Noto Sans', 
								'font-size'   => '30px', 
								'line-height' => '30px',
								'font-weight' => 600,
							),
						),
						array(
							'id'          => 'jws_theme_h3_font',
							'type'        => 'typography', 
							'title'       => __('H3 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h3'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#222222', 
								'font-family' => 'Noto Serif',
								'font-size'   => '26px', 
								'line-height' => '29px',
								'font-weight' => 700,
							),
						),
						array(
							'id'          => 'jws_theme_h4_font',
							'type'        => 'typography', 
							'title'       => __('H4 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h4'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#363636',
								'font-family' => 'Noto Sans',
								'font-size'   => '21px', 
								'line-height' => '36px',
								'font-weight' => 700,
							),
						),
						array(
							'id'          => 'jws_theme_h5_font',
							'type'        => 'typography', 
							'title'       => __('H5 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h5'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#363636',
								'font-family' => 'Noto Serif', 
								'font-size'   => '16px', 
								'line-height' => '21px'
							),
						),
						array(
							'id'          => 'jws_theme_h6_font',
							'type'        => 'typography', 
							'title'       => __('H6 Font Options', 'eduonline'),
							'google'      => true, 
							'font-backup' => true,
							'letter-spacing' => true,
							'output'      => array('body h6'),
							'units'       =>'px',
							'subtitle'    => __('Typography option with each property can be called individually.', 'eduonline'),
							'default'     => array(
								'google'      => true,
								'color'       => '#222222',
								'font-family' => 'Dosis',
								'font-size'   => '14px',
								'line-height' => '17px',
							),
						),
					)
				);
				$this->sections[] = array(
					'title' => __('Extra Fonts', 'eduonline'),
					'icon' => 'el el-fontsize',
					'subsection' => true,
					'fields' => array(
						array(
							'id' => 'google-font-1',
							'type' => 'typography',
							'subtitle' => __('Set font family for content... extend class "font-eduonline-1"', 'eduonline' ),
							'title' => __('Font 1', 'eduonline'),
							'google' => true,
							'font-backup' => false,
							'font-style' => false,
							'color' => false,
							'text-align'=> false,
							'line-height'=>false,
							'font-size'=> false,
							'subsets'=> false,
							'output'=> array('.font-eduonline-1'),
							'default' => array(
								'font-family' => 'Noto Serif',
								'font-weight'=> 700,
							)
						),
						array(
							'id' => 'google-font-2',
							'type' => 'typography',
							'subtitle' => __('Set font family for heading... extend class "font-eduonline-2. Font Noto Serif Normal"', 'eduonline' ),
							'title' => __('Font 2', 'eduonline'),
							'google' => true,
							'font-backup' => false,
							'font-style' => false,
							'color' => false,
							'text-align'=> false,
							'line-height'=>false,
							'font-size'=> false,
							'subsets'=> false,
							'output'=> array('.font-eduonline-2'),
							'default' => array(
								'font-family' => 'Noto Serif',
								'font-weight'=> 400,
							)
						),
						array(
							'id' => 'google-font-3',
							'type' => 'typography',
							'subtitle' => __('Set font family for heading... extend class "font-eduonline-3. Font Oswald Normal"', 'eduonline' ),
							'title' => __('Font 3', 'eduonline'),
							'google' => true,
							'font-backup' => false,
							'font-style' => false,
							'color' => false,
							'text-align'=> false,
							'line-height'=>false,
							'font-size'=> false,
							'subsets'=> false,
							'output'=> array('.font-eduonline-3'),
							'default' => array(
								'font-family' => 'Oswald',
								'font-weight'=> '400',
							)
						),
						array(
							'id' => 'google-font-4',
							'type' => 'typography',
							'subtitle' => __('Set font family for heading... extend class "font-eduonline-3. Font Oswald Bold"', 'eduonline' ),
							'title' => __('Font 4', 'eduonline'),
							'google' => true,
							'font-backup' => false,
							'font-style' => false,
							'color' => false,
							'text-align'=> false,
							'line-height'=>false,
							'font-size'=> false,
							'subsets'=> false,
							'output'=> array('.font-eduonline-4'),
							'default' => array(
								'font-family' => 'Oswald',
								'font-weight'=> '700',
							)
						),
					)
				);
				/* Typography Setting */
				
				/*Title Bar Setting*/
				$this->sections[] = array(
                    'title'  => __( 'Title Bar', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-livejournal',
                    'fields' => array(
						array(
                            'id'       => 'jws_theme_display_page_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show page title', 'eduonline' ),
                            'subtitle' => __( 'Show page title', 'eduonline' ),
                            'default'  => true,
                        ),
						array(
							'id' => 'jws_theme_title_bar_typography',
							'type' => 'typography',
							'title' => __('Typography', 'eduonline'),
							'google' => true,
							'font-backup' => true,
							'all_styles' => true,
							'output'  => array('.title-bar .page-title'),
							'units' => 'px',
							'subtitle' => __('Typography option with title text.', 'eduonline'),
							'default' => array(
								'color' => '#fff',
								'font-style' => 'normal',
								'font-weight' => 700,
								'font-family' => 'Noto Serif',
								'google' => true,
								'font-size' => '24px',
								'line-height' => '48px',
								'text-align' => 'left',
							)
						),
						array(
							'id'       => 'jws_theme_title_bar_bg',
							'type'     => 'background',
							'title'    => __('Background', 'eduonline'),
							'subtitle' => __('background with image, color, etc.', 'eduonline'),
							'default'  => array(
								'background-color' => 'transparent',
								'background-image' => JWS_THEME_URI_PATH.'/assets/images/title_bars/bg-pagetitle.jpg',
								'background-repeat'=>'no-repeat',
								'background-position'=>'center top',
								'background-attachment'=> 'fixed'
							),
							'output' => array('.title-bar'),
						),
						array(
						'id' => 'jws_theme_title_bar_margin',
						'title' => 'Margin',
						'subtitle' => __('Please, Enter margin of title bar.', 'eduonline'),
						'type' => 'spacing',
						'mode' => 'margin',
						'units' => array('px'),
						'output' => array('.title-bar, .title-bar-shop'),
						'default' => array(
						'margin-top'     => '0px', 
						'margin-right'   => '0', 
						'margin-bottom'  => '57px',
						'margin-left'    => '0',
						'units'          => 'px', 
						)
						),
						array(
							'id' => 'jws_theme_title_bar_padding',
							'title' => 'Padding',
							'subtitle' => __('Please, Enter padding of title bar.', 'eduonline'),
							'type' => 'spacing',
							'units' => array('px'),
							'output' => array('.title-bar, .title-bar-shop'),
							'default' => array(
								'padding-top'     => '46px', 
								'padding-right'   => '0', 
								'padding-bottom'  => '23px', 
								'padding-left'    => '0',
								'units'          => 'px', 
							)
						),
						array(
							'id'       => 'jws_theme_page_breadcrumb_delimiter',
							'type'     => 'text',
							'title'    => __('Delimiter', 'eduonline'),
							'subtitle' => __('Please, Enter Delimiter of page breadcrumb in title bar.', 'eduonline'),
							'default'  => '/'
						)
					)
				);
				/* Breadcrumb */
				$this->sections[] = array(
					'title' => __('Breadcrumb', 'eduonline'),
					'icon' => 'el-icon-livejournal',
					// 'subsection' => true,
					'fields' => array(
                        array(
                            'id'       => 'jws_theme_display_breadcrumb',
                            'type'     => 'switch',
                            'title'    => __( 'Show Breadcrumb', 'eduonline' ),
                            'subtitle' => __( 'Show Breadcrumb', 'eduonline' ),
                            'default'  => true,
                        )
					)
				);
				/* Page Setting */
				$this->sections[] = array(
					'title'  => __( 'Page Setting', 'eduonline' ),
					'desc'   => __( '', 'eduonline' ),
					'icon'   => 'el-icon-file-edit',
					'fields' => array(
						array(
                            'id'       => 'jws_theme_show_page_comment',
                            'type'     => 'switch',
                            'title'    => __( 'Show Page Comment', 'eduonline' ),
							'default'  => false,
                        ),
					)
				);
				
				/*Post Setting*/
				$this->sections[] = array(
					'title'  => __( 'Post Setting', 'eduonline' ),
					'desc'   => __( '', 'eduonline' ),
					'icon'   => 'el-icon-file-edit',
					'fields' => array()
				);
				$this->sections[] = array(
                    'title'  => __( 'Archive Post', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array( 
							'id'       => 'jws_theme_blog_layout',
							'type'     => 'image_select',
							'title'    => __('Select Layout', 'eduonline'),
							'subtitle' => __('Select layout of archive post.', 'eduonline'),
							'options'  => array(
								'1col'	=> array(
										'alt'   => '1col',
										'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/1col.png'
									),
								'2cl'	=> array(
											'alt'   => '2cl',
											'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/2cl.png'
										),
								'2cr'	=> array(
											'alt'   => '2cr',
											'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/2cr.png'
										),
							),
							'default' => '2cr'
						),
						
						array(
                            'id'       => 'jws_theme_blog_crop_image',
                            'type'     => 'switch',
                            'title'    => __( 'Crop Image', 'eduonline' ),
                            'subtitle' => __( 'Crop or not crop image of post on your archive post.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
							'id'       => 'jws_theme_blog_image_width',
							'type'     => 'text',
							'title'    => __('Image Width', 'eduonline'),
							'subtitle' => __('Please, Enter the width of image on your archive post. Default: 600.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_blog_crop_image', "=", 1 ),
							'default'  => '870'
						),
						array(
							'id'       => 'jws_theme_blog_image_height',
							'type'     => 'text',
							'title'    => __('Image Height', 'eduonline'),
							'subtitle' => __('Please, Enter the height of image on your archive post. Default: 400.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_blog_crop_image', "=", 1 ),
							'default'  => '430'
						),
						array(
                            'id'       => 'jws_theme_blog_show_post_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Title', 'eduonline' ),
                            'subtitle' => __( 'Show or not title of post on your archive post.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_blog_show_post_info',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Info', 'eduonline' ),
                            'subtitle' => __( 'Show or not info of post on your archive post.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_blog_show_post_desc',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Description', 'eduonline' ),
                            'subtitle' => __( 'Show or not description of post on your archive post.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_blog_post_excerpt_leng',
                            'type'     => 'text',
                            'title'    => __( 'Excerpt Leng', 'eduonline' ),
                            'subtitle' => __( 'Insert the number of words you want to show in the post excerpts.', 'eduonline' ),
							'default'  => '50',
                        ),
						array(
                            'id'       => 'jws_theme_blog_post_excerpt_more',
                            'type'     => 'text',
                            'title'    => __( 'Excerpt More', 'eduonline' ),
                            'subtitle' => __( 'Insert the character of words you want to show in the post excerpts.', 'eduonline' ),
							'default'  => '...',
                        ),
                        array(
                            'id'       => 'jws_theme_blog_post_readmore',
                            'type'     => 'text',
                            'title'    => __( 'Read More Link', 'eduonline' ),
                            'subtitle' => __( 'Enter name of readmore link', 'eduonline' ),
                            'default'  => __( 'Read More >>', 'eduonline' ),
                        ),
					)
				);
				$this->sections[] = array(
                    'title'  => __( 'Single Post', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => '',
					'subsection' => true,
                    'fields' => array(
						array( 
							'id'       => 'jws_theme_post_layout',
							'type'     => 'image_select',
							'title'    => __('Select Layout', 'eduonline'),
							'subtitle' => __('Select layout of single blog.', 'eduonline'),
							'options'  => array(
								'1col'	=> array(
										'alt'   => '1col',
										'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/1col.png'
									),
								'2cl'	=> array(
											'alt'   => '2cl',
											'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/2cl.png'
										),
								'2cr'	=> array(
											'alt'   => '2cr',
											'img'   => JWS_THEME_URI_PATH_ADMIN.'/assets/images/2cr.png'
										),
							),
							'default' => '2cr'
						),
						array(
                            'id'       => 'jws_theme_post_crop_image',
                            'type'     => 'switch',
                            'title'    => __( 'Crop Image', 'eduonline' ),
                            'subtitle' => __( 'Crop or not crop image of post on your single blog.', 'eduonline' ),
							'default'  => false,
                        ),
						array(
							'id'       => 'jws_theme_post_image_width',
							'type'     => 'text',
							'title'    => __('Image Width', 'eduonline'),
							'subtitle' => __('Please, Enter the width of image on your single blog. Default: 1170.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_post_crop_image', "=", 1 ),
							'default'  => '1170'
						),
						array(
							'id'       => 'jws_theme_post_image_height',
							'type'     => 'text',
							'title'    => __('Image Height', 'eduonline'),
							'subtitle' => __('Please, Enter the height of image on your single blog. Default: 480.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_post_crop_image', "=", 1 ),
							'default'  => '480'
						),
						array(
                            'id'       => 'jws_theme_post_show_post_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Title', 'eduonline' ),
                            'subtitle' => __( 'Show or not title of post on your single blog.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_social_share',
                            'type'     => 'switch',
                            'title'    => __( 'Show Social Share', 'eduonline' ),
                            'subtitle' => __( 'Show or not social share of post on your single blog.', 'eduonline' ),
							'default'  => false,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_post_info',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Info', 'eduonline' ),
                            'subtitle' => __( 'Show or not info of post on your single blog.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_post_tags',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Tags', 'eduonline' ),
                            'subtitle' => __( 'Show or not post tags on your single blog.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_post_author',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Author', 'eduonline' ),
                            'subtitle' => __( 'Show or not post author on your single blog.', 'eduonline' ),
							'default'  => true,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_post_comment',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Comment', 'eduonline' ),
                            'subtitle' => __( 'Show or not post comment on your single blog.', 'eduonline' ),
							'default'  => true,
                        ),
                        array(
                            'id'       => 'jws_theme_post_show_post_about_author',
                            'type'     => 'switch',
                            'title'    => __( 'Show About Author', 'eduonline' ),
                            'subtitle' => __( 'Show or not about author on your single blog.', 'eduonline' ),
                            'default'  => false,
                        ),
						array(
                            'id'       => 'jws_theme_post_show_post_related',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Related', 'eduonline' ),
                            'subtitle' => __( 'Show or not post related on your single blog.', 'eduonline' ),
							'default'  => false,
                        ),
                        array(
                            'id'       => 'jws_theme_post_no_post_related',
                            'type'     => 'text',
                            'title'    => __( 'Number Post on Related', 'eduonline' ),
                            'subtitle' => __( 'Enter number post related on your single blog.', 'eduonline' ),
                            'default'  => 3,
                        )
					)
				);
			
                $this->sections[] = array(
                    'title'  => __( 'Single Portfolio', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => '',
                    'subsection' => true,
                    'fields' => array(
                       
                        array(
                            'id'       => 'jws_theme_portfolio_show_post_title',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Title', 'eduonline' ),
                            'subtitle' => __( 'Show or not title of post on your single porfolio.', 'eduonline' ),
                            'default'  => true,
                        ),
                        array(
                            'id'       => 'jws_theme_portfolio_show_post_content',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Content', 'eduonline' ),
                            'subtitle' => __( 'Show or not content of post on your single porfolio.', 'eduonline' ),
                            'default'  => true,
                        ),
                        array(
                            'id'       => 'jws_theme_portfolio_show_post_comment',
                            'type'     => 'switch',
                            'title'    => __( 'Show Post Comment', 'eduonline' ),
                            'subtitle' => __( 'Show or not post comment on your single porfolio.', 'eduonline' ),
                            'default'  => false,
                        ),
						array(
                            'id'       => 'jws_theme_portfolio_crop_image',
                            'type'     => 'switch',
                            'title'    => __( 'Crop Image', 'eduonline' ),
                            'subtitle' => __( 'Crop or not crop image of post on your single blog.', 'eduonline' ),
							'default'  => false,
                        ),
						array(
							'id'       => 'jws_theme_portfolio_image_width',
							'type'     => 'text',
							'title'    => __('Image Width', 'eduonline'),
							'subtitle' => __('Please, Enter the width of image on your single blog. Default: 572.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_post_crop_image', "=", 1 ),
							'default'  => '572'
						),
						array(
							'id'       => 'jws_theme_portfolio_image_height',
							'type'     => 'text',
							'title'    => __('Image Height', 'eduonline'),
							'subtitle' => __('Please, Enter the height of image on your single blog. Default: 418.', 'eduonline'),
							'indent'   => true,
                            'required' => array( 'jws_theme_post_crop_image', "=", 1 ),
							'default'  => '418'
						),
                    )
                );
				
				/*Shop Setting*/
				if (class_exists ( 'Woocommerce' )) {
					$this->sections[] = array(
						'title'  => __( 'Shop Setting', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => 'el-icon-shopping-cart',
						'fields' => array(
							
						)
						
					);$this->sections[] = array(
						'title'  => __( 'Archive Products', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'jws_theme_archive_sidebar_pos_shop',
								'type'     => 'select',
								'title'    => __('Sidebar Position (Shop layout)', 'eduonline'),
								'subtitle' => __('Select sidebar position in page archive products.', 'eduonline'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right',
                                    'tb-sidebar-hidden' =>'Hide sidebar (Shop fullwidth)'
								),
								'default'  => 'tb-sidebar-left',
							),
                            array(
                                'id'       => 'jws_theme_archive_shop_column',
                                'type'     => 'select',
                                'title'    => __('Products Per Row', 'eduonline'),
                                'subtitle' => __('Change products number display per row for the Shop page'),
                                'options'  => array(
                                    "4" => __("4 Products",'eduonline'),
                                    "3" => __("3 Products",'eduonline'),

                                    "2" => __("2 Products",'eduonline'),

                                    "1" => __("1 Column",'eduonline'),
                                ),
                                'default'  => '3',
                            ),
                            array(
                                'id'       => 'jws_theme_archive_shop_ful_column',
                                'type'     => 'select',
                                'title'    => __('Products Per Row For Layout Fullwidth', 'eduonline'),
                                'subtitle' => __('Change products number display per row for the Shop page( fullwidth layout )'),
                                'options'  => array(
                                    "4" => __("4 Products",'eduonline'),
                                    "3" => __("3 Products",'eduonline'),
                                    "2" => __("2 Products",'eduonline'),
                                    "1" => __("1 Column",'eduonline'),
                                ),
                                'default'  => '4',
                            ),
                            array(
                                'id'       => 'jws_theme_archive_shop_per_page',
                                'type'     => 'text',
                                'title'    => __( 'Products Per Page', 'eduonline' ),
                                'subtitle' => __( 'Enter number products per page.', 'eduonline' ),
                                'default'  => 9,
                            ),
							array(
								'id'       => 'jws_theme_archive_show_result_count',
								'type'     => 'switch',
								'title'    => __( 'Show Result Count', 'eduonline' ),
								'subtitle' => __( 'Show result count in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_catalog_ordering',
								'type'     => 'switch',
								'title'    => __( 'Show Catalog Ordering', 'eduonline' ),
								'subtitle' => __( 'Show catalog ordering in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_pagination_shop',
								'type'     => 'switch',
								'title'    => __( 'Show Pagination', 'eduonline' ),
								'subtitle' => __( 'Show pagination in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_title_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Title', 'eduonline' ),
								'subtitle' => __( 'Show product title in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_price_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Price', 'eduonline' ),
								'subtitle' => __( 'Show product price in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_rating_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Rating', 'eduonline' ),
								'subtitle' => __( 'Show product rating in page archive products.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_sale_flash_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Sale Flash', 'eduonline' ),
								'subtitle' => __( 'Show product sale flash in page archive products.', 'eduonline' ),
								'default'  => true,
							),
                            array(
                                'id'       => 'jws_theme_archive_show_cat_product',
                                'type'     => 'switch',
                                'title'    => __( 'Show Product Category', 'eduonline' ),
                                'subtitle' => __( 'Show product Catogry in page archive products.', 'eduonline' ),
                                'default'  => true
                            ),
							array(
								'id'       => 'jws_theme_archive_show_add_to_cart_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Add To Cart', 'eduonline' ),
								'subtitle' => __( 'Show product add to cart in page archive products.', 'eduonline' ),
								'default'  => true,
							),
                            array(
                                'id'       => 'jws_theme_archive_show_quick_view_product',
                                'type'     => 'switch',
                                'title'    => __( 'Show Product Quick View', 'eduonline' ),
                                'subtitle' => __( 'Show product quick view in page archive products.', 'eduonline' ),
                                'default'  => true,
                            ),
                            array(
                                'id'       => 'jws_theme_archive_show_whishlist_product',
                                'type'     => 'switch',
                                'title'    => __( 'Show Product Wish List', 'eduonline' ),
                                'subtitle' => __( 'Show product wish lish in page archive products.', 'eduonline' ),
                                'default'  => true,
                            ),
                            array(
                                'id'       => 'jws_theme_archive_show_compare_product',
                                'type'     => 'switch',
                                'title'    => __( 'Show Product Compare', 'eduonline' ),
                                'subtitle' => __( 'Show product compare in page archive products.', 'eduonline' ),
                                'default'  => true,
                            ),
                             array(
                                'id'       => 'jws_theme_archive_show_color_attribute',
                                'type'     => 'switch',
                                'title'    => __( 'Show Color Attribute', 'eduonline' ),
                                'subtitle' => __( 'Show color attribute in page archive products.', 'eduonline' ),
                                'default'  => false
                            ),
						)
					);
					$this->sections[] = array(
						'title'  => __( 'Single Product', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'jws_theme_single_sidebar_pos_shop',
								'type'     => 'select',
								'title'    => __('Sidebar Position', 'eduonline'),
								'subtitle' => __('Select sidebar position in page single product.', 'eduonline'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right',
                                    'tb-sidebar-hidden' =>'Hide sidebar (single fullwidth)'
								),
								'default'  => 'tb-sidebar-right',
							),
							array(
								'id'       => 'jws_theme_single_show_title_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Title', 'eduonline' ),
								'subtitle' => __( 'Show product title in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_price_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Price', 'eduonline' ),
								'subtitle' => __( 'Show product price in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_rating_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Rating', 'eduonline' ),
								'subtitle' => __( 'Show product rating in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_sale_flash_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Sale Flash', 'eduonline' ),
								'subtitle' => __( 'Show product sale flash in page single product.', 'eduonline' ),
								'default'  => true,
							),
                            array( 
                                'id'       => 'jws_theme_video_tab',
                                'type'     => 'select',
                                    'title'    => __('How to display video tab?', 'eduonline'),
                                    'options'  => array(
                                        'none'=>__('Hidden', 'eduonline'),
                                        'on_tabs'=>__('Show in Woocommerce tabs', 'eduonline'),
                                        'on_thumbnail'=>__('Show on product thumbnails', 'eduonline')
                                    ),
                                    'default'  => 'on_thumbnail'
                            ),
							array(
								'id'       => 'jws_theme_single_show_excerpt',
								'type'     => 'switch',
								'title'    => __( 'Show Product Excerpt', 'eduonline' ),
								'subtitle' => __( 'Show product excerpt in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_add_to_cart_product',
								'type'     => 'switch',
								'title'    => __( 'Show Product Add To Cart', 'eduonline' ),
								'subtitle' => __( 'Show product add to cart in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_meta',
								'type'     => 'switch',
								'title'    => __( 'Show Product Meta', 'eduonline' ),
								'subtitle' => __( 'Show product meta in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_data_tabs',
								'type'     => 'switch',
								'title'    => __( 'Show Product Data Tabs', 'eduonline' ),
								'subtitle' => __( 'Show product data tabs in page single product.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_related_products',
								'type'     => 'switch',
								'title'    => __( 'Show Product Related Products', 'eduonline' ),
								'subtitle' => __( 'Show product related products in page single product.', 'eduonline' ),
								'default'  => true,
							),
						)
					);
				}
				
				/*Learn press Setting*/
				if (class_exists ( 'LearningOnline' )) {
					$this->sections[] = array(
						'title'  => __( 'Learning Setting', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => 'el el-book',
						'fields' => array(
							
						)
						
					);$this->sections[] = array(
						'title'  => __( 'Archive Courses', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'jws_theme_archive_sidebar_pos_course',
								'type'     => 'select',
								'title'    => __('Sidebar Position (Course layout)', 'eduonline'),
								'subtitle' => __('Select sidebar position in page archive course.', 'eduonline'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right',
                                    'tb-sidebar-hidden' =>'Hide sidebar (Course fullwidth)'
								),
								'default'  => 'tb-sidebar-left',
							),
                            array(
                                'id'       => 'jws_theme_archive_course_column',
                                'type'     => 'select',
                                'title'    => __('Courses Per Row', 'eduonline'),
                                'subtitle' => __('Change course number display per row for the course page'),
                                'options'  => array(
                                    "4" => __("4 Courses",'eduonline'),
                                    "3" => __("3 Courses",'eduonline'),

                                    "2" => __("2 Courses",'eduonline'),

                                    "1" => __("1 Course - List item",'eduonline'),
                                ),
                                'default'  => '3',
                            ),
                           
							array(
								'id'       => 'jws_theme_archive_show_pagination_shop',
								'type'     => 'switch',
								'title'    => __( 'Show Pagination', 'eduonline' ),
								'subtitle' => __( 'Show pagination in page archive courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_title_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Title', 'eduonline' ),
								'subtitle' => __( 'Show course title in page archive Courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
                            'id'       => 'jws_theme_archive_show_excerpt_course',
                            'type'     => 'switch',
                            'title'    => __( 'Show Course Excerpt', 'eduonline' ),
                            'subtitle' => __( 'Show or not show excerpt of course on your archive courses.', 'eduonline' ),
							'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_excerpt_lenght',
								'type'     => 'text',
								'title'    => __('Excerpt length', 'eduonline'),
								'subtitle' => __('Please, Enter excerpt length of course on your archive courses. Default: 15.', 'eduonline'),
								'indent'   => true,
								'required' => array( 'jws_theme_archive_show_excerpt_course', "=", 1 ),
								'default'  => '15'
							),
							array(
								'id'       => 'jws_theme_archive_excerpt_lenght_list',
								'type'     => 'text',
								'title'    => __('Excerpt length for list course item', 'eduonline'),
								'subtitle' => __('Please, Enter excerpt length of list course on your archive courses. Default: 35.', 'eduonline'),
								'indent'   => true,
								'required' => array( 'jws_theme_archive_course_column', "=", "1" ),
								'default'  => '35'
							),
							array(
								'id'       => 'jws_theme_archive_excerpt_more',
								'type'     => 'text',
								'title'    => __('Excerpt more', 'eduonline'),
                                'subtitle' => __('Please, Enter excerpt more of course on your archive courses.', 'eduonline'),
								'indent'   => true,
								'required' => array( 'jws_theme_archive_show_excerpt_course', "=", 1 ),
								'default'  => ''
							),
							array(
								'id'       => 'jws_theme_archive_show_price_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Price', 'eduonline' ),
								'subtitle' => __( 'Show course price in page archive courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_date_course',
								'type'     => 'switch',
								'title'    => __( 'Show Date', 'eduonline' ),
								'subtitle' => __( 'Show date of course on page archive courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_lession',
								'type'     => 'switch',
								'title'    => __( 'Show Lession', 'eduonline' ),
								'subtitle' => __( 'Show lession of course on page archive courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_archive_show_duration_time',
								'type'     => 'switch',
								'title'    => __( 'Show Duration Time', 'eduonline' ),
								'subtitle' => __( 'Show duration time of course on page archive courses.', 'eduonline' ),
								'default'  => true,
							),
						
							array(
								'id'       => 'jws_theme_archive_show_add_to_cart_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Add To Cart', 'eduonline' ),
								'subtitle' => __( 'Show course add to cart in page archive courses.', 'eduonline' ),
								'default'  => true,
							),
                           
						)
					);
					$this->sections[] = array(
						'title'  => __( 'Single Course', 'eduonline' ),
						'desc'   => __( '', 'eduonline' ),
						'icon'   => '',
						'subsection' => true,
						'fields' => array(
							array(
								'id'       => 'jws_theme_single_sidebar_pos_course',
								'type'     => 'select',
								'title'    => __('Sidebar Position', 'eduonline'),
								'subtitle' => __('Select sidebar position in page single course.', 'eduonline'),
								'options'  => array(
									'tb-sidebar-left' => 'Left',
									'tb-sidebar-right' => 'Right',
                                    'tb-sidebar-hidden' =>'Hide sidebar (single fullwidth)'
								),
								'default'  => 'tb-sidebar-right',
							),
							array(
								'id'       => 'jws_theme_single_show_title_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Title', 'eduonline' ),
								'subtitle' => __( 'Show course title in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_price_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Price', 'eduonline' ),
								'subtitle' => __( 'Show course price in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_date_course',
								'type'     => 'switch',
								'title'    => __( 'Show Date', 'eduonline' ),
								'subtitle' => __( 'Show date of course on page single courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_lession',
								'type'     => 'switch',
								'title'    => __( 'Show Lession', 'eduonline' ),
								'subtitle' => __( 'Show lession of course on page single courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_duration_time',
								'type'     => 'switch',
								'title'    => __( 'Show Duration Time', 'eduonline' ),
								'subtitle' => __( 'Show duration time of course on page single courses.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_excerpt_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Excerpt', 'eduonline' ),
								'subtitle' => __( 'Show course excerpt in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_excerpt_lenght',
								'type'     => 'text',
								'title'    => __('Excerpt length', 'eduonline'),
								'subtitle' => __('Please, Enter excerpt length of course on your single courses. Default: 55.', 'eduonline'),
								'indent'   => true,
								'required' => array( 'jws_theme_single_show_excerpt_course', "=", 1 ),
								'default'  => '55'
							),
							array(
								'id'       => 'jws_theme_single_excerpt_more',
								'type'     => 'text',
								'title'    => __('Excerpt more', 'eduonline'),
                                'subtitle' => __('Please, Enter excerpt more of course on your single courses.', 'eduonline'),
								'indent'   => true,
								'required' => array( 'jws_theme_single_show_excerpt_course', "=", 1 ),
								'default'  => ''
							),
							array(
								'id'       => 'jws_theme_single_show_add_to_cart_course',
								'type'     => 'switch',
								'title'    => __( 'Show Course Add To Cart', 'eduonline' ),
								'subtitle' => __( 'Show course add to cart in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_course_show_meta',
								'type'     => 'switch',
								'title'    => __( 'Show Course Meta', 'eduonline' ),
								'subtitle' => __( 'Show course meta in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_course_show_data_tabs',
								'type'     => 'switch',
								'title'    => __( 'Show Course Data Tabs', 'eduonline' ),
								'subtitle' => __( 'Show course data tabs in page single course.', 'eduonline' ),
								'default'  => true,
							),
							array(
								'id'       => 'jws_theme_single_show_related_courses',
								'type'     => 'switch',
								'title'    => __( 'Show Course Related Courses', 'eduonline' ),
								'subtitle' => __( 'Show course related courses in page single course.', 'eduonline' ),
								'default'  => true,
							),
						)
					);
				}
				/*Custom CSS*/
				$this->sections[] = array(
                    'title'  => __( 'Custom CSS', 'eduonline' ),
                    'desc'   => __( '', 'eduonline' ),
                    'icon'   => 'el-icon-css',
                    'fields' => array(
						array(
							'id'       => 'custom_css_code',
							'type'     => 'ace_editor',
							'title'    => __('Custom CSS Code', 'eduonline'),
							'subtitle' => __('Quickly add some CSS to your theme by adding it to this block..', 'eduonline'),
							'mode'     => 'css',
							'theme'    => 'monokai',
							'default'  => ''
						)
					)
					
				);
				/*Import / Export*/
				$this->sections[] = array(
                    'title'  => __( 'Import / Export', 'eduonline' ),
                    'desc'   => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'eduonline' ),
                    'icon'   => 'el-icon-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'jws_theme_import_export',
                            'type'       => 'import_export',
                            'title'      => 'Import Export',
                            'subtitle'   => __('Save and restore your Redux options','eduonline'),
                            'full_width' => false,
                        ),
						array (
							'id'            => 'jws_theme_import',
							'type'          => 'js_button',
							'title'         => 'One Click Demo Import.',                         
                            'subtitle'   => __('Appearance > Import Demo Data.','eduonline'),
						),
                    ),
                );
				
            }

            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'eduonline' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'eduonline' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'eduonline' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'eduonline' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'eduonline' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'jws_theme_options',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Options', 'eduonline' ),
                    'page_title'           => __( 'Theme Options', 'eduonline' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => false,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'jws_theme_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'                => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );
				
                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => '#',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el-icon-linkedin'
                );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_theme_config();
    } else {
        echo "The class named Redux_Framework_theme_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;


    if( ! function_exists('jws_theme_get_option') ){
        function jws_theme_get_option($name, $default=false){
            global $jws_theme_options;
            return isset( $jws_theme_options[ $name ] ) ? $jws_theme_options[ $name ] : $default;
        }
    }

    if( ! function_exists('jws_theme_update_option') ){
        function jws_theme_update_option($name, $value){
            global $jws_theme_options;
            $jws_theme_options[ $name ] = $value;
        }
    }

