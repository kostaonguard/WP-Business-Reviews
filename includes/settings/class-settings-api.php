<?php
/**
 * Defines the Settings_API class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;

/**
 * Handles the custom Settings API for the plugin.
 *
 * This plugin does not use the WordPress Settings API.
 *
 * @since 0.1.0
 */
class Settings_API {
	/**
	 * Settings config.
	 *
	 * @since 0.1.0
	 * @var Config $config
	 */
	protected $config;

	/**
	 * Name of the option that stores plugin settings.
	 *
	 * @since 0.1.0
	 * @var string $option
	 */
	protected $option;

	/**
	 * Associative array of settings.
	 *
	 * @since 0.1.0
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * Settings fields.
	 *
	 * @since 0.1.0
	 * @var Field[] $fields
	 */
	protected $fields;

	/**
	 * Instantiates the Settings_API object.
	 *
	 * The required Config object must contain field definitions that can be
	 * parsed into settings.
	 *
	 * @since 0.1.0
	 *
	 * @see WP_Business_Reviews\Includes\Config
	 *
	 * @param string|Config $config Settings config.
	 */
	public function __construct( $config, $option ) {
		$this->config = is_string( $config ) ? new Config( $config ) : $config;
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->settings = get_option( $this->option, array() );
	}
}
