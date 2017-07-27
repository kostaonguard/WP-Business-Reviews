<?php
/**
 * Defines the Admin_Header class
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
 * Creates the admin header for the plugin.
 *
 * @since 1.0.0
 */
class Admin_Header {
	/**
	 * Hooks functionality responsible for rendering the admin header.
	 *
	 * @since  1.0.0
	 */
	public function init() {
		add_action( 'wp_after_admin_bar_render', array( $this, 'render' ) );
	}

	/**
	 * Renders the admin header.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		/**
		 * Fires before an admin header renders.
		 *
		 * @since 1.0.0
		 *
		 * @param string $page Slug of the current admin page.
		 */
		do_action( 'wpbr_before_admin_header_render', $page );

		$view = WPBR_PLUGIN_DIR . 'includes/admin/views/wpbr-admin-header.php';
		include $view;

		/**
		 * Fires after an admin header renders.
		 *
		 * @since 1.0.0
		 *
		 * @param string $page Slug of the current admin page.
		 */
		do_action( 'wpbr_after_admin_header_render', $page );
	}
}
