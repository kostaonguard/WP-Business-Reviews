<?php
/**
 * Defines the Admin_Page_Settings class
 *
 * @package WP_Business_Reviews\Includes\Admin\Pages
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Pages;

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
	private function render_field( $field ) {
		// Set field defaults.

		$defaults = array(

		);

		// Get value of the field setting from database.
		$saved_value = $this->settings_api->get_setting( $field['id'] );

		// Set directory from which field views will be rendered.
		$view_dir_url  = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/fields/';

		switch ( $field['type'] ) {
			case 'password':
				include $view_dir_url . 'field-password.php';
				break;
			case 'platform_status':
				include $view_dir_url . 'field-platform-status.php';
				break;
			case 'radio':
			case 'checkbox':
				include $view_dir_url . 'field-radio-checkbox.php';
				break;
			case 'facebook_pages':
				include $view_dir_url . 'field-facebook-pages.php';
				break;
		}
	}

	private function render_field_description( $description ) {
		$allowed_html = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
			),
			'em'     => array(),
			'strong' => array(),
			'code'   => array(),
		);

		echo wp_kses( $description, $allowed_html );
	}

	public function render_page() {
		$settings = $this->settings_api->define_framework();
		$view     = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/settings.php';
		include $view;
	}
}
