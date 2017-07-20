<?php
/**
 * Defines the Admin_Page class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin;

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
	// TODO: Add constructor with deserializer to read saved options.

	/**
	 * Renders content of the page associated with menu item.
	 *
	 * Detects the current page based on $_GET parameter and includes a view
	 * of the same name.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		$page = empty( $_GET['page'] ) ? '' : urldecode( $_GET['page'] );
		$file = dirname( __FILE__ ) . '/views/' . $page . '.php';

		if ( $page && file_exists( $file ) ) {
			/**
			 * Fires before an admin page renders.
			 *
			 * Useful for adding a page header to admin pages.
			 *
			 * @since 1.0.0
			 *
			 * @param string $page Slug of the current admin page.
			 */
			do_action( 'wpbr_before_admin_page_render', $page );

			include_once( $file );

			/**
			 * Fires after an admin page renders.
			 *
			 * Useful for adding a page footer to admin pages.
			 *
			 * @since 1.0.0
			 *
			 * @param string $page Slug of the current admin page.
			 */
			do_action( 'wpbr_after_admin_page_render', $page );
		} else {
			// TODO: Display page detection error.
		}
	}
}
