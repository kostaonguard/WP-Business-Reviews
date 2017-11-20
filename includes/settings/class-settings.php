<?php
/**
 * Defines the Settings class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

/**
 * Handles the custom settings for the plugin.
 *
 * This plugin does not use the WordPress Settings API.
 *
 * @since 0.1.0
 */
class Settings {
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
	 * Instantiates the Settings object.
	 *
	 * The required Config object must contain field definitions that can be
	 * parsed into settings.
	 *
	 * @since 0.1.0
	 *
	 * @see WP_Business_Reviews\Includes\Config
	 *
	 * @param Config Settings config.
	 */
	public function __construct( Config $config ) {
		$this->config = $config;
	}
}
