<?php

/**
 * Defines the core plugin class
 *
 * This class includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 0.1.0
 */
class Plugin {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since 0.1.0
	 * @access   protected
	 * @var      string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 0.1.0
	 * @access   protected
	 * @var      string
	 */
	protected $version;

	/**
	 * The Settings API for the plugin.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    Settings_API
	 */
	protected $settings_api;

	/**
	 * Sets up the plugin.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->plugin_name = 'wpbr';
		$this->version = '0.1.0';
	}

	/**
	 * Begins execution of the plugin.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->load_assets();
		$this->register_settings_api();
		$this->register_post_types();

		if ( is_admin() ) {
			$this->add_admin_pages();
			$this->register_services();
			add_filter( 'admin_body_class', array( $this, 'add_admin_body_class' ) );
			add_action( 'current_screen', array( $this, 'init_blank_slate' ) );
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since  0.1.0
	 *
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since  0.1.0
	 *
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Adds admin body class to all admin pages created by the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @param  string $classes Space-separated list of CSS classes.
	 * @return string Filtered body classes.
	 */
	public function add_admin_body_class( $classes ) {
		if ( isset( $_GET['post_type'] ) && 'wpbr_review' === $_GET['post_type'] ) {
			// Leave space on both sides so other plugins do not conflict.
			$classes .= ' wpbr-admin ';
		}

		return $classes;
	}

	/**
	 * Initializes blank slate that appears in place of empty list tables.
	 *
	 * @since 0.1.0
	 */
	public function init_blank_slate() {
		$screen_id   = get_current_screen()->id;

		if ( 'edit-wpbr_review' === $screen_id ) {
			$blank_slate = new Admin\Blank_Slate( $screen_id );
			$blank_slate->init();
		}
	}

	/**
	 * Loads assets such as scripts, styles, fonts, etc.
	 *
	 * @since 0.1.0
	 */
	private function load_assets() {
		$assets = new Assets( WPBR_ASSETS_URL, WPBR_VERSION );
		$assets->init();
	}

	/**
	 * Registers the Settings API for the plugin.
	 *
	 * @since 0.1.0
	 */
	private function register_settings_api() {
		$this->settings_api = new Settings\Settings_API( WPBR_PLUGIN_DIR . 'configs/config-settings.php' );
		$this->settings_api->register();
		$settings_ui = new Settings\Settings_UI( WPBR_PLUGIN_DIR . 'configs/config-settings.php' );
		$settings_ui->register();
	}

	/**
	 * Loads assets such as scripts, styles, fonts, etc.
	 *
	 * @since 0.1.0
	 */
	private function register_post_types() {
		$post_types = new Post_Types();
		$post_types->init();
	}

	/**
	 * Adds admin pages.
	 *
	 * Creates new admin menu and initializes page components.
	 *
	 * @since 0.1.0
	 */
	private function add_admin_pages() {
		// Add admin menu pages.
		$config     = new Config( WPBR_PLUGIN_DIR . 'configs/config-admin-pages.php' );
		$admin_menu = new Admin\Admin_Menu( $config );
		$admin_menu->register();

		// Add admin banner.
		$admin_header = new Admin\Admin_Banner();
		$admin_header->register();

		// Add admin footer.
		$admin_footer = new Admin\Admin_Footer();
		$admin_footer->register();
	}

	public function register_services() {
		$reviews_builder = new Reviews_Builder( WPBR_PLUGIN_DIR . 'configs/config-reviews-builder.php' );
		$reviews_builder->register();
	}
}
