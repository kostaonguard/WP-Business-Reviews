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
 * Registers new menu items under 'Reviews' and uses the dependency passed into
 * the constructor to display the page corresponding to the menu item.
 *
 * @package Custom_Admin_Settings
 */
class Admin_Menu {
	/**
	 * Reference to the class responsible for rendering the admin page.
	 *
	 * @since  1.0.0
	 * @var    Admin_Page
	 * @access private
	 */
	private $admin_page;

	/**
	 * Defines the page object responsible for rendering admin pages.
	 *
	 * @since  1.0.0
	 *
	 * @param Admin_Page $admin_page Reference to the class responsible for
	 *                               rendering the page(s).
	 */
	public function __construct( $admin_page ) {
		$this->admin_page = $admin_page;
	}

	/**
	 * Hooks functionality responsible for building the admin menu.
	 *
	 * @since  1.0.0
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
	}

	/**
	 * Creates the menu and calls on the Admin_Page object to render the actual
	 * contents of the page.
	 *
	 * @since  1.0.0
	 */
	public function add_pages() {
		// Add Reviews Builder page.
		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'Reviews Builder', 'wpbr' ),
			__( 'Reviews Builder', 'wpbr' ),
			'manage_options',
			'wpbr-reviews-builder',
			array( $this->admin_page, 'render' )
		);

		// Add Settings page.
		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'General Settings', 'wpbr' ),
			__( 'Settings', 'wpbr' ),
			'manage_options',
			'wpbr-settings',
			array( $this->admin_page, 'render' )
		);

		// Add API Test page.
		// TODO: Remove API Test page prior to launch.
		add_submenu_page(
			'edit.php?post_type=wpbr_review',
			__( 'API Test', 'wpbr' ),
			__( 'API Test', 'wpbr' ),
			'manage_options',
			'wpbr-api-test',
			array( $this->admin_page, 'render' )
		);
	}
}
