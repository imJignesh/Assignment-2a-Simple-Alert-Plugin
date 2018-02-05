<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Simple_Alert
 *
 * @wordpress-plugin
 * Plugin Name:       Simple Alert Plugin
 * Plugin URI:        https://github.com/imJignesh/Assignment-2a-Simple-Alert-Plugin/
 * Description:       When user will open any page, post or custom post type post and if it is selected from admin side then alert box should be opened. Alert box should contain admin side added text from settings page.
 * Version:           1.0.0
 * Author:            imJignesh
 * Author URI:        https://github.com/imJignesh/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       simple-alert
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_ALERT_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-alert.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_alert() {

	$plugin = new Simple_Alert();
	$plugin->run();

}
run_simple_alert();



