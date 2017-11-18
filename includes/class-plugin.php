<?php
/**
 * Defines the core plugin class
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

/**
 * Loads and registers plugin functionality through WordPress hooks.
 *
 * @since 0.1.0
 */
final class Plugin {
	/**
	 * The name of the plugin in slug form.
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
	 * Instantiates the Plugin object.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->plugin_name = 'wp-business-reviews';
		$this->version     = '0.1.0';
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->register_services();
		// TODO: Add init action for extensibility.
	}

	/**
	 * Registers the individual services of the plugin.
	 *
	 * @since 0.1.0
	 */
	public function register_services() {
		$services = array();

		$services['assets']      = new Assets( WPBR_ASSETS_URL, $this->version );
		$services['post_types']  = new Post_Types();
		$services['settings_ui'] = new Settings\Settings_UI( WPBR_PLUGIN_DIR . 'configs/config-settings.php' );

		if ( is_admin() ) {
			$services['reviews_builder'] = new Reviews_Builder( WPBR_PLUGIN_DIR . 'configs/config-reviews-builder.php' );
			$services['admin_menu']      = new Admin\Admin_Menu( WPBR_PLUGIN_DIR . 'configs/config-admin-pages.php' );
			$services['admin_header']    = new Admin\Admin_Banner();
			$services['admin_footer']    = new Admin\Admin_Footer();
			$services['blank_slate']     = new Admin\Blank_Slate();
		}

		foreach ( $services as $service ) {
			// TODO: Create interface for these classes to ensure register method is defined.
			$service->register();
		}
	}

	/**
	 * Get the name of the plugin
	 *
	 * @since 0.1.0
	 *
	 * @return string The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * Get the version number of the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @return string The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
