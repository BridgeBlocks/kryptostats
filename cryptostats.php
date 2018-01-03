<?php
/*
 * Plugin Name: Cryptostats
 * Version: 1.0
 * Plugin URI: http://www.mediabridge.io
 * Description: Add crypto widgets to your site that list coin stats.
 * Author: Pål Taule Brentebråten
 * Author URI: www.mediabridge.io
 * Requires at least: 4.9
 * Tested up to: 4.9
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Plugin intitation, activation and deactivation
*/

/* Define plugin folder */
define('CRYPTOSTATS_DIR_PATH', trailingslashit(plugin_dir_path(__FILE__)));

/* Deactivation */
register_deactivation_hook(__FILE__, 'crypotstats_deactivate');

include_once(CRYPTOSTATS_DIR_PATH . '/webpack_enqueue.php');

/* Load the plugin files */
function cryptostats_init() {
  require_once(CRYPTOSTATS_DIR_PATH . 'assets/cryptostats.php');

  if (is_admin()) {
		require_once(CRYPTOSTATS_DIR_PATH . 'assets/admin/cryptostats-admin.php');
	}
}

add_action('init', 'cryptostats_init');



?>
