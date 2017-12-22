<?php
/**
 * Defines the Plugin_Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\View;

/**
 * Retrieves and displays the plugin's settings.
 *
 * @since 0.1.0
 */
class Plugin_Settings {
	/**
	 * Settings config.
	 *
	 * @since 0.1.0
	 * @var Config
	 */
	private $config;

	/**
	 * Parser of field objects from config.
	 *
	 * @since 0.1.0
	 * @var Field_Parser
	 */
	private $field_parser;

	/**
	 * Array of active platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $active_platforms
	 */
	private $active_platforms;

	/**
	 * Array of connected platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $connected_platforms
	 */
	private $connected_platforms;

	/**
	 * Repository that holds field objects.
	 *
	 * @since 0.1.0
	 * @var Field_Repository
	 */
	private $field_repository;

	/**
	 * Instantiates the Plugin_Settings object.
	 *
	 * @since 0.1.0
	 *
	 * @param Config       $config              Settings config.
	 * @param Field_Parser $field_parser        Parser of field objects from config.
	 * @param array        $active_platforms    Array of active platform slugs.
	 * @param array        $connected_platforms Array of connected platform slugs.
	 */
	public function __construct(
		Config $config,
		Field_Parser $field_parser,
		array $active_platforms,
		array $connected_platforms
	) {
		$this->config              = $config;
		$this->field_parser        = $field_parser;
		$this->active_platforms    = $active_platforms;
		$this->connected_platforms = $connected_platforms;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_admin_page_wpbr_settings', array( $this, 'init' ) );
		add_action( 'wp_business_reviews_admin_page_wpbr_settings', array( $this, 'render' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$field_objects          = $this->field_parser->parse_config( $this->config );
		$this->field_repository = new Field_Repository( $field_objects );
	}

	/**
	 * Renders the settings UI.
	 *
	 * Active and connected platforms are used to determine platform visibility
	 * as well as connection status.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/settings/settings-main.php' );

		$view_object->render(
			array(
				'config'              => $this->config,
				'field_repository'    => $this->field_repository,
				'active_platforms'    => $this->active_platforms,
				'connected_platforms' => $this->connected_platforms,
			)
		);
	}
}
