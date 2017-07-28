<?php
/**
 * Defines the Admin_Menu class
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
 * Creates the menu for the plugin.
 *
 * Adds menu pages under 'Reviews' and provides the page objects used to render
 * their corresponding menu pages.
 *
 * @package Custom_Admin_Settings
 */
class Admin_Menu {
	/**
	 * Hooks functionality responsible for building the admin menu.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
	}

	/**
	 * Creates the menu and calls on the Admin_Page object to render the actual
	 * contents of the page.
	 *
	 * @since 1.0.0
	 */
	public function add_pages() {
		// Add Reviews Builder page.
		$page_reviews_builder = new Pages\Admin_Page_Reviews_Builder();

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'Reviews Builder', 'wpbr' ),
			__( 'Reviews Builder', 'wpbr' ),
			'manage_options',
			'wpbr-reviews-builder',
			array( $page_reviews_builder, 'render' )
		);

		// Pass settings API to settings page.
		$settings_api = new Settings\WPBR_Settings_API();
		$page_settings = new Pages\Admin_Page_Settings( $settings_api );

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'General Settings', 'wpbr' ),
			__( 'Settings', 'wpbr' ),
			'manage_options',
			'wpbr-settings',
			array( $page_settings, 'render' )
		);

		// TODO: Remove API Test page prior to launch.
		// Add API Test page.
		$page_api_test = new Pages\Admin_Page_API_Test();

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'API Test', 'wpbr' ),
			__( 'API Test', 'wpbr' ),
			'manage_options',
			'wpbr-api-test',
			array( $page_api_test, 'render' )
		);
	}
}
