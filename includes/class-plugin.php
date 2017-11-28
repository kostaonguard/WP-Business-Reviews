<?php
/**
 * Defines the core plugin class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Settings\Settings_API;
use WP_Business_Reviews\Includes\Admin\Admin_Menu;
use WP_Business_Reviews\Includes\Admin\Admin_Banner;
use WP_Business_Reviews\Includes\Admin\Admin_Footer;
use WP_Business_Reviews\Includes\Admin\Blank_Slate;
use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Reviews_Builder;

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
	 * @var string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $version;

	/**
	 * Instantiates the Plugin object.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->plugin_name  = 'wp-business-reviews';
		$this->version      = '0.1.0';
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

		if ( is_admin() ) {
			$field_parser = new Field_Parser();
			// $services['settings_api']    = new Settings_API( WPBR_PLUGIN_DIR . 'configs/config-settings.php' );
			$services['settings_ui']     = new Settings\Settings_UI( WPBR_PLUGIN_DIR . 'configs/config-settings.php', $field_parser );
			$services['serializer']      = new Settings\Serializer();
			$services['reviews_builder'] = new Reviews_Builder( WPBR_PLUGIN_DIR . 'configs/config-reviews-builder.php', $field_parser );
			$services['admin_menu']      = new Admin_Menu( WPBR_PLUGIN_DIR . 'configs/config-admin-pages.php' );
			$services['admin_header']    = new Admin_Banner();
			$services['admin_footer']    = new Admin_Footer();
			$services['blank_slate']     = new Blank_Slate();
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
