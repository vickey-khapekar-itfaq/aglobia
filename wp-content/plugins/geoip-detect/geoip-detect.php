<?php
/*
Plugin Name:     Geolocation IP Detection
Plugin URI:      http://www.yellowtree.de
Description:     Retrieving Geo-Information using the Maxmind GeoIP (Lite) Database.
Author:          Yellow Tree (Benjamin Pick)
Author URI:      http://www.yellowtree.de
Version:         3.0.3.1
License:         GPLv3 or later
License URI:     http://www.gnu.org/licenses/gpl-3.0.html
Text Domain:     geoip-detect
Domain Path:     /languages
GitHub Plugin URI: https://github.com/yellowtree/geoip-detect
GitHub Branch:   master
Requires WP:     4.0
Requires PHP:    5.6
*/

define('GEOIP_DETECT_VERSION', '3.0.3.1');

/*
Copyright 2013-2020 Yellow Tree, Siegen, Germany
Author: Benjamin Pick (wp-geoip-detect| |posteo.de)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('GEOIP_REQUIRED_PHP_VERSION', '5.6');

// In theory, it should still run in 3.5 . But officially supported is only WP 4.0 and above.
define('GEOIP_REQUIRED_WP_VERSION', '3.5');

define('GEOIP_PLUGIN_FILE', __FILE__);
define('GEOIP_PLUGIN_DIR', dirname(GEOIP_PLUGIN_FILE));
define('GEOIP_PLUGIN_BASENAME', plugin_basename(GEOIP_PLUGIN_FILE));
define('GEOIP_DETECT_PLUGIN_URI', plugin_dir_url(GEOIP_PLUGIN_FILE));


// Do PHP & WP Version check
require_once(GEOIP_PLUGIN_DIR . '/check_requirements.php');
if (!geoip_detect_version_check()) {
	require_once(GEOIP_PLUGIN_DIR . '/api-stubs.php');
	return; // Do nothing except emitting the admin notice
}

require_once(GEOIP_PLUGIN_DIR . '/vendor/autoload.php');
require_once(GEOIP_PLUGIN_DIR . '/init.php');

require_once(GEOIP_PLUGIN_DIR . '/geoip-detect-lib.php');
require_once(GEOIP_PLUGIN_DIR . '/lib/geonames/geonames-country-info.php');
require_once(GEOIP_PLUGIN_DIR . '/lib/get-client-ip.php');

require_once(GEOIP_PLUGIN_DIR . '/upgrade-plugin.php');
require_once(GEOIP_PLUGIN_DIR . '/api.php');
require_once(GEOIP_PLUGIN_DIR . '/legacy-api.php');
require_once(GEOIP_PLUGIN_DIR . '/deprecated.php');
require_once(GEOIP_PLUGIN_DIR . '/filter.php');
require_once(GEOIP_PLUGIN_DIR . '/shortcode.php');
require_once(GEOIP_PLUGIN_DIR . '/ajax.php');

require_once(GEOIP_PLUGIN_DIR . '/data-sources/registry.php');
require_once(GEOIP_PLUGIN_DIR . '/data-sources/abstract.php');

// These data-source files are optional
include_once(GEOIP_PLUGIN_DIR . '/data-sources/hostinfo.php');
include_once(GEOIP_PLUGIN_DIR . '/data-sources/manual.php');
include_once(GEOIP_PLUGIN_DIR . '/data-sources/auto.php');
include_once(GEOIP_PLUGIN_DIR . '/data-sources/precision.php');
include_once(GEOIP_PLUGIN_DIR . '/data-sources/header.php');
include_once(GEOIP_PLUGIN_DIR . '/data-sources/ipstack.php');

// You can define these constants in your theme/plugin if you like.

/**
 * Set to TRUE if the plugin should never auto-update the Maxmind City Lite database.
 */
//define('GEOIP_DETECT_AUTO_UPDATE_DEACTIVATED', true);

/**
 * How long the external IP of the server is cached.
 * This is probably only used in dev cases, so per default relatively low.
 */
//define('GEOIP_DETECT_IP_CACHE_TIME', 2 * HOUR_IN_SECONDS);

/**
 * How long the external IP of the server is cached, if no IP was found.
 * Default: the same as GEOIP_DETECT_IP_CACHE_TIME
 */
//define('GEOIP_DETECT_IP_EMPTY_CACHE_TIME', 2 * HOUR_IN_SECONDS);

/**
 * How long the data of the IP is cached. This applies to the Web-APIs (Maxmind Precision and HostIP.info)
 * Only successful lookups will be cached.
 */
//define('GEOIP_DETECT_READER_CACHE_TIME', 7 * DAY_IN_SECONDS);



require_once(GEOIP_PLUGIN_DIR . '/admin-ui.php');
