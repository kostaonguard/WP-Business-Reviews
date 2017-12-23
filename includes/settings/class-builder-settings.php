<?php
/**
 * Defines the Builder_Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

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
}
