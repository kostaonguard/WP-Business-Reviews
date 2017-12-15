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

use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Settings\Serializer;
use WP_Business_Reviews\Includes\Settings\Deserializer;
use WP_Business_Reviews\Includes\Settings\Settings;
use WP_Business_Reviews\Includes\Admin\Admin_Menu;
use WP_Business_Reviews\Includes\Admin\Admin_Banner;
use WP_Business_Reviews\Includes\Admin\Admin_Footer;
use WP_Business_Reviews\Includes\Admin\Blank_Slate;
use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Reviews_Builder;
use WP_Business_Reviews\Includes\Settings\Option_Repository;
use WP_Business_Reviews\Includes\Request\Request_Factory;
use WP_Business_Reviews\Includes\Facebook_Page_Manager;

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
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'plugins_loaded', array( $this, 'register_services') );
	}

	/**
	 * Registers the individual services of the plugin.
	 *
	 * @since 0.1.0
	 */
	public function register_services() {
		// Register field parser used to create field objects from configs.
		$field_parser = new Field_Parser();

		// Register settings to retrieve and display settings from database.
		$settings_config           = new Config( WPBR_PLUGIN_DIR . 'configs/config-settings.php' );
		$settings_field_repository = new Field_Repository( $field_parser->parse_config( $settings_config ) );
		$settings_deserializer     = new Deserializer();
		$settings                  = new Settings(
			$settings_config,
			$settings_field_repository,
			$settings_deserializer
		);
		$settings->register();

		// Register assets.
		$assets = new Assets( WPBR_ASSETS_URL, $this->version );
		$assets->register();

		// Register post types.
		$post_types = new Post_Types();
		$post_types->register();

		if ( is_admin() ) {
			// Register settings serializer which saves settings to the database.
			$settings_serializer = new Serializer( $settings_field_repository->get_keys() );
			$settings_serializer->register();

			// Register reviews builder.
			$reviews_builder_config = new Config( WPBR_PLUGIN_DIR . 'configs/config-reviews-builder.php' );
			$reviews_builder        = new Reviews_Builder( $reviews_builder_config, $field_parser );
			$reviews_builder->register();

			// Register remote API requests.
			$request_factory = new Request_Factory( $settings_deserializer );

			// Register Facebook Page Manager.
			$facebook_page_manager = new Facebook_Page_Manager(
				$settings_serializer,
				$request_factory->create( 'facebook' )
			);
			$facebook_page_manager->register();

			// Register platform status checker.
			$active_platforms = $settings_deserializer->get( 'active_platforms') ?: array();
			$platform_manager = new Platform_Manager(
				$settings_serializer,
				$request_factory,
				$active_platforms
			);
			$platform_manager->register();

			// Register admin pages.
			$admin_pages_config = new Config( WPBR_PLUGIN_DIR . 'configs/config-admin-pages.php' );
			$admin_menu         = new Admin_Menu( $admin_pages_config );
			$admin_menu->register();

			// Register the branded admin header.
			$admin_header = new Admin_Banner();
			$admin_header->register();

			// Register admin footer customizations.
			$admin_footer = new Admin_Footer();
			$admin_footer->register();

			// Register blank slate that appears when no posts exist.
			$blank_slate = new Blank_Slate();
			$blank_slate->register();

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
