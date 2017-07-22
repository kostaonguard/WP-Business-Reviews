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
		$this->register_post_types();

		if ( is_admin() ) {
			$this->add_admin_pages();
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
	 * Creates new admin menu and passes page instance used to render page.
	 *
	 * @since    1.0.0
	 */
	private function add_admin_pages() {
		$admin_menu = new Admin\Admin_Menu( new Admin\Admin_Page() );
		$admin_menu->init();
	}
}
