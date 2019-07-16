<?php
/**
 * Plugin Name: Yandex Maps API
 * Plugin URI: http://xn--80aegccaes4apfcakpli6e.xn--p1ai/yandex-maps-api-for-wordpress/
 * Description: Insert <a href="http://tech.yandex.ru/maps">Yandex Maps with facilities API 2.1</a> into posts
 * Version: 1.3.1
 * Author: VasudevaServerRus
 * Author URI: http://xn--80aegccaes4apfcakpli6e.xn--p1ai/contact/
 */

/* Created by VasudevaServerRus
	Copyright (C) 2014 VasudevaServerRus

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
*/

if (strpos(strtolower($_SERVER['SCRIPT_NAME']),strtolower(basename(__FILE__)))){
   header('HTTP/1.0 403 Forbidden');
   exit('Forbidden');
}

class wpYandexMapAPI{
	private static $YaMapNumber = 0;  // map id for multiple maps per page
	private static $YaMapApiUrl;      // Full url to the Yandex Maps JavaScript

	public function __construct(){
           if (defined('YANDEX_LOAD_ON_SHORTCODE')){
              add_filter('widget_text', 'do_shortcode');
           }
	}
	public function YaMapRegisterScripts(){
	   if (!wp_script_is('yandexMaps', 'enqueued')){
	      $blog_lang = get_bloginfo('language','display');
	      if (isset($_REQUEST['yandex-map-lang'])) {
	         $blog_lang = trim($_REQUEST['yandex-map-lang']);
	      }else{
	         $blog_lang = 'ru_RU';
             if (defined('YANDEX_API_LANGUAGE')) {
                $blog_lang = YANDEX_API_LANGUAGE;
             }
	      }
	      switch ($blog_lang){
	      case 'ru_RU':
	      case 'en_US':
	      case 'en_RU':
	      case 'ru_UA':
	      case 'uk_UA':
	      case 'tr_TR':
	         break;
	      default;
	         $blog_lang = 'ru_RU';
	         break;
	      }
	      $this::$YaMapApiUrl = 'https://api-maps.yandex.ru/2.1/?load=package.full&lang='.$blog_lang;
          if (defined('YANDEX_MAPS_API_KEY')) {
	         $this::$YaMapApiUrl .= '&apikey=' . YANDEX_MAPS_API_KEY;
	      }
	      wp_register_script('yandexMaps', $this::$YaMapApiUrl, array(), false, true);
	      wp_enqueue_script('yandexMaps');
           }
	}
	public function vasu_var_export($pS){ 
	   //$this->vasu_var_export($v);
       $S = var_export($pS,TRUE);
       $S = urldecode($S);
       $S = "\n" . $S;
       error_log($S,3,dirname(__FILE__) . "/debug.log");
	}
	//check value
	public function getTrueValue($value){
		if (strtolower($value) == 'true'){
			$vl = 'true';
		}else{
			$vl = 'false';
		}
		return $vl;
	}
	// Replaces false words
	public function fixFalseWord($value){
           $value = str_replace('(lt)','<',$value);
           $value = str_replace('(gt)','>',$value);
           $value = str_replace('(quot)','"',$value);
           $value = str_replace('(equiv)','=',$value);
           $value = str_replace('(equiv)','=',$value);
           return $value;
	}
	// Replaces skobki
	public function fixSkobki($value){
           $value = str_replace('(','[',$value);
           $value = str_replace(')',']',$value);
           return $value;
	}
	//Main process
	public function handleShortcodes($attr, $content){
      $this::YaMapRegisterScripts();
      $cr = "\n";
      $this::$YaMapNumber++;
      if (isset($attr['width']) && ctype_digit($attr['width'])){
         $attr['width'] .= 'px';
      }
      if (isset($attr['height']) && ctype_digit($attr['height'])){
         $attr['height'] .= 'px';
      }
      $mapProp = (object)shortcode_atts(array(
           'description' => '',
                'center' => '55.755768,37.617671',
                  'type' => 'map',
           'zoomcontrol' => 'true',
          'typeselector' => 'true',
              'maptools' => 'true',
             'scaleline' => 'false',
                'search' => 'false',
           'routeeditor' => 'false',
           'geolocation' => 'false',
   'autolocation_yandex' => 'false',
     'autolocation_navi' => 'false',
         'location_send' => 'false',
      'location_treking' => 'false', //TO DO
         'setboundsauto' => 'false',
              'map_lang' => '',
            'fullscreen' => 'false',
               'traffic' => 'false',
            'showcoords' => 'false',
               'regions' => 'false',
           'zoom_inital' => '',
              'zoom_min' => '0',
              'zoom_max' => '17',
            'scrollzoom' => 'true',
                  'drag' => 'true',
          'dblclickzoom' => 'true',
            'multitouch' => 'true',
  'rightmousebmagnifier' => 'true',
   'leftmousebmagnifier' => 'true',
            'margin_map' => '10px',
           'margin_desc' => '7px',
                 'width' => '100%',
                'height' => '600px'), $attr);
      $YaMapDescription = "";
      $YaMapLabels = "";
      $YaMapRectangles = "";
      $YaMapChannels = "";
      $YaMapButtons = "";
      $YaMapGeo = "";
      $YaMapObj = "";
      $YaMapSetBounds = "";
      $YaMapRoute = "";
      $YaMapRegions = "";
      $l_OnClickCoord = array();
      if ($mapProp->description!=''){
         $objbody = $mapProp->description;
         $objbody = $this->fixFalseWord($objbody);
         $YaMapDescription = "<div id='yamap_f_{$this::$YaMapNumber}' style='width:{$mapProp->width}; margin:{$mapProp->margin_desc};' class='yamapapi_f'>$objbody</div>";
      }
      $l = str_replace('<br />','',$content);
      $l = str_replace('&#8221;',"'",$l);
      $l = str_replace('&#8243;',"'",$l);
      $l = str_replace('&#187;',"'",$l);
      $l = str_replace('&#8243;',"'",$l);
      $l = trim($l);
      $sp = explode('[',$l);
      $cnt_list=count($sp);
      for($v=0;$v<$cnt_list; $v++){
         $x = $sp[$v];
         $x = str_replace(']','',$x);
         if (substr($x,0,11)=='yamap_label'){
            $x = str_replace('yamap_label','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $labelInfo = (object)shortcode_atts(array(
                       'coord' => '55.755768,37.617671',
                   'draggable' => 'false',
                      'preset' => '', //islands#blueStretchyIcon
                      'action' => '',
                 'description' => '',
                         'url' => '',
                  'header_txt' => '',
                  'header_url' => '',
                  'footer_txt' => '',
                  'footer_url' => '',
                    'icon_txt' => '',
                    'icon_url' => '',
                'routeonclick' => '',
                   'iconcolor' => '#3b5998',
                        'icon' => '',
                    'iconsize' => '16,16',
                  'iconoffset' => '-8,-8'), $x_attr);
            $lb = '';
            if (strlen($labelInfo->coord)>0){
               if ($labelInfo->icon==''){
                  $labelInfo->icon = 'https://api-maps.yandex.ru/i/0.4/icons/house.png';
               }
               switch ($labelInfo->icon){
               case 'icon':
               case 'dotIcon':
               case 'circleIcon':
               case 'circleDotIcon':
                  $lb  = ' var l_Placemark = new ymaps.Placemark(['.$labelInfo->coord.'],{},{preset:"islands#' . $labelInfo->icon . '", iconColor:"' . $labelInfo->iconcolor . '", draggable:"' . $labelInfo->draggable . '"});' . $cr;
                  break;
               default;
                  $lb  = ' var l_Placemark = new ymaps.Placemark(['.$labelInfo->coord.'],{},{iconLayout:"default#image", draggable:"' . $labelInfo->draggable . '", iconImageHref:"'.$labelInfo->icon.'",iconImageSize:['.$labelInfo->iconsize.'],iconImageOffset:['.$labelInfo->iconoffset.']});' . $cr;
                  break;
               }
               if ($labelInfo->description != ''){
                  $objbody = $labelInfo->description;
                  $objbody = $this->fixFalseWord($objbody);
                  if ($labelInfo->url != ''){
                     $objbody = '<a href="'.$labelInfo->url.'">'.$objbody.'</a>';
                  }
                  $lb .= " var x = '$objbody'; " . $cr . 'l_Placemark.properties.set("balloonContent",x);' . $cr;
               }
               if ($labelInfo->footer_txt != ''){
                  $objbody = $labelInfo->footer_txt;
                  $objbody = $this->fixFalseWord($objbody);
                  if ($labelInfo->footer_url != ''){
                     $objbody = '<a href="'.$labelInfo->footer_url.'">'.$objbody.'</a>';
                  }
                  $lb .= " var x = '$objbody'; " . 'l_Placemark.properties.set("balloonContentFooter",x);' . $cr;
               }
               if ($labelInfo->header_txt != ''){
                  $objbody = $labelInfo->header_txt;
                  $objbody = $this->fixFalseWord($objbody);
                  if ($labelInfo->header_url != ''){
                     $objbody = '<a href="'.$labelInfo->header_url.'">'.$objbody.'</a>';
                  }
                  $lb .= " var x = '$objbody';" . $cr;
                  $lb .= ' l_Placemark.properties.set("balloonContentHeader",x);' . $cr;
                  $lb .= ' l_Placemark.properties.set("hintContent",x);' . $cr;
               }
               if ($labelInfo->icon_txt != ''){
                  $objbody = $labelInfo->icon_txt;
                  $objbody = $this->fixFalseWord($objbody);
                  if ($labelInfo->icon_url != ''){
                     $objbody = '<a href="'.$labelInfo->icon_url.'">'.$objbody.'</a>';
                  }
                  $lb .= " var x = '$objbody';" . $cr;
                  $lb .= ' l_Placemark.properties.set("iconContent",x);' . $cr;
               }
               if ($labelInfo->action == 'send_coords'){
                  $lb .= " l_Placemark.events.add('click', function(e){" . $cr;
                  $lb .= "   var eMap = e.get('target');" . $cr;
                  $lb .= "   var l = eMap.getMap();" . $cr;
                  $lb .= "   var l_Coordinates = l_Placemark.geometry.getCoordinates();" . $cr;
                  $lb .= " });" . $cr;
               }
               $lb .= ' l_collection.add(l_Placemark);' . $cr;
               if ($labelInfo->routeonclick == 'true'){
                  $l_OnClickCoord[] = '[' . $labelInfo->coord . ']';
               }
            }
            $YaMapLabels .= $lb;
         }elseif (substr($x,0,10)=='yamap_fill'){
            $x = str_replace('yamap_fill','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $rInfo = (object)shortcode_atts(array(
                      'area' => '',
               'description' => '',
                       'img' => '',
                   'opacity' => '0.7'), $x_attr);
            $l_area = $this->fixSkobki($rInfo->area);
            $lb   = ' var l_recTan = new ymaps.Rectangle(['.$l_area.'],{balloonContent:""},{fillImageHref:"'.$rInfo->img.'",fill:true,fillOpacity:'.$rInfo->opacity.', opacity:'.$rInfo->opacity.', fillMethod:"stretch", outline:false, interactivityModel:"default#transparent", strokeWidth:0});' . $cr;
            $lb  .= ' l_collection.add(l_recTan);' . $cr;
            $YaMapRectangles .= $lb;
         }elseif (substr($x,0,12)=='yamap_region'){
            $x = str_replace('yamap_region','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $rInfo = (object)shortcode_atts(array(
                   'country' => '',
               'region_list' => '',
                      'lang' => '',
               'bordercolor' => '',
               'fillopacity' => '',
                 'fillcolor' => ''), $x_attr);
         }elseif (substr($x,0,12)=='yamap_button'){
            $x = str_replace('yamap_button','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $rInfo = (object)shortcode_atts(array(
                    'hidden' => 'false',
                    'ballon' => '',
                    'action' => '',
                     'class' => 'yamap_button',
                  'ajax_url' => '',
               'description' => '',
       'routeeditorposition' => "right:'10px', top:'060px'",
                  'position' => "right:'10px', top:'100px'",
                       'img' => ''), $x_attr);
            $l_description = $this->fixSkobki($rInfo->description);
            $l_position = $this->fixSkobki($rInfo->position);
            $l_routeeditorposition = $this->fixSkobki($rInfo->routeeditorposition);
            $lb  = $cr;
            $lb .= " var l_LayoutBtCoord = ymaps.templateLayoutFactory.createClass('<div class=\"".$rInfo->class."\">{{data.content|raw}}</div>');" . $cr;
            $lb .= " var l_button = new ymaps.control.Button({data:{content:'".$l_description."'}, options: {layout:l_LayoutBtCoord, selectOnClick:false}});" . $cr;
            $lb .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_button,{float:'none', position: {".$l_position."}});" . $cr;
            if ($rInfo->action=='get_route'){
               $lb .= " var l_routeEditor = new ymaps.control.RouteEditor();" . $cr;
               $lb .= ' Glo_RouteEditor[' . $this::$YaMapNumber . '] = l_routeEditor' . ";". $cr;
               $lb .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_routeEditor,{float:'none', position: {".$l_routeeditorposition."}});" . $cr;
               $lb .= " l_button.events.add('click', function(e){" . $cr;
               $lb .= "   var l_route = Glo_RouteEditor[" . $this::$YaMapNumber . "].getRoute();" . $cr;
               $lb .= "   var l_points = l_route.getWayPoints();" . $cr;
               $lb .= "   l_points.each((p_point) => { console.log(p_point.geometry.getCoordinates()[0]); console.log(p_point.geometry.getCoordinates()[1]); })" . $cr;
               $lb .= "   var l_points = l_route.getViaPoints();" . $cr;
               $lb .= "   l_points.each((p_point) => { console.log(p_point.geometry.getCoordinates()[0]); console.log(p_point.geometry.getCoordinates()[1]); })" . $cr;
               $lb .= " });" . $cr;
            }
            if ($rInfo->action=='show_all'){
               $lb .= " l_button.events.add('click', function(e){" . $cr;
               $lb .= "    Glo_Maps['" . $this::$YaMapNumber . "'].setBounds(Glo_Maps['" . $this::$YaMapNumber . "'].geoObjects.getBounds());" . $cr;
               $lb .= " });" . $cr;
            }
            $lb .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_button,{float:'none', position: {".$l_position."}});" . $cr;
            $YaMapButtons .= $lb;
         }elseif (substr($x,0,12)=='vasu_channel'){
            $x = str_replace('vasu_channel','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $rInfo = (object)shortcode_atts(array(
                  'autoload' => 'false',
                    'hidden' => 'false',
                    'ballon' => '',
                  'ajax_url' => '',
                 'ajax_data' => '',
                     'class' => 'vasu_channel',
               'description' => '',
                  'position' => "right:'10px', bottom:'55px'",
                       'img' => ''), $x_attr);
            $l_description = $this->fixSkobki($rInfo->description);
            $l_position = $this->fixSkobki($rInfo->position);
            $l_ajax_data = $this->fixSkobki($rInfo->ajax_data);
            $l_url = admin_url('/admin-ajax.php');
            $l_nonce = wp_create_nonce('vasu_channel');
            $lb  = $cr;
            $lb .= " var l_LayoutBtCoord = ymaps.templateLayoutFactory.createClass('<div class=\"".$rInfo->class."\">{{data.content|raw}}</div>');" . $cr;
            $lb .= " var l_channel = new ymaps.control.Button({data:{content:'".$l_description."'}, options: {layout:l_LayoutBtCoord, selectOnClick:false}});" . $cr;
            $lb .= " l_channel.events.add('click', function(e){" . $cr;
            if (strlen($l_ajax_data) > 0){
               $l_ajax_data = ' ,'.$l_ajax_data;
            }
            $lb .= "       Glo_Maps['" . $this::$YaMapNumber . "'].geoObjects.removeAll();" . $cr;
            $lb .= "       jQuery.ajax({type:'post', url: '".$l_url."', dataType: 'json', data: {action:'vasu_channel', _ajax_nonce:'".$l_nonce."'".$l_ajax_data."}," . $cr;
            $lb .= "       complete: function() {console.log('Channel complete.');}," . $cr;
            $lb .= "       success: function (data) {console.log('Channel ajax success.'); console.log(data);" . $cr;
            $lb .= "                    var l_geoObjects = [];" . $cr;
            $lb .= "                    data.map(function (object) {" . $cr;
            $lb .= "                       var l_placemark = new ymaps.Placemark([object.latitude, object.longitude], {" . $cr;
            $lb .= "                                balloonContent: object.label," . $cr;
            $lb .= "                                hintContent: object.label," . $cr;
            $lb .= "                                iconContent: object.id" . $cr;
            $lb .= "                            }, {" . $cr;
            $lb .= "                                iconLayout:'default#imageWithContent', iconImageHref: object.iconImage, iconImageSize: [24, 24], iconImageOffset: [-12, -12], iconContentOffset: [15, 15]," . $cr;
            $lb .= "                                hideIconOnBalloonOpen: false," . $cr;
            $lb .= "                                balloonOffset: [0, -33]" . $cr;
            $lb .= "                            });" . $cr;
            $lb .= "                       l_geoObjects.push(l_placemark);" . $cr;
            $lb .= "                    });" . $cr;
            $lb .= "                var l_clusterer = new ymaps.Clusterer({clusterHideIconOnBalloonOpen: false, geoObjectHideIconOnBalloonOpen: false, hasBalloon: false, minClusterSize: 4, maxZoom: 16, groupByCoordinates: true, gridSize: 128, clusterIcons: [{href: '/images/0-tower.ico', size: [44, 44], offset: [-20, -20] }]});" . $cr;
            $lb .= "                l_clusterer.add(l_geoObjects);" . $cr;
            $lb .= "                Glo_Maps['" . $this::$YaMapNumber . "'].geoObjects.add(l_clusterer);" . $cr;
            $lb .= "                Glo_Maps['" . $this::$YaMapNumber . "'].setBounds(l_clusterer.getBounds());" . $cr;
            $lb .= "       }" . $cr;
            $lb .= "      });" . $cr;
            $lb .= " });" . $cr;
            $lb .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_channel,{float:'none', position: {".$l_position."}});" . $cr;
            if ($rInfo->autoload == 'true'){
               $lb .= " l_channel.events.fire('click');" . $cr;
            }
            $YaMapChannels .= $lb;
		 }elseif (substr($x,0,9)=='yamap_geo'){
            $x = str_replace('yamap_geo','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $lb = ' ymaps.geoXml.load("'. $x_attr['url'] . '").then(function(res){l_YaMap' . $this::$YaMapNumber .'.geoObjects.add(res.geoObjects);});' . $cr;
            $YaMapGeo .= $lb;
         }elseif (substr($x,0,11)=='yamap_obect'){
            $x = str_replace('yamap_obect','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $labelInfo = (object)shortcode_atts(array(
                        'type' => 'point',
                       'coord' => '55.755768,37.617671',
                   'draggable' => 'false',
                      'radius' => '',
                       'width' => '2',
                       'color' => '',
               'color_opacity' => '0.7',
                        'fill' => '',
                'fill_opacity' => '0.7',
               'border_radius' => '0',
                 'description' => '',
                         'url' => '',
                  'header_txt' => '',
                  'header_url' => '',
                  'footer_txt' => '',
                  'footer_url' => '',
                        'icon' => '',
                    'iconsize' => '16,16',
                  'iconoffset' => '-8,-8'), $x_attr);
            $m_type = 'Point';
            $l_type = strtolower($labelInfo->type);
            if ($l_type=='point'){
               $m_type = 'Point';
            }elseif ($l_type=='line'){
               $m_type = 'LineString';
            }elseif ($l_type=='circle'){
               $m_type = 'Circle';
            }elseif ($l_type=='polygon'){
               $m_type = 'Polygon';
            }elseif ($l_type=='rectangle'){
               $m_type = 'Rectangle';
            }
            $x = $this->fixSkobki($labelInfo->coord);
            if ($labelInfo->radius==''){
               $x = '['.$x.']';
            }
            $lb  = ' var l_GeoObject = new ymaps.GeoObject(';
            $lb .= '{geometry:{type:"' . $m_type .'",coordinates:'.$x.'}';
            $lb .= ',properties:{}}';
            $lb .= ',{geodesic:true, draggable:'.$labelInfo->draggable.'});' . $cr;
            if ($labelInfo->description!=''){
               $lb .= ' l_GeoObject.properties.set("balloonContent","' . $labelInfo->description .'");' . $cr;
               $lb .= ' l_GeoObject.properties.set("hintContent","' . $labelInfo->description .'");' . $cr;
            }
            $lb .= ' l_GeoObject.options.set("strokeWidth","' . $labelInfo->width .'");' . $cr;
            if ($labelInfo->color!=''){
               $lb .= ' l_GeoObject.options.set("strokeColor","' . $labelInfo->color .'");' . $cr;
               $lb .= ' l_GeoObject.options.set("strokeOpacity","' . $labelInfo->color_opacity .'");' . $cr;
            }
            if ($labelInfo->fill!=''){
               $lb .= ' l_GeoObject.options.set("fillColor","' . $labelInfo->fill .'");' . $cr;
               $lb .= ' l_GeoObject.options.set("fillOpacity","' . $labelInfo->fill_opacity .'");' . $cr;
            }
            if ($labelInfo->border_radius!=''){
               $lb .= ' l_GeoObject.options.set("borderRadius","' . $labelInfo->border_radius .'");' . $cr;
            }
            if ($labelInfo->radius!=''){
               $lb .= ' l_GeoObject.geometry.setRadius('.$labelInfo->radius.');' . $cr;
            }
            $lb .= ' l_collection.add(l_GeoObject);' . $cr;
            $YaMapObj .= $lb;
         }elseif (substr($x,0,11)=='yamap_route'){
            $x = str_replace('yamap_route','',$x);
            $x = trim($x);
            $x_attr = shortcode_parse_atts($x);
            $labelInfo = (object)shortcode_atts(array(
                       'start' => '(55.755768,37.617671)',
                        'stop' => '(55.752283,37.58351)',
                       'visit' => '',
                       'color' => '#885522',
                     'opacity' => '1',
                     'traffic' => 'false',
                        'icon' => '',
                    'iconsize' => '16,16',
                  'iconoffset' => '-8,-8'), $x_attr);
            $x_start = $this->fixSkobki($labelInfo->start);
            $x_stop = $this->fixSkobki($labelInfo->stop);
            $x_visit = '';
            if ($labelInfo->visit!=''){
               $x_visit = $this->fixSkobki($labelInfo->visit);
            }
            $lb  = ' ymaps.route([';
            $lb .= ' {type:"wayPoint", point:'.$x_start.'}';
            if ($x_visit!=''){
               $lb .= ",$x_visit";
            }
            if ($labelInfo->color=='') {
               switch ($v){
               case 1:
                  $labelInfo->color = '#885522';
                  break;
               case 2:
                  $labelInfo->color = '#004477';
                  break;
               case 3:
                  $labelInfo->color = '#003300';
                  break;
               case 4:
                  $labelInfo->color = '#3366AA';
                  break;
               case 5:
                  $labelInfo->color = '#4477BB';
                  break;
               default;
                  $labelInfo->color = '#5588CC';
               }
            }
            $lb .= ',{type:"wayPoint", point:'.$x_stop.'}';
            $lb .= '],{mapStateAutoApply:false, avoidTrafficJams:'.$this->getTrueValue($labelInfo->traffic).'}).then(function(route){';
            $lb .= ' route.options.set({strokeColor: "' . $labelInfo->color . '"});' . $cr;
            $lb .= ' route.options.set({opacity: "' . $labelInfo->color . '"});' . $cr;
            $lb .= ' var points = route.getWayPoints();' . $cr;
            $lb .= ' points.options.set("fill", false);' . $cr;
            $lb .= ' points.options.set("visible", false);' . $cr;
            if ($labelInfo->icon!=''){
               $lb .= ' points.options.set("iconLayout", "default#image");' . $cr;
               $lb .= ' points.options.set("iconImageHref", "'.$labelInfo->icon.'");' . $cr;
            }
            $lb .= ' l_YaMap' . $this::$YaMapNumber . '.geoObjects.add(route);' . $cr;
            $lb .= '});' . $cr;
            $YaMapRoute .= $lb;
         }
      }
      $YaMapBuilder = "";
      $m_center = "center: [$mapProp->center],";
      $m_type = 'yandex#map';
      $l_type = strtolower($mapProp->type);
      if ($l_type=='map'){
         $m_type = 'yandex#map';
      }elseif ($l_type=='satellite'){
         $m_type = 'yandex#satellite';
      }elseif ($l_type=='hybrid'){
         $m_type = 'yandex#hybrid';
      }elseif ($l_type=='public'){
         $m_type = 'yandex#publicMap';
      }elseif ($l_type=='publichybrid'){
         $m_type = 'yandex#publicMapHybrid';
      }
      if ($mapProp->zoom_inital==''){
         $l_zoom = '10';
         $YaMapSetBounds = "if (l_collection.getLength()>0){l_YaMap{$this::$YaMapNumber}.setBounds(l_collection.getBounds());}";
      }else{
         $l_zoom = $mapProp->zoom_inital;
      }
      $YaMapBuilder .= ' var YMapId = document.getElementById("yamap_div_' . $this::$YaMapNumber . '");' . $cr;
      $YaMapBuilder .= ' var l_YMapId = YMapId.id;' . $cr;
      $YaMapBuilder .= ' var l_YaMap' . $this::$YaMapNumber . ' = new ymaps.Map(l_YMapId,{' . $m_center . " type:'$m_type', zoom:$l_zoom, controls:[]},{maxZoom:$mapProp->zoom_max, minZoom:$mapProp->zoom_min});" . $cr;
      $YaMapBuilder .= ' Glo_Maps[' . $this::$YaMapNumber . '] = l_YaMap' . $this::$YaMapNumber . ";". $cr;
      $YaMapControls = "";
      if ($this->getTrueValue($mapProp->autolocation_yandex)=='true'){
         $YaMapControls .= "ymaps.geolocation.get({mapStateAutoApply:true, autoReverseGeocode:false, provider:'auto'}).then(function(resGeo){" . $cr;
         if ($this->getTrueValue($mapProp->location_send)=='true'){
            $l_nonce = wp_create_nonce('vasu_vasuyamapcoord');
            $l_admin_url = admin_url('/admin-ajax.php');
            $YaMapControls .= "var l_latitude = resGeo.geoObjects.get(0).geometry.getCoordinates()[0];" . $cr;
            $YaMapControls .= "var l_longitude = resGeo.geoObjects.get(0).geometry.getCoordinates()[1];" . $cr;
            $YaMapControls .= "var l_ajaxurl = '".$l_admin_url."';" . $cr;
            $YaMapControls .= "var data = {action:'vasu_vasuyamapcoord', id:1234};" . $cr;
            $YaMapControls .= "jQuery.ajax({type: 'post', url: l_ajaxurl, data: {action: 'vasu_vasuyamapcoord', type: 'Yandex', latitude: l_latitude, longitude: l_longitude, _ajax_nonce: '" . $l_nonce . "'}," . $cr;
            $YaMapControls .= "         complete: function(){jQuery('.vasu_vasuyamapcoord').show('slow');}," . $cr;
            $YaMapControls .= "         success: function(html){" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').html(html);" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').show(0);" . $cr;
            $YaMapControls .= '            l_YaMap' . $this::$YaMapNumber . '.setBounds('. ' l_YaMap' . $this::$YaMapNumber .'.geoObjects.getBounds());' . $cr;
            $YaMapControls .= "         }" . $cr;
            $YaMapControls .= "});" . $cr;
         }
         $YaMapControls .= ' l_YaMap' . $this::$YaMapNumber . ".geoObjects.add(resGeo.geoObjects);}, function(e){alert('Местоположение не доступно');});" . $cr;
      }
      if ($this->getTrueValue($mapProp->autolocation_navi)=='true'){
         $YaMapControls .= " navigator.geolocation.getCurrentPosition(function (position) {" . $cr;
         $YaMapControls .= " var l_latitude = position.coords.latitude;" . $cr;
         $YaMapControls .= " var l_longitude = position.coords.longitude;" . $cr;
         if ($this->getTrueValue($mapProp->location_send)=='true'){
            $l_nonce = wp_create_nonce('vasu_vasuyamapcoord');
            $l_admin_url = admin_url('/admin-ajax.php');
            $YaMapControls .= "var l_ajaxurl = '".$l_admin_url."';" . $cr;
            $YaMapControls .= "var data = {action:'vasu_vasuyamapcoord', id:1234};" . $cr;
            $YaMapControls .= "jQuery.ajax({type: 'post', url: l_ajaxurl, data: {action: 'vasu_vasuyamapcoord', type: 'Navigator', latitude: l_latitude, longitude: l_longitude, _ajax_nonce: '" . $l_nonce . "'}," . $cr;
            $YaMapControls .= "         complete: function(){jQuery('.vasu_vasuyamapcoord').show('slow');}," . $cr;
            $YaMapControls .= "         success: function(html){" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').html(html);" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').show(0);" . $cr;
            $YaMapControls .= '            l_YaMap' . $this::$YaMapNumber . '.setBounds('. ' l_YaMap' . $this::$YaMapNumber .'.geoObjects.getBounds());' . $cr;
            $YaMapControls .= "         }" . $cr;
            $YaMapControls .= "});" . $cr;
         }
         $YaMapControls .= "    var l_place = new ymaps.Placemark([l_latitude, l_longitude],{iconContent: 'Я'},{preset: 'twirl#redStretchyIcon'});";
         $YaMapControls .= "    l_YaMap" . $this::$YaMapNumber . ".geoObjects.add(l_place);";
         $YaMapControls .= " });" . $cr;
      }
      if ($this->getTrueValue($mapProp->scrollzoom)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('scrollZoom');" . $cr;
      }
      if ($this->getTrueValue($mapProp->drag)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('drag');" . $cr;
      }
      if ($this->getTrueValue($mapProp->dblclickzoom)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('dblClickZoom');" . $cr;
      }
      if ($this->getTrueValue($mapProp->multitouch)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('multiTouch');" . $cr;
      }
      if ($this->getTrueValue($mapProp->rightmousebmagnifier)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('rightMouseButtonMagnifier');" . $cr;
      }
      if ($this->getTrueValue($mapProp->leftmousebmagnifier)=='false'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".behaviors.disable('leftMouseButtonMagnifier');" . $cr;
      }
      if ($this->getTrueValue($mapProp->zoomcontrol)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('zoomControl', {left:'10px'});" . $cr;
      }
      if ($this->getTrueValue($mapProp->typeselector)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('typeSelector', {});" . $cr;
      }
      if ($this->getTrueValue($mapProp->scaleline)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('rulerControl');" . $cr;
      }
      if ($this->getTrueValue($mapProp->search)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('searchControl');" . $cr;
      }
      if ($this->getTrueValue($mapProp->routeeditor)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('routeEditor');" . $cr;
      }
      if ($this->getTrueValue($mapProp->regions)=='true'){
         $YaMapRegions .= "ymaps.borders.load('RU', {" . $cr;
         $YaMapRegions .= "  lang: 'ru'," . $cr;
         $YaMapRegions .= "  quality: 2" . $cr;
         $YaMapRegions .= "}).then(function (geojson) {" . $cr;
         $YaMapRegions .= "  for (var i = 0; i < geojson.features.length; i++) {" . $cr;
         $YaMapRegions .= "    var geoObject = new ymaps.GeoObject(geojson.features[i]);" . $cr;
         $YaMapRegions .= "    var l_iso3166 =  geoObject.properties.get('iso3166');" . $cr;
         $YaMapRegions .= "    if (l_iso3166 == 'RU-MOS' || l_iso3166 == 'RU-MOW'){" . $cr;
         $YaMapRegions .= "       geoObject.options.set('fill', false);" . $cr;
         $YaMapRegions .= "       geoObject.options.set('draggable', false);" . $cr;
         $YaMapRegions .= "       Glo_Maps['" . $this::$YaMapNumber . "'].geoObjects.add(geoObject);" . $cr;
         $YaMapRegions .= "    }" . $cr;
         $YaMapRegions .= "  }" . $cr;
         $YaMapRegions .= "});" . $cr;
      }
      if ($this->getTrueValue($mapProp->geolocation)=='true'){
         $YaMapControls .= " var l_geolocationControl = new ymaps.control.GeolocationControl({options: {noPlacemark: true}});" . $cr;
         $YaMapControls .= " l_geolocationControl.events.add('locationchange', function (p_rez) {" . $cr;
         $YaMapControls .= " var l_position = p_rez.get('position');" . $cr;
         $YaMapControls .= " l_Placemark = new ymaps.Placemark(l_position);" . $cr;
         $YaMapControls .= " var l_Placemark = new ymaps.Placemark(l_position);" . $cr;
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".geoObjects.add(l_Placemark);" . $cr;
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".panTo(l_position);" . $cr;
         if ($this->getTrueValue($mapProp->location_send)=='true'){
            $l_nonce = wp_create_nonce('vasu_vasuyamapcoord');
            $l_admin_url = admin_url('/admin-ajax.php');
            $YaMapControls .= "var l_latitude = l_position[0];" . $cr;
            $YaMapControls .= "var l_longitude = l_position[1];" . $cr;
            $YaMapControls .= "var l_ajaxurl = '".$l_admin_url."';" . $cr;
            $YaMapControls .= "var data = {action:'vasu_vasuyamapcoord', id:1234};" . $cr;
            $YaMapControls .= "jQuery.ajax({type: 'post', url: l_ajaxurl, data: {action: 'vasu_vasuyamapcoord', type: 'YandexGeolocationControl', latitude: l_latitude, longitude: l_longitude, _ajax_nonce: '" . $l_nonce . "'}," . $cr;
            $YaMapControls .= "         complete: function(){jQuery('.vasu_vasuyamapcoord').show('slow');}," . $cr;
            $YaMapControls .= "         success: function(html){" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').html(html);" . $cr;
            $YaMapControls .= "            jQuery('.vasu_vasuyamapcoord').show(0);" . $cr;
            $YaMapControls .= '            l_YaMap' . $this::$YaMapNumber . '.setBounds('. ' l_YaMap' . $this::$YaMapNumber .'.geoObjects.getBounds());' . $cr;
            $YaMapControls .= "         }" . $cr;
            $YaMapControls .= "    });" . $cr;
         }
         $YaMapControls .= " });" . $cr;
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_geolocationControl);" . $cr;
      }
      if ($this->getTrueValue($mapProp->fullscreen)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add('fullscreenControl');" . $cr;
      }
      if ($this->getTrueValue($mapProp->traffic)=='true'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(new ymaps.control.TrafficControl({state: {providerKey:'traffic#actual',trafficShown:false}}));" . $cr;
      }
      if ($mapProp->traffic=='open'){
         $YaMapControls .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(new ymaps.control.TrafficControl({state: {providerKey:'traffic#actual',trafficShown:true}}));" . $cr;
      }
      if ($mapProp->setboundsauto=='true'){
         $YaMapSetBounds = ' l_YaMap' . $this::$YaMapNumber . '.setBounds('. ' l_YaMap' . $this::$YaMapNumber .'.geoObjects.getBounds());' . $cr;
      }
      $YaMapCoords = '';
      if ($mapProp->showcoords=='true' or count($l_OnClickCoord)>0){
         if ($mapProp->showcoords=='true'){
            $YaMapCoords .= " var l_LayoutBtCoord = ymaps.templateLayoutFactory.createClass('<div>{{data.content|raw}}</div>');" . $cr;
            $YaMapCoords .= " var l_BtCoord = new ymaps.control.Button({data:{content:''}, options: {layout:l_LayoutBtCoord, selectOnClick:false}});" . $cr;
            $YaMapCoords .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_BtCoord,{float:'none', position: {right:'10px', bottom:'55px'}});" . $cr;
         };
         if (count($l_OnClickCoord)>0){
            $YaMapCoords .= " var l_LayoutBtRoute = ymaps.templateLayoutFactory.createClass('<div>{{data.content|raw}}</div>');" . $cr;
            $YaMapCoords .= " var l_BtRoute = new ymaps.control.Button({data:{content:''},options: {layout:l_LayoutBtRoute, selectOnClick:false}});" . $cr;
            $YaMapCoords .= " l_YaMap" . $this::$YaMapNumber . ".controls.add(l_BtRoute,{float:'none', position: {left:'40px', bottom:'40px'}});" . $cr;
         };
         $YaMapCoords .= " l_YaMap" . $this::$YaMapNumber . ".events.add('click', function(e){" . $cr;
         $YaMapCoords .= "    var l_coords = e.get('coords');" . $cr;
         if ($mapProp->showcoords=='true'){
            $YaMapCoords .= "    var x = l_coords[0].toPrecision(8) + ',' + l_coords[1].toPrecision(8)" . $cr;
            $YaMapCoords .= "    l_BtCoord.data.set('content',x);" . $cr;
         }
         if (count($l_OnClickCoord)>0){
            $YaMapCoords .= " var l_restart = true;" . $cr;
            $YaMapCoords .= " while (l_restart==true){" . $cr;
            $YaMapCoords .= "    l_restart = false;" . $cr;
            $YaMapCoords .= "    l_YaMap" . $this::$YaMapNumber . ".geoObjects.each(function(p_geoObject){" . $cr;
            $YaMapCoords .= "       if (typeof p_geoObject.routeOptions!='undefined'){" . $cr;
            $YaMapCoords .= "          l_YaMap" . $this::$YaMapNumber . ".geoObjects.remove(p_geoObject);" . $cr;
            $YaMapCoords .= "         l_restart = true;" . $cr;
            $YaMapCoords .= "       }" . $cr;
            $YaMapCoords .= "       var l_prop = p_geoObject.properties.get('clickPlacemark');" . $cr;
            $YaMapCoords .= "       if (l_prop=='yes'){" . $cr;
            $YaMapCoords .= "          l_YaMap" . $this::$YaMapNumber . ".geoObjects.remove(p_geoObject);" . $cr;
            $YaMapCoords .= "          l_restart = true;" . $cr;
            $YaMapCoords .= "       }" . $cr;
            $YaMapCoords .= "    });" . $cr;
            $YaMapCoords .= " };" . $cr;
            $YaMapCoords .= " var clickPlacemark = new ymaps.Placemark(l_coords, {}, {preset: 'islands#redDotIcon'});" . $cr;
            $YaMapCoords .= " clickPlacemark.properties.set('clickPlacemark','yes');" . $cr;
            $YaMapCoords .= " l_YaMap" . $this::$YaMapNumber . ".geoObjects.add(clickPlacemark);" . $cr;
            $YaMapCoords .= " clickPlacemark.geometry.setCoordinates(l_coords);" . $cr;
            $YaMapCoords .= " clickPlacemark.properties.set('balloonContent','');" . $cr;
            $YaMapCoords .= " clickPlacemark.properties.set('hintContent','');" . $cr;
            $YaMapCoords .= " ymaps.geocode(l_coords).then(function(res){" . $cr;
            $YaMapCoords .= "    var firstGeoObject = res.geoObjects.get(0);" . $cr;
            $YaMapCoords .= "    clickPlacemark.properties.set('balloonContent',firstGeoObject.properties.get('text'));" . $cr;
            $YaMapCoords .= "    clickPlacemark.properties.set('hintContent',firstGeoObject.properties.get('name'));" . $cr;
            $YaMapCoords .= " });" . $cr;
            $l_color = 0;
            $YaMapCoords .= "    l_BtRoute.data.set('content','');" . $cr;
            foreach($l_OnClickCoord as $l_route){
               $l_color = $l_color + 1;
               $YaMapCoords .= " ymaps.route([{type:'wayPoint', point:clickPlacemark.geometry.getCoordinates()},";
               $YaMapCoords .= "              {type:'wayPoint', point:". $l_route ."}],";
               $YaMapCoords .= "              {mapStateAutoApply:false, avoidTrafficJams:true}).then(function(p_route){" . $cr;
               $YaMapCoords .= "       var points = p_route.getWayPoints();" . $cr;
               $YaMapCoords .= "       points.options.set('visible', false);" . $cr;
               switch ($l_color){
               case 1:
                  $l_strokeColor = '0000FF';
                  break;
               case 2:
                  $l_strokeColor = '00FF00';
                  break;
               case 3:
                  $l_strokeColor = 'FF0000';
                  break;
               default;
                  $l_strokeColor = 'FFFF00';
               }
               $l_span_color = '<span style="color:#'.$l_strokeColor.'";>';
               $YaMapCoords .= "        p_route.getPaths().options.set({strokeColor:'#" . $l_strokeColor . "', opacity: 0.5});" . $cr;
               $YaMapCoords .= "        l_YaMap" . $this::$YaMapNumber . ".geoObjects.add(p_route);" . $cr;
               $YaMapCoords .= "        var km = p_route.getHumanLength();" . $cr;
               $YaMapCoords .= "        var tm = p_route.getHumanTime();" . $cr;
               $YaMapCoords .= "    var x = l_BtRoute.data.get('content') + '<br>".$l_span_color."'+ km + '; ' + tm + '</span>';" . $cr;
               $YaMapCoords .= "    l_BtRoute.data.set('content',x);" . $cr;
               $YaMapCoords .= "    },this);";
            }
         }
         $YaMapCoords .= "   },this);";
      }
      $Z = <<<YaMapScript
