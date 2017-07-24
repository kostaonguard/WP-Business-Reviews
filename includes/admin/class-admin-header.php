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
		add_action( 'wpbr_before_admin_page_render', array( $this, 'render' ) );
	}

	/**
	 * Renders the admin header.
	 *
	 * @since 1.0.0
	 */
	public function render() {
		$file = dirname( __FILE__ ) . '/views/partials/wpbr-admin-header.php';

		if ( file_exists( $file ) ) {
			include_once( $file );
		}
	}
}
