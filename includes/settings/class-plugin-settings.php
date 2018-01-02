<?php
/**
 * Defines the Plugin_Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Field\Field_Repository;

/**
 * Retrieves and displays the plugin's settings.
 *
 * @since 0.1.0
 */
class Plugin_Settings extends Settings_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $view = WPBR_PLUGIN_DIR . 'views/plugin-settings/plugin-settings.php';

	/**
	 * @inheritDoc
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
		$this->field_repository = new Field_Repository(
			$this->parse_fields( $this->config )
		);
	}
}
