<?php
/**
 * Defines the Admin_Page_Settings class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

use WP_Business_Reviews\Includes\Admin\Settings\WPBR_Settings_API;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the Settings page for the plugin.
 *
 * @since 1.0.0
 * @see   Admin_Page
 */
class Admin_Page_Settings extends Admin_Page {
	private $settings_api;
	private $tabs;
	private $sections;

	public function __construct( WPBR_Settings_API $settings_api ) {
		$this->settings_api = $settings_api;
	}

	public function render_page() {
		$settings_api = $this->settings_api;
		$settings     = $settings_api::define_settings();
		$view         = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/settings.php';
		include $view;
	}
}
