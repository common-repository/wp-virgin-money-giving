<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.squareonemd.co.uk
 * @since             1.0.0
 * @package           WP_Virgin_Money_Giving
 *
 * @wordpress-plugin
 * Plugin Name:       WordPress Virgin Money Giving
 * Plugin URI:        http://www.squareonemd.co.uk/
 * Description:       A plugin that uses the Virgin Money Giving API to feed data in to your website via a widget.
 * Version:           1.1.6
 * Author:            Elliott Richmond Square One
 * Author URI:        http://www.squareonemd.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-virgin-money-giving
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-virgin-money-giving-activator.php
 */
function activate_WP_Virgin_Money_Giving() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-virgin-money-giving-activator.php';
	WP_Virgin_Money_Giving_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-virgin-money-giving-deactivator.php
 */
function deactivate_WP_Virgin_Money_Giving() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-virgin-money-giving-deactivator.php';
	WP_Virgin_Money_Giving_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_WP_Virgin_Money_Giving' );
register_deactivation_hook( __FILE__, 'deactivate_WP_Virgin_Money_Giving' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-virgin-money-giving.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_WP_Virgin_Money_Giving() {

	$plugin = new WP_Virgin_Money_Giving();
	$plugin->run();

}
run_WP_Virgin_Money_Giving();
