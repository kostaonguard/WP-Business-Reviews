<?php
/**
 * Defines the Builder_Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Config;

/**
 * Retrieves and displays the plugin's settings.
 *
 * @since 0.1.0
 */
class Builder_Settings extends Settings_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $view = WPBR_PLUGIN_DIR . 'views/builder/builder.php';

	/**
	 * @inheritDoc
	 */
	public function register() {
		add_action( 'wp_business_reviews_admin_page_wpbr_builder', array( $this, 'init' ) );
		add_action( 'wp_business_reviews_admin_page_wpbr_builder', array( $this, 'render' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * There are three possible scenarios when the builder is loaded:
	 *
	 * 1. An existing review set is defined in the URL, so load it.
	 * 2. A platform is defined but not a review set, so display empty builder
	 *    that is configured for that platform.
	 * 3. Neither a review set or platform is defined, so display the launcher.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		if( isset( $_GET['wpbr_platform'] ) ) {
			$this->platform         = sanitize_text_field( $_GET['wpbr_platform'] );
			$this->config           = $this->prepare_config( $this->config, $this->platform );
			$this->field_repository = new Field_Repository(
				$this->parse_fields( $this->config )
			);
		} else {
			// Either a review set or platform was not defined, so display the launcher.
			$this->view = WPBR_PLUGIN_DIR . 'views/builder/builder-launcher.php';
		}
	}

	/**
	 * Prepares config based on provided platform.
	 *
	 * @param string|Config $config   Path to config or `Config` object.
	 * @param string        $platform The platform ID.
	 * @return Config The prepared Config object.
	 */
	protected function prepare_config( $config, $platform ) {
		$config = is_string( $config ) ? new Config( $config ): $config;
		$platform = str_replace( '_', '-', $platform );

		$config->prepend_config(
			new Config( WPBR_PLUGIN_DIR . "config/config-builder-{$platform}.php" )
		);

		return $config;
	}
}
