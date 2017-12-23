<?php
/**
 * Defines the Plugin_Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Parser\Plugin_Settings_Field_Parser as Field_Parser;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\View;

/**
 * Retrieves and displays the plugin's settings.
 *
 * @since 0.1.0
 */
class Plugin_Settings extends Base_Settings {
	/**
	 * @inheritDoc
	 */
	protected $view = WPBR_PLUGIN_DIR . 'views/settings/settings-main.php';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_admin_page_wpbr_settings', array( $this, 'init' ) );
		add_action( 'wp_business_reviews_admin_page_wpbr_settings', array( $this, 'render' ) );
	}
}
