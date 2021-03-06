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

use WP_Business_Reviews\Includes\Field\Parser\Plugin_Settings_Field_Parser;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Serializer\Option_Serializer;
use WP_Business_Reviews\Includes\Deserializer\Option_Deserializer;
use WP_Business_Reviews\Includes\Settings\Plugin_Settings;
use WP_Business_Reviews\Includes\Admin\Admin_Menu;
use WP_Business_Reviews\Includes\Admin\Admin_Banner;
use WP_Business_Reviews\Includes\Admin\Admin_Footer;
use WP_Business_Reviews\Includes\Admin\Blank_Slate;
use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Request\Request_Factory;
use WP_Business_Reviews\Includes\Facebook_Page_Manager;
use WP_Business_Reviews\Includes\Platform_Manager;
use WP_Business_Reviews\Includes\Settings\Builder_Settings;
use WP_Business_Reviews\Includes\Field\Parser\Builder_Field_Parser;
use WP_Business_Reviews\Includes\Request\Request_Delegator;
use WP_Business_Reviews\Includes\Request\Response_Normalizer\Response_Normalizer_Factory;
use WP_Business_Reviews\Includes\Serializer\Review_Serializer;
use WP_Business_Reviews\Includes\Serializer\Review_Source_Serializer;
use WP_Business_Reviews\Includes\Serializer\Review_Collection_Serializer;
use WP_Business_Reviews\Includes\Deserializer\Review_Deserializer;
use WP_Business_Reviews\Includes\Deserializer\Review_Collection_Deserializer;
use WP_Business_Reviews\Includes\Shortcode\Review_Collection_Shortcode;
use WP_Business_Reviews\Includes\Widget\Review_Collection_Widget;

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
		// Register assets.
		$assets = new Assets( WPBR_ASSETS_URL, $this->version );
		$assets->register();

		// Register post types.
		$post_types = new Post_Types();
		$post_types->register();

		// Register post deserializers.
		$review_collection_deserializer = new Review_Collection_Deserializer(
			new \WP_Query()
		);
		$review_deserializer            = new Review_Deserializer( new \WP_Query() );

		// Register widgets.
		$review_collection_widget = new Review_Collection_Widget(
			$review_collection_deserializer,
			$review_deserializer
		);
		$review_collection_widget->register();

		// Register shortcodes.
		$review_collection_shortcode = new Review_Collection_Shortcode(
			$review_collection_deserializer,
			$review_deserializer
		);
		$review_collection_shortcode->register();

		if ( is_admin() ) {
			// Register settings.
			$option_deserializer = new Option_Deserializer();
			$option_serializer   = new Option_Serializer();
			$option_serializer->register();

			// Register factories for handling remote API requests.
			$request_factory             = new Request_Factory( $option_deserializer );
			$response_normalizer_factory = new Response_Normalizer_Factory();

			// Register platform manager to manage active and connected platforms.
			$platform_manager = new Platform_Manager(
				$option_deserializer,
				$option_serializer,
				$request_factory
			);
			$platform_manager->register();

			// Register request delegator to handle Ajax requests.
			$request_delegator = new Request_Delegator(
				$request_factory,
				$response_normalizer_factory
			);
			$request_delegator->register();

			// Register plugin settings.
			$plugin_settings_config       = new Config( WPBR_PLUGIN_DIR . 'config/config-plugin-settings.php' );
			$plugin_settings_field_parser = new Plugin_Settings_Field_Parser( $option_deserializer );
			$plugin_settings              = new Plugin_Settings(
				$plugin_settings_config,
				$plugin_settings_field_parser,
				$platform_manager->get_active_platforms(),
				$platform_manager->get_connected_platforms()
			);
			$plugin_settings->register();

			// Register Builder.
			$builder_settings_config = new Config( WPBR_PLUGIN_DIR . 'config/config-builder-settings.php' );
			$builder_field_parser    = new Builder_Field_Parser();
			$builder_settings        = new Builder_Settings(
				$builder_settings_config,
				$builder_field_parser,
				$platform_manager->get_active_platforms(),
				$platform_manager->get_connected_platforms()
			);
			$builder_settings->register();

			$review_serializer = new Review_Serializer();
			$review_serializer->register();

			$review_source_serializer = new Review_Source_Serializer();
			$review_source_serializer->register();

			$review_collection_serializer = new Review_Collection_Serializer();
			$review_collection_serializer->register();

			// Register Facebook page manager to retrieve and update authenticated pages.
			$facebook_page_manager = new Facebook_Page_Manager(
				$option_deserializer->get( 'facebook_pages' ) ?: array(),
				$option_serializer,
				$request_factory->create( 'facebook' )
			);
			$facebook_page_manager->register();

			// Register admin pages.
			$admin_pages_config = new Config( WPBR_PLUGIN_DIR . 'config/config-admin-pages.php' );
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
