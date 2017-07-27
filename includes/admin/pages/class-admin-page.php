<?php
/**
 * Defines the Admin_Page class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the admin page for the plugin.
 *
 * Provides the functionality necessary for rendering the page corresponding
 * to the menu item with which this page is associated.
 *
 * @since 1.0.0
 * @see Admin_Menu
 */
class Admin_Page {
	/**
	 * Renders content of the page associated with menu item.
	 *
	 * Detects the current page based on $_GET parameter and includes a view
	 * of the same name.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		if ( ! empty( $_GET['page'] ) ) {
			$view = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/' . urldecode( $_GET['page'] ) . '.php';
			include $view;
		}
	}
}
