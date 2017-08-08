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
		$current_screen = get_current_screen();

		if ( ! empty( $current_screen->id ) && false !== strpos( $current_screen->id, 'wpbr_review_page' ) ) {
			include WPBR_PLUGIN_DIR . 'includes/admin/views/wpbr-admin-header.php';
		}
	}
}
