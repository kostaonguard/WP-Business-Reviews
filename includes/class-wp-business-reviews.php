<?php

/**
 * Defines the core plugin class
 *
 * This class includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @package WP_Business_Reviews\Includes
 * @since   1.0.0
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
 * @since 1.0.0
 */
final class WP_Business_Reviews {
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string
	 */
	protected $version;

	/**
	 * The Settings API for the plugin.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    Settings_API
	 */
	protected $settings_api;

	/**
	 * Sets up the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'wpbr';
		$this->version = '1.0.0';
		$this->define_locale();
	}

	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function init() {
		$this->load_assets();
		$this->register_settings_api();
		$this->register_post_types();

		if ( is_admin() ) {
			$this->add_admin_pages();
			add_filter( 'admin_body_class', array( $this, 'add_admin_body_class' ) );
			add_action( 'current_screen', array( $this, 'init_blank_slate' ) );
		}
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Adds admin body class to all admin pages created by the plugin.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	public function init_blank_slate() {
		$screen_id   = get_current_screen()->id;

		if ( 'edit-wpbr_review' === $screen_id ) {
			$blank_slate = new Admin\Blank_Slate( $screen_id );
			$blank_slate->init();
		}
	}

	/**
	 * Defines the locale for this plugin for internationalization.
	 *
	 * @since    1.0.0
	 */
	private function define_locale() {
		$plugin_i18n = new I18n();
		$plugin_i18n->init();
	}

	/**
	 * Loads assets such as scripts, styles, fonts, etc.
	 *
	 * @since    1.0.0
	 */
	private function load_assets() {
		$assets = new Assets( WPBR_PLUGIN_URL . '/assets/', WPBR_VERSION );
		$assets->init();
	}


	/**
	 * Registers the Settings API for the plugin.
	 *
	 * @since 1.0.0
	 */
	private function register_settings_api() {
		$this->settings_api = new Settings\Settings_API();
		$this->settings_api->init();
	}

	/**
	 * Loads assets such as scripts, styles, fonts, etc.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 */
	private function add_admin_pages() {
		// Add admin menu pages.
		$admin_menu = new Admin\Admin_Menu( $this->settings_api );
		$admin_menu->init();

		// Add admin header.
		$admin_header = new Admin\Admin_Header();
		$admin_header->init();

		// Add admin footer.
		$admin_footer = new Admin\Admin_Footer();
		$admin_footer->init();
	}
}
