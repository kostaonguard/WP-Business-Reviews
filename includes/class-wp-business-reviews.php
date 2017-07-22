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
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'wpbr';
		$this->version = '1.0.0';
		$this->set_locale();
	}

	/**
	 * Begins execution of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function init() {
		// Register post types.
		$post_types = new Post_Types();
		$post_types->init();

		if ( is_admin() ) {
			$this->add_admin_pages();
		}
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {
		$plugin_i18n = new I18n();

		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );
	}

	/**
	 * Register the plugin's widgets.
	 *
	 * @since    1.0.0
	 */
	public function register_widgets() {
		register_widget( __NAMESPACE__ . '\Widget\Business_Widget' );
	}

	/**
	 * Adds admin pages.
	 *
	 * @since    1.0.0
	 */
	private function add_admin_pages() {
		// Create new admin menu and pass page instance used to render pages.
		$admin_menu = new Admin\Admin_Menu( new Admin\Admin_Page() );
		$admin_menu->init();
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
}
