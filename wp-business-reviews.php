<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and starts the plugin.
 *
 * @link              https://wpbusinessreviews.com
 * @package           WP_Business_Reviews
 * @since             0.1.0
 *
 * @wordpress-plugin
 * Plugin Name:       WP Business Reviews
 * Plugin URI:        https://wpbusinessreviews.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           0.1.0
 * Author:            WordImpress, LLC
 * Author URI:        https://wordimpress.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpbr
 * Domain Path:       /languages
 */

namespace WP_Business_Reviews;

use WP_Business_Reviews\Includes\Activator;
use WP_Business_Reviews\Includes\Deactivator;
use WP_Business_Reviews\Includes\Plugin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define plugin folder Path.
if ( ! defined( 'WPBR_PLUGIN_DIR' ) ) {
	define( 'WPBR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Define plugin folder URL.
if ( ! defined( 'WPBR_PLUGIN_URL' ) ) {
	define( 'WPBR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

// Define plugin root File.
if ( ! defined( 'WPBR_PLUGIN_FILE' ) ) {
	define( 'WPBR_PLUGIN_FILE', __FILE__ );
}

// Define assets folder URL.
if ( ! defined( 'WPBR_ASSETS_URL' ) ) {
	define( 'WPBR_ASSETS_URL', plugin_dir_url( __FILE__ ) . 'assets/dist/' );
}

// Require WP Business Reviews autoloader.
require_once __DIR__ . '/autoloader.php';

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_wp_business_reviews() {
	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_wp_business_reviews() {
	Deactivator::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_wp_business_reviews' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_wp_business_reviews' );

// Initialize plugin.
$plugin = new Plugin();
$plugin->init();
