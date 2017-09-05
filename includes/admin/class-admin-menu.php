<?php
/**
 * Defines the Admin_Menu class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin;

use WP_Business_Reviews\Includes\Admin\Pages;

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
	 * The Settings API for the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Settings_API
	 */
	protected $settings_api;

	/**
	 * Provides the Settings API used in admin pages.
	 *
	 * @since 1.0.0
	 *
	 * @param Settings_API $settings_api Settings API for the plugin.
	 */
	public function __construct( $settings_api ) {
		$this->settings_api = $settings_api;
	}

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
		$settings_api = $this->settings_api;

		// Add Reviews Builder page.
		$page_builder = new Pages\Admin_Page_Builder( $settings_api );

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'Reviews Builder', 'wpbr' ),
			__( 'Reviews Builder', 'wpbr' ),
			'manage_options',
			'wpbr_reviews_builder',
			array( $page_builder, 'render_page' )
		);

		// Pass settings object to settings page.
		$page_settings = new Pages\Admin_Page_Settings( $settings_api );

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'General Settings', 'wpbr' ),
			__( 'Settings', 'wpbr' ),
			'manage_options',
			'wpbr_settings',
			array( $page_settings, 'render_page' )
		);

		// TODO: Remove API Test page prior to launch.
		// Add API Test page.
		$page_api_test = new Pages\Admin_Page_API_Test( $settings_api );

		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'API Test', 'wpbr' ),
			__( 'API Test', 'wpbr' ),
			'manage_options',
			'wpbr_api_test',
			array( $page_api_test, 'render_page' )
		);
	}
}
