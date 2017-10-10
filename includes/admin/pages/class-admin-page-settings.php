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
		$defaults = array(
			// TODO: Set field defaults.
		);

		// Get value of the field setting from database.
		$saved_value = $this->settings_api->get_setting( $field['id'] );

		$view         = '';
		$view_dir_url = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/fields/';
		$class        = 'wpbr-field--setting';

		switch ( $field['type'] ) {
			case 'text':
				$view = 'text';
				break;
			case 'platform_status':
				$view = 'platform-status';
				break;
			case 'radio':
			case 'checkbox':
				$view = 'radio-checkbox';
				break;
			case 'facebook_pages':
				$view = 'facebook-pages';
				break;
			case 'pro_features_gallery':
				$view = 'pro-features-gallery';
				break;
		}

		include $view_dir_url . 'field-' . $view . '.php';
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
		$config = $this->settings_api->get_config();
		$view     = WPBR_PLUGIN_DIR . 'includes/admin/pages/views/settings.php';
		include $view;
	}
}