<div id='yamap_div_{$this::$YaMapNumber}' style='width:{$mapProp->width}; height:{$mapProp->height}; margin:{$mapProp->margin_map};' class='yamapapi'></div>
{$YaMapDescription}
YaMapScript;
      $Y = <<<YaMapScript
var Glo_Maps = [];
var Glo_RouteEditor = [];
ymaps.ready(VasuMap_{$this::$YaMapNumber});
function VasuMap_{$this::$YaMapNumber}(){
   {$YaMapBuilder}
   {$YaMapRegions}
   {$YaMapControls}
   var l_collection = new ymaps.GeoObjectCollection();
   {$YaMapRectangles}
   {$YaMapChannels}
   {$YaMapButtons}
   {$YaMapLabels}
   {$YaMapObj}
   if (l_collection.getLength()>0){
      l_YaMap{$this::$YaMapNumber}.geoObjects.add(l_collection);
   }
   {$YaMapGeo}
   {$YaMapSetBounds}
   {$YaMapRoute}
   {$YaMapCoords}
};
YaMapScript;
      wp_add_inline_script('yandexMaps', $Y, 'after');
      remove_filter('the_content','wptexturize');
      add_filter('the_content',   'do_shortcode');
      add_filter('widget_text',   'do_shortcode');
      return $Z;
   }
}
$wpYandexMapAPI = new wpYandexMapAPI();
add_shortcode('yandexMap',  array($wpYandexMapAPI,  'handleShortcodes'));

