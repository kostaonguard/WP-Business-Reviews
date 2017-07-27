<?php
/**
 * Defines the Admin_Page_Settings class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

use WP_Business_Reviews\Includes\Admin\Settings;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the Settings page for the plugin.
 *
 * @since 1.0.0
 * @see Admin_Page
 */
class Admin_Page_Settings extends Admin_Page {
	private $settings;

	public function __construct() {
		$this->settings = Settings\Settings::define_settings();
	}

	public function render() {
		$view = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/settings.php';
		include $view;
	}
}
