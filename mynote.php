<?php
/**
 * Mynote Admin
 *
 * @name Terry Lin
 * @link https://terryl.in/
 *
 * @package Mynote
 * @since 1.0.0
 * @version 1.0.1
 */

/**
 * Plugin Name: Mynote Admin
 * Plugin URI:  https://github.com/terrylinooo/mynote-admin
 * Description: A plugin that enhances Mynote theme's functionality. 
 * Version:     1.0.1
 * Author:      Terry Lin
 * Author URI:  https://terryl.in/
 * License:     GPL 3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: mynote-admin
 * Domain Path: /languages
 */

/**
 * This plugin requires Mynote theme installed, or nothing happens.
 * https://wordpress.org/themes/mynote/
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * CONSTANTS
 * 
 * MYNOTE_PLUGIN_NAME          : Plugin's name.
 * MYNOTE_PLUGIN_DIR           : The absolute path of the MYNOTE plugin directory.
 * MYNOTE_PLUGIN_URL           : The URL of the MYNOTE plugin directory.
 * MYNOTE_PLUGIN_PATH          : The absolute path of the MYNOTE plugin launcher.
 * MYNOTE_PLUGIN_LANGUAGE_PACK : Translation Language pack.
 * MYNOTE_PLUGIN_VERSION       : MYNOTE plugin version number
 * MYNOTE_PLUGIN_TEXT_DOMAIN   : MYNOTE plugin text domain
 * 
 * Expected values:
 * 
 * MYNOTE_PLUGIN_DIR           : {absolute_path}/wp-content/plugins/mynote-plugin/
 * MYNOTE_PLUGIN_URL           : {protocal}://{domain_name}/wp-content/plugins/mynote-plugin/
 * MYNOTE_PLUGIN_PATH          : {absolute_path}/wp-content/plugins/mynote-plugin/mynote-plugin.php
 * MYNOTE_PLUGIN_LANGUAGE_PACK : mynote-plugin/languages
 */

define( 'MYNOTE_PLUGIN_NAME', plugin_basename( __FILE__ ) );
define( 'MYNOTE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'MYNOTE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'MYNOTE_PLUGIN_PATH', __FILE__ );
define( 'MYNOTE_PLUGIN_LANGUAGE_PACK', dirname( plugin_basename( __FILE__ ) ) . '/languages' );
define( 'MYNOTE_PLUGIN_VERSION', '1.0.1' );
define( 'MYNOTE_PLUGIN_TEXT_DOMAIN', 'mynote-admin' );

/**
 * Start to run MYNOTE plugin cores.
 */

// Loadd Mynote Plugin's autoloader.
require_once MYNOTE_PLUGIN_DIR . 'includes/mynote-autoload.php';

// Load helper functions
require_once MYNOTE_PLUGIN_DIR . 'includes/mynote-helpers.php';

if ( version_compare( phpversion(), '5.1.0', '>=' ) ) {

	$current_theme = wp_get_theme();

	// This plugin only works when Mynote theme is activated.
	if ( 'Mynote' === substr($current_theme->Name, 0, 6) ) {

		$mynote = new Mynote();
		$mynote->init();
	}

} else {
	/**
	 * Prompt a warning message while PHP version does not meet the minimum requirement.
	 * And, nothing to do.
	 */
	function mynote_plugin_warning() {
		echo mynote_load_view( 'messages/php-version-warning' );
	}
	add_action( 'admin_notices', 'mynote_plugin_warning' );
}
