<?php
class JWS_Map_Widget extends RO_Widget {
	public function __construct() {
		$this->widget_cssclass    = 'tb-map-widget';
		$this->widget_description = esc_html__( 'Maps widget.', 'eduonline' );
		$this->widget_id          = 'jws_map_widget';
		$this->widget_name        = esc_html__( '@Education map', 'eduonline' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'Contact', 'eduonline' ),
				'label' => esc_html__( 'Title', 'eduonline' )
			),
			'api_key'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'AIzaSyCyuW48kPjku1h6fle8WYwO1pKI3Hdp4wk', 'eduonline' ),
				"label" => __('Enter you api key of map, get key from (https://console.developers.google.com)', 'eduonline')
			),
			'address'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'New York, United States', 'eduonline' ),
				'label' => esc_html__( 'Address', 'eduonline' )
			),
			'coordinate'  => array(
				'type'  => 'text',
				'std'   => esc_html__( '', 'eduonline' ),
				'label' => esc_html__( 'Enter coordinate of Map, format input (latitude, longitude)', 'eduonline' )
			),
			'map_type' => array(
				'type'  => 'select',
				'std'   => 'ROADMAP',
				'label' => esc_html__( 'Select the map type.', 'eduonline' ),
				'options' => array(
					'ROADMAP'   => esc_html__( 'ROADMAP', 'eduonline' ),
					'HYBRID'  => esc_html__( 'HYBRID', 'eduonline' ),
					'SATELLITE'   => esc_html__( 'SATELLITE', 'eduonline' ),
					'TERRAIN'  => esc_html__( 'TERRAIN', 'eduonline' ),
				)
			),
			'zoom' => array(
				'type'  => 'number',
				'std'   => 3,
				'label' => esc_html__( 'Number of map zoom to show', 'eduonline' )
			),
			'width'  => array(
				'type'  => 'text',
				'std'   => esc_html__( 'auto', 'eduonline' ),
				'label' => esc_html__( 'Width of this map ', 'eduonline' )
			),
			'height'  => array(
				'type'  => 'text',
				'std'   => esc_html__( '135', 'eduonline' ),
				'label' => esc_html__( 'Height of this map', 'eduonline' )
			),
			
			'el_class'  => array(
				'type'  => 'text',
				'std'   => '',
				'label' => esc_html__( 'Extra Class', 'eduonline' )
			)
		);
		parent::__construct();
		add_action('admin_enqueue_scripts', array($this, 'widget_scripts'));
	}
        
	public function widget_scripts() {
		wp_enqueue_script('widget_scripts', get_template_directory_uri() . '/framework/widgets/widgets.js');
	}

	public function widget( $args, $instance ) {
		
		if ( $this->get_cached_widget( $args ) )
			return;

		ob_start();
		extract( $args );
                
		$title                  = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$zoom         = absint( $instance['zoom'] );
		$api_key                = sanitize_title( $instance['api_key'] );
		$address = !empty($instance['address']) ? esc_attr($instance['address']) : '';
		$type = !empty($instance['map_type']) ? esc_attr($instance['map_type']) : '';
		$width = !empty($instance['width']) ? esc_attr($instance['width']) : '';
		$height = !empty($instance['height']) ? esc_attr($instance['height']) : '135px';
		$coordinate = !empty($instance['coordinate']) ? esc_attr($instance['coordinate']) : '';

		$el_class               = sanitize_title( $instance['el_class'] );
        $style = "";        
                echo jws_theme_filtercontent($before_widget);

                if ( $title )
                        echo jws_theme_filtercontent($before_title . $title . $after_title);
                
                /* API Key */
				if( empty($api) ){
					$api = 'AIzaSyCyuW48kPjku1h6fle8WYwO1pKI3Hdp4wk';
				}
				$api_js = "https://maps.googleapis.com/maps/api/js?key=$api&sensor=false";
				wp_enqueue_script('maps-googleapis',$api_js,array(),'3.0.0');
				wp_enqueue_script('maps-apiv3', JWS_THEME_URI_PATH_FR . "/shortcodes/map_v3/maps.js",array(),'1.0.0');
				/* Map Style defualt */
				$map_styles = array(
					'Subtle-Grayscale'=>'[{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}]',
					'Shades-of-Grey'=>'[{"featureType":"all","elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#000000"},{"lightness":40}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#000000"},{"lightness":16}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":17},{"weight":1.2}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":20}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":21}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#000000"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#000000"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":16}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":19}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"},{"lightness":17}]}]',
					'Blue-water'=>'[{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#46bcec"},{"visibility":"on"}]}]',
					'Pale-Dawn'=>'[{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"lightness":33}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2e5d4"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#c5dac6"}]},{"featureType":"poi.park","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#c5c6c6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#e4d7c6"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#fbfaf7"}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"color":"#acbcc9"}]}]',
					'Blue-Essence'=>'[{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"color":"#e0efef"}]},{"featureType":"poi","elementType":"geometry.fill","stylers":[{"visibility":"on"},{"hue":"#1900ff"},{"color":"#c0e8e8"}]},{"featureType":"road","elementType":"geometry","stylers":[{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"visibility":"on"},{"lightness":700}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#7dcdcd"}]}]',
					'Apple-Maps-esque'=>'[{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#f7f1df"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#d0e3b4"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#fbd3da"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#bde6ab"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffe15f"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#efd151"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#a2daf2"}]}]',
				);
				/* Select Template */
				$map_template = '';
				switch ($style){
					case '':
						$map_template = '';
						break;
					default:
						$map_template = rawurlencode($map_styles[$style]);
						break;
				}
				/* marker render */
				$markercoordinate  = $coordinate;
				$markerlist = $infowidth = $markericon = $markertitle = $markerdesc ="";
				$marker = new stdClass();
				if($markercoordinate){
					$marker->markercoordinate = $markercoordinate;
					if($markerdesc || $markertitle){
					$marker->markerdesc = 	'<div class="ro-maps-info-content">'.
											'<h5>'.$markertitle.'</h5>'.
											'<span>'.$markerdesc.'</span>'.
											'</div>';
					}
					if($markericon){
						$marker->markericon = wp_get_attachment_url($markericon);
					}
				}
				if($markerlist){
					$marker->markerlist = $markerlist;
				}
				$scrollwheel = $pancontrol = $maptypecontrol = $overviewmapcontrol = $infoclick = false;
				$zoomcontrol = $scalecontrol = $streetviewcontrol = true;
				$marker = rawurlencode(json_encode($marker));
				/* control render */
				$controls = new stdClass();
				if($scrollwheel == true){ $controls->scrollwheel = 1; } else { $controls->scrollwheel = 0; }
				if($pancontrol == true){ $controls->pancontrol = true; } else { $controls->pancontrol = false; }
				if($zoomcontrol == true){ $controls->zoomcontrol = true; } else { $controls->zoomcontrol = false; }
				if($scalecontrol == true){ $controls->scalecontrol = true; } else { $controls->scalecontrol = false; }
				if($maptypecontrol == true){ $controls->maptypecontrol = true; } else { $controls->maptypecontrol = false; }
				if($streetviewcontrol == true){ $controls->streetviewcontrol = true; } else { $controls->streetviewcontrol = false; }
				if($overviewmapcontrol == true){ $controls->overviewmapcontrol = true; } else { $controls->overviewmapcontrol = false; }
				if($infoclick == true){ $controls->infoclick = true; } else { $controls->infoclick = false; }
				$controls->infowidth = $infowidth;
				$controls->style = $style;
				$controls = rawurlencode(json_encode($controls));
				/* data render */
				$setting = array(
					"data-address='$address'",
					"data-marker='$marker'",
					"data-coordinate='$coordinate'",
					"data-type='$type'",
					"data-zoom='$zoom'",
					"data-template='$map_template'",
					"data-controls='$controls'"
				);
				
                $maps_id = uniqid('maps-');
				?>
				<div class="ro_maps">
					<div id="<?php echo $maps_id; ?>" class="maps-render" <?php echo implode(' ', $setting); ?> style="width:<?php echo esc_attr($width); ?>;height: <?php echo esc_attr($height); ?>"></div>
				</div>
				<?php

                echo jws_theme_filtercontent($after_widget);
                
		$content = ob_get_clean();

		echo jws_theme_filtercontent($content);

		$this->cache_widget( $args, $content );
	}
}
/* Class TB_Post_List_Widget */
function register_map_widget() {
    register_widget('JWS_Map_Widget');
}

add_action('widgets_init', 'register_map_widget');
