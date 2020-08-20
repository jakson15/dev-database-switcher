<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/jakson15
 * @since             1.0.0
 * @package           Dev_Database_Switcher
 *
 * @wordpress-plugin
 * Plugin Name:       DEV Database Switcher
 * Plugin URI:        https://github.com/jakson15/dev-database-switcher
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Piotr Josko
 * Author URI:        https://github.com/jakson15
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       dev-database-switcher
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
define( 'DEV_DATABASE_SWITCHER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dev-database-switcher-activator.php
 */
function activate_dev_database_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dev-database-switcher-activator.php';
	Dev_Database_Switcher_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dev-database-switcher-deactivator.php
 */
function deactivate_dev_database_switcher() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dev-database-switcher-deactivator.php';
	Dev_Database_Switcher_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dev_database_switcher' );
register_deactivation_hook( __FILE__, 'deactivate_dev_database_switcher' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dev-database-switcher.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dev_database_switcher() {

	$plugin = new Dev_Database_Switcher();
	$plugin->run();

}
run_dev_database_switcher();
