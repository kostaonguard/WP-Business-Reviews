<?php
/**
 * Defines the Admin_Page abstract class
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
 * Each individual admin page should extend this abstract class and provide its
 * own method to render the page per its needs.
 *
 * @since 1.0.0
 * @see Admin_Menu
 */
abstract class Admin_Page {
	/**
	 * Renders content of the admin page.
	 *
	 * @since 1.0.0
	 */
	abstract public function render();
}
