<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/jakson15
 * @since      1.0.0
 *
 * @package    Dev_Database_Switcher
 * @subpackage Dev_Database_Switcher/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Dev_Database_Switcher
 * @subpackage Dev_Database_Switcher/includes
 * @author     Piotr Josko <piotrjosko48@gmail.com>
 */
class Dev_Database_Switcher_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'dev-database-switcher',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
