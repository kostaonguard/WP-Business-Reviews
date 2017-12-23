<?php
/**
 * Defines the Settings_Abstract class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Parser\Field_Parser_Abstract as Field_Parser;
use WP_Business_Reviews\Includes\View;

/**
 * Manages settings used throughout the plugin.
 *
 * @since 0.1.0
 */
abstract class Settings_Abstract {
	/**
	 * Settings config.
	 *
	 * @since 0.1.0
	 * @var Config
	 */
	protected $config;

	/**
	 * Parser of field objects from config.
	 *
	 * @since 0.1.0
	 * @var Field_Parser
	 */
	protected $field_parser;

	/**
	 * Array of active platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $active_platforms
	 */
	protected $active_platforms;

	/**
	 * Array of connected platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $connected_platforms
	 */
	protected $connected_platforms;

	/**
	 * Repository that holds field objects.
	 *
	 * @since 0.1.0
	 * @var Field_Repository
	 */
	protected $field_repository;

	/**
	 * URI of the rendered view.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $view;

	/**
	 * Instantiates the Settings_Abstract object.
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
	abstract public function register();

	/**
	 * Parses the config into a repository of field objects.
	 *
	 * @since 0.1.0
	 */
	abstract public function parse_fields();

	/**
	 * Renders the settings UI.
	 *
	 * Active and connected platforms are used to determine platform visibility
	 * as well as connection status.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( $this->view );

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
