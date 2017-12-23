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
		if( isset( $_GET['wpbr-review-set'], $_GET['wpbr-platform'] ) ) {
			$this->review_set = sanitize_text_field( $_GET['wpbr-review-set'] );
			$this->platform   = sanitize_text_field( $_GET['wpbr-platform'] );
			$this->set_config( $this->platform );
			$this->parse_fields();
		} else {
			// Either a review set or platform was not defined, so display the launcher.
			$this->view = WPBR_PLUGIN_DIR . 'views/builder/builder-launcher.php';
		}
	}

	/**
	 * @inheritDoc
	 */
	public function parse_fields() {
		$field_objects          = $this->field_parser->parse_fields( $this->config );
		$this->field_repository = new Field_Repository( $field_objects );
	}

	/**
	 * Sets the config based on platform slug.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 */
	protected function set_config( $platform ) {
		$this->config = new Config( WPBR_PLUGIN_DIR . 'configs/config-admin-pages.php' );
	}
}