function vasu_get_ajax_vasuyamapcoord() {
   global $wpdb;

   if (isset($_REQUEST['action']) && isset($_REQUEST['latitude']) && isset($_REQUEST['longitude'])){
      if ($_REQUEST['action'] == 'vasu_vasuyamapcoord'){
         $l_latitude = esc_sql($_REQUEST['latitude']);
         $l_longitude = esc_sql($_REQUEST['longitude']);
         $l_id = 0;
         //Проверить, что кукисы есть и что они мои
         if (isset($_COOKIE['id'])){
            if (isset($_COOKIE['md'])){
               $l_id = (int)$_COOKIE['id'];
               if ($_COOKIE['md'] == md5('vs' . $l_id . 'vs')){
                  //Ok! кукисы мои!
                  //Если такой ID еще есть в БД, то обновить, иначе создать новый
                  $l_sql = 'select id from evk_coords where id='.$l_id;
                  $l_id_db = $wpdb->get_var($l_sql);
                  if ($l_id == $l_id_db) {
                     $l_sql = 'update evk_coords set latitude='.$l_latitude.', longitude='.$l_longitude.', rstatus="1" ,dt=curdate(), tm=curtime(), rtm=CURRENT_TIMESTAMP where id='. $l_id;
                     $wpdb->query($l_sql);
                     echo 'Ваш заказ № '.$l_id.'. Мы видим, где вы находитесь. ' . $l_latitude . ',' . $l_longitude;
                     die();
                  }
               }else{
                  echo 'Attack?!';
                  die(); //Attack! кукисы НЕ мои или старые, если менялся алгоритм
               }
            }else{
               $l_id = 0; //die(); //Attack! Id есть, но MD нет! кукисы НЕ мои
            }
         }
         if ($l_id == 0){
            //Определить ID этого места
            $l_sql = 'select max(id) from evk_coords where latitude='.$l_latitude.' and longitude='.$l_longitude.' and dt=curdate()';
            $l_id = $wpdb->get_var($l_sql);
         }
         if ((int)$l_id == 0){
            //создать новое место
            $l_sql = 'insert into evk_coords(latitude,longitude,dt,tm,rstatus) values('.$l_latitude.','.$l_longitude.',curdate(),curtime(),"1");';
            $wpdb->query($l_sql);
            $l_id = $wpdb->insert_id;
         }else{
            //Обновить время для этого места
            $l_sql = 'update evk_coords set rstatus="1" ,dt=curdate(), tm=curtime(), rtm=CURRENT_TIMESTAMP where id='. $l_id;
            $wpdb->query($l_sql);
         }
         $l_md5_id = md5('vs' . $l_id . 'vs');
         setcookie("id", $l_id, time()+3600*24*100, '/');
         setcookie("md", $l_md5_id, time()+3600*24*100, '/');
         echo 'Ваш заказ № '.$l_id.'. Мы видим, где вы находитесь! ' . $l_latitude . ',' . $l_longitude;
         die();
      }
   }
   echo 'No';
   die();
}
add_action('wp_ajax_nopriv_vasu_vasuyamapcoord','vasu_get_ajax_vasuyamapcoord');
add_action('wp_ajax_vasu_vasuyamapcoord','vasu_get_ajax_vasuyamapcoord');

