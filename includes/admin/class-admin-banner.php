<?php
/**
 * Defines the Admin_Banner class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Admin;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the admin banner for the plugin.
 *
 * @since 0.1.0
 */
class Admin_Banner {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_after_admin_bar_render', array( $this, 'render' ) );
	}

	/**
	 * Renders the admin banner.
	 *
	 * @since 0.1.0
	 */
	public function render() {
		$current_screen = get_current_screen();

		if ( ! empty( $current_screen->id ) && false !== strpos( $current_screen->id, 'wpbr_review_page' ) ) {
			include WPBR_PLUGIN_DIR . 'includes/admin/views/wpbr-admin-banner.php';
		}
	}
}
