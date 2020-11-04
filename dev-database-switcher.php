<?php
/**
 * The main plugin file.
 *
 * @link              https://github.com/jakson15
 * @since             1.0.0
 * @package           Dev_Database_Switcher
 *
 * @wordpress-plugin
 * Plugin Name:       DEV Database Switcher
 * Plugin URI:        https://github.com/jakson15/dev-database-switcher
 * Description:       Simple plugin to switch between local and remote database by one click.
 * Version:           1.0.0
 * Author:            Piotr Josko
 * Author URI:        https://github.com/jakson15
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       dev-database-switcher
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
 * Dashboard admin info if proper file does not exists.
 */
function remote_database_config_exists() {
		$class   = 'notice notice-error';
		$message = __( 'Some file missed. Create proper wp-config.php file to switch database.', 'dev-database-switcher' );

		printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
/**
 * Add admin bar switcher.
 *
 * @param WP_Admin_Bar $admin_bar WP_Admin_Bar instance, passed by reference.
 */
function dds_admin_bar_switcher( $admin_bar ) {
	$database_type = get_option( 'dds_database_type', 'local' );
	$changed_db    = 'local' === $database_type ? 'remote' : 'local';

	$admin_bar->add_menu(
		array(
			'id'    => 'dds-database-type',
			'title' => strtoupper( $database_type ) . ' DB',
			'meta'  => array(
				'title' => strtoupper( get_option( 'dbs_database_type', 'local' ) ) . ' DB',
			),
		)
	);

	$admin_bar->add_menu(
		array(
			'id'     => 'dds-database-type-change',
			'parent' => 'dds-database-type',
			'title'  => strtoupper( 'local' === $database_type ? 'remote' : 'local' ) . ' DB',
			'href'   => admin_url() . '?database_type=' . $changed_db,
			'meta'   => array(
				'title' => strtoupper( 'local' === $database_type ? 'remote' : 'local' ) . ' DB',
			),
		)
	);
}

add_action( 'admin_bar_menu', 'dds_admin_bar_switcher', 100 );

/**
 * Changes databases based on wp-config.php files.
 */
function change_database() {

	if ( ! empty( $_GET['database_type'] ) ) {
		$database_type = get_option( 'dds_database_type', 'local' );
		if ( 'local' === $_GET['database_type'] && 'remote' === $database_type ) {

			if ( file_exists( ABSPATH . 'wp-config-local.php' ) ) {
				rename( ABSPATH . 'wp-config.php', ABSPATH . 'wp-config-remote.php' );
				rename( ABSPATH . 'wp-config-local.php', ABSPATH . 'wp-config.php' );
				wp_safe_redirect( admin_url() );
			} else {
				add_action( 'admin_notices', 'remote_database_config_exists' );
			}
		} elseif ( 'remote' === $_GET['database_type'] && 'local' === $database_type ) {
			if ( file_exists( ABSPATH . 'wp-config-remote.php' ) ) {
				rename( ABSPATH . 'wp-config.php', ABSPATH . 'wp-config-local.php' );
				rename( ABSPATH . 'wp-config-remote.php', ABSPATH . 'wp-config.php' );
				wp_safe_redirect( admin_url() );
			} else {
				add_action( 'admin_notices', 'remote_database_config_exists' );
			}
		}
	}
}

add_action( 'init', 'change_database', 2 );

/**
 * Check active database.
 */
function check_active_database() {
	if ( file_exists( ABSPATH . 'wp-config-remote.php' ) ) {
		update_option( 'dds_database_type', 'local' );
	} elseif ( file_exists( ABSPATH . 'wp-config-local.php' ) ) {
		update_option( 'dds_database_type', 'remote' );
	}
}

add_action( 'init', 'check_active_database', 1 );

/**
 * Login without password.
 *
 * A WP_User object is returned if the credentials authenticate a user.
 * WP_Error or null otherwise.
 *
 * @param null|WP_User|WP_Error $user     WP_User if the user is authenticated.
 *                                        WP_Error or null otherwise.
 * @param string                $username Username or email address.
 * @param string                $password User password.
 */
function auto_login( $user, $username, $password ) {
	$username = defined( 'LOGIN_USERNAME' ) && ! $user ? LOGIN_USERNAME : '';

	if ( ! $user ) {
		$user = get_user_by( 'email', $username );
	}
	if ( ! $user ) {
		$user = get_user_by( 'login', $username );
	}

	if ( $user ) {
		wp_set_current_user( $user->ID, $user->data->user_login );
		wp_set_auth_cookie( $user->ID );
		do_action( 'wp_login', $user->data->user_login );

		wp_safe_redirect( admin_url() );
		exit;
	}
}

$whitelist = array( '127.0.0.1', '::1' );

if ( isset( $_SERVER['REMOTE_ADDR'] ) && in_array( $_SERVER['REMOTE_ADDR'], $whitelist, true ) ) {
	add_filter( 'authenticate', 'auto_login', 3, 10 );
}