function vasu_get_ajax_vasu_channel() {
   global $wpdb;
//$l_file  = '';
//$l_file .= '[';
//$l_file .= '{"id":1058,';
//$l_file .= '"desc":"##1",';
//$l_file .= '"address":"xxx",';
//$l_file .= '"icon":"fa-shopping-basket",';
//$l_file .= '"color":"#F9AB15",';
//$l_file .= '"balloon":"orange",';
//$l_file .= '"label":"#1"';
//$l_file .= '}';
//$l_file .= ']';
   if (isset($_REQUEST['action']) && isset($_REQUEST['type'])){
      $l_sql = 'update evk_coords set iconimage=""';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set iconimage="ball.png" where iconimage="" and rtm > (now() - interval 1 hour)';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set iconimage="2-tower.ico" where iconimage="" and rtm > (now() - interval 3 hour)';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set iconimage="3-tower.ico" where iconimage="" and rtm > (now() - interval 24 hour)';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set iconimage="4-tower.ico" where iconimage="" and rtm > (now() - interval 72 hour)';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set  rstatus="2" where iconimage=""';
      $wpdb->query($l_sql);
      $l_sql = 'update evk_coords set  rstatus="2" where iconimage=""';
      $wpdb->query($l_sql);
      $l_icondir = 'https://xn----7sbabahd5de0bfsgthgi1oj.xn--p1ai/images/';
      $l_sql = 'select concat_ws("","'.$l_icondir.'",iconImage) as iconImage, id, latitude, longitude, CONCAT_WS("", "ID=", id, "<br>", tm, "; ", dt, "<br>" , latitude, "," , longitude) as label from evk_coords where ';
      if ($_REQUEST['type'] == '01' && $_REQUEST['action'] == 'vasu_channel'){
         $l_sql .= 'rtm > (now() - interval 1 hour) and rstatus="1"';
      }
      if ($_REQUEST['type'] == '03' && $_REQUEST['action'] == 'vasu_channel'){
         $l_sql .= 'rtm > (now() - interval 3 hour) and rstatus="1"';
      }
      if ($_REQUEST['type'] == '24' && $_REQUEST['action'] == 'vasu_channel'){
         $l_sql .= 'rtm > (now() - interval 24 hour) and rstatus="1"';
      }
      if ($_REQUEST['type'] == '72' && $_REQUEST['action'] == 'vasu_channel'){
         $l_sql .= 'rtm > (now() - interval 72 hour) and rstatus="1"';
      }
      if ($_REQUEST['type'] == 'do_action' && $_REQUEST['action'] == 'vasu_channel'){
         //Вывести на карту населенные пункты
         if ($_REQUEST['action_name'] == 'vasu_show_glo_regions_on_map') {
            do_action('vasu_show_glo_regions_on_map');
         }
         die();
      }
      $rez = $wpdb->get_results($l_sql);
      if ($rez){
         $rez = json_encode($rez);
      }else{
         $rez = null;
      }
      echo $rez;
   }
   die();
}
add_action('wp_ajax_nopriv_vasu_channel','vasu_get_ajax_vasu_channel');
add_action('wp_ajax_vasu_channel','vasu_get_ajax_vasu_channel');

function vasu_yandex_maps_RegisterScript(){
   Global $wpYandexMapAPI;

   if (defined('YANDEX_LOAD_ON_ALL_PAGES')){
      $wpYandexMapAPI->YaMapRegisterScripts();
   }
}
add_action('wp_enqueue_scripts', 'vasu_yandex_maps_RegisterScript');
                   