<?php
vc_map(array(
    "name" => 'Google Maps V3',
    "base" => "maps",
    "category" => __('Eduonline', 'eduonline'),
	"icon" => "tb-icon-for-vc",
    "description" => __('Google Maps API V3', 'eduonline'),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __('API Key', 'eduonline'),
            "param_name" => "api",
            "value" => '',
            "description" => __('Enter you api key of map, get key from (https://console.developers.google.com)', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Address', 'eduonline'),
            "param_name" => "address",
            "value" => 'New York, United States',
            "description" => __('Enter address of Map', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Coordinate', 'eduonline'),
            "param_name" => "coordinate",
            "value" => '',
            "description" => __('Enter coordinate of Map, format input (latitude, longitude)', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Click Show Info window', 'eduonline'),
            "param_name" => "infoclick",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Marker", 'eduonline'),
            "description" => __('Click a marker and show info window (Default Show).', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Marker Coordinate', 'eduonline'),
            "param_name" => "markercoordinate",
            "value" => '',
            "group" => __("Marker", 'eduonline'),
            "description" => __('Enter marker coordinate of Map, format input (latitude, longitude)', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Marker Title', 'eduonline'),
            "param_name" => "markertitle",
            "value" => '',
            "group" => __("Marker", 'eduonline'),
            "description" => __('Enter Title Info windows for marker', 'eduonline')
        ),
        array(
            "type" => "textarea",
            "heading" => __('Marker Description', 'eduonline'),
            "param_name" => "markerdesc",
            "value" => '',
            "group" => __("Marker", 'eduonline'),
            "description" => __('Enter Description Info windows for marker', 'eduonline')
        ),
        array(
            "type" => "attach_image",
            "heading" => __('Marker Icon', 'eduonline'),
            "param_name" => "markericon",
            "value" => '',
            "group" => __("Marker", 'eduonline'),
            "description" => __('Select image icon for marker', 'eduonline')
        ),
        array(
            "type" => "textarea_raw_html",
            "heading" => __('Marker List', 'eduonline'),
            "param_name" => "markerlist",
            "value" => '',
            "group" => __("Multiple Marker", 'eduonline'),
            "description" => __('[{"coordinate":"41.058846,-73.539423","icon":"","title":"title demo 1","desc":"desc demo 1"},{"coordinate":"40.975699,-73.717636","icon":"","title":"title demo 2","desc":"desc demo 2"},{"coordinate":"41.082606,-73.469718","icon":"","title":"title demo 3","desc":"desc demo 3"}]', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Info Window Max Width', 'eduonline'),
            "param_name" => "infowidth",
            "value" => '200',
            "group" => __("Marker", 'eduonline'),
            "description" => __('Set max width for info window', 'eduonline')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Map Type", 'eduonline'),
            "param_name" => "type",
            "value" => array(
                "ROADMAP" => "ROADMAP",
                "HYBRID" => "HYBRID",
                "SATELLITE" => "SATELLITE",
                "TERRAIN" => "TERRAIN"
            ),
            "description" => __('Select the map type.', 'eduonline')
        ),
        array(
            "type" => "dropdown",
            "heading" => __("Style Template", 'eduonline'),
            "param_name" => "style",
            "value" => array(
                "Default" => "",
                "Subtle Grayscale" => "Subtle-Grayscale",
                "Shades of Grey" => "Shades-of-Grey",
                "Blue water" => "Blue-water",
                "Pale Dawn" => "Pale-Dawn",
                "Blue Essence" => "Blue-Essence",
                "Apple Maps-esque" => "Apple-Maps-esque",
            ),
            "group" => __("Map Style", 'eduonline'),
            "description" => 'Select your heading size for title.'
        ),
        array(
            "type" => "textfield",
            "heading" => __('Zoom', 'eduonline'),
            "param_name" => "zoom",
            "value" => '13',
            "description" => __('zoom level of map, default is 13', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Width', 'eduonline'),
            "param_name" => "width",
            "value" => 'auto',
            "description" => __('Width of map without pixel, default is auto', 'eduonline')
        ),
        array(
            "type" => "textfield",
            "heading" => __('Height', 'eduonline'),
            "param_name" => "height",
            "value" => '350px',
            "description" => __('Height of map without pixel, default is 350px', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Scroll Wheel', 'eduonline'),
            "param_name" => "scrollwheel",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('If false, disables scrollwheel zooming on the map. The scrollwheel is disable by default.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Pan Control', 'eduonline'),
            "param_name" => "pancontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Pan control.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Zoom Control', 'eduonline'),
            "param_name" => "zoomcontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Zoom Control.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Scale Control', 'eduonline'),
            "param_name" => "scalecontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Scale Control.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Map Type Control', 'eduonline'),
            "param_name" => "maptypecontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Map Type Control.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Street View Control', 'eduonline'),
            "param_name" => "streetviewcontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Street View Control.', 'eduonline')
        ),
        array(
            "type" => "checkbox",
            "heading" => __('Over View Map Control', 'eduonline'),
            "param_name" => "overviewmapcontrol",
            "value" => array(
                __("Yes, please", 'eduonline') => true
            ),
            "group" => __("Controls", 'eduonline'),
            "description" => __('Show or hide Over View Map Control.', 'eduonline')
        )
    )
));