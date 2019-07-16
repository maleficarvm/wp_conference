=== Yandex Maps API ===
Contributors: VasudevaServerRus
Donate link: http://xn--80aegccaes4apfcakpli6e.xn--p1ai/yandex-maps-api-for-wordpress/
Tags: maps, yandex, shortcodes
Requires at least: 2.5.1
Tested up to: 5.2.1
Stable tag: 5.2.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Yandex Maps for WordPress

== Description ==

This plugin allows to insert Yandex Maps into WordPress blog, making use of the Shortcode.

Features:

1. Yandex Maps API 2.1 facilities
2. Multiple Yandex Maps on one page
3. Multiple place marks on one map
4. Multiple fill images on one map
5. Multiple graphical figures on one map: points, lines, circles, polygons and rectangles
6. Multiple YMapsML, KML, GPX files on one map
7. Multiple route on one map
8. Show coordinates of specific location by click
9. Make route from clicked point on map to the place marks
10. Behaviors settings
11. Defined YANDEX_LOAD_ON_ALL_PAGES

== Installation ==

1. Upload the whole `yandex-maps-api` directory to the `/wp-content/plugins/` directory.
2. Activate the plugin.
3. Insert the shortCode into post. Full documentation on http://xn--80aegccaes4apfcakpli6e.xn--p1ai/yandex-maps-api-for-wordpress/

== Frequently Asked Questions ==

= Where can I get a Yandex Maps API Key? =

No need API Key. You can use Yandex Maps API Key by define YANDEX_MAPS_API_KEY

= Where can I get latitude and longitude of place? =

Use next example and click on the map.
[yandexMap center="55.8180555,37.6138888" showcoords="true"][/yandexMap]

= Full documentation and examples on plugin URI =

http://xn--80aegccaes4apfcakpli6e.xn--p1ai/yandex-maps-api-for-wordpress/

== Screenshots ==

1. Only place mark
2. Multiple places marks
3. Fill image
4. Insert html
5. Load kml file
6. Graphical figures: point, line, circle, polygon and rectangle
7. Make route from clicked point to the place marks

== Changelog ==

= 1.3.1 =
*YANDEX_LOAD_ON_ALL_PAGES can use
*Send location to host
*Load objects from host by ajax
*New properties for objects

= 1.2.2 =
Changes
*https for api-maps.yandex.ru

= 1.2.1 =
Changes
*Changed javascript creation method
*YANDEX_LOAD_ON_ALL_PAGES now no need
*Improved performance

= 1.1.8 =
No changes. The plugin ready to use.

= 1.1.7 =
URL parameter yandex-map-lang to load different map language:
*http://example.com/?yandex-map-lang=ru_RU
*http://example.com/?yandex-map-lang=en_US
*http://example.com/?yandex-map-lang=en_RU
*http://example.com/?yandex-map-lang=ru_UA
*http://example.com/?yandex-map-lang=uk_UA

New yamap_route display params:
*opacity
*color

In route for "Way Points" set visible false.
Not compatible with the previous version!

Defined parameter YANDEX_LOAD_ON_ALL_PAGES for wp-config.php

= 1.1.6 =
New map behaviors params:

scrollZoom="false"
drag="false"
dblclickzoom="false"
multitouch="false"
rightmousebmagnifier="false"
leftmousebmagnifier="false"

New map display params:

margin_map="10px"
margin_desc="7px"

= 1.1.4 =
*remove_filter('the_content','wptexturize');

= 1.1.3 =
* Correct js

= 1.1.1 =
* Correct js for new data format of WP

= 1.0.3 =
* Added to construct routes

= 1.0.1 =
* Initial release

== Upgrade Notice == 

= 1.0.1 =
Initial release

== A brief Markdown Example and documentation ==

http://xn--80aegccaes4apfcakpli6e.xn--p1ai/yandex-maps-api-for-wordpress/
                                                              