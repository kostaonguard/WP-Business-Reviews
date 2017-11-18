<?php
/**
 * Defines the Settings_API class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;

/**
 * Handles the custom Settings API for the plugin.
 *
 * When settings are saved, the plugin stores its settings in a single option
 * named `wpbr_settings`. This option holds an associative array of all plugin
 * settings from which single settings can be retrieved.
 *
 * @since 0.1.0
 */
class Settings_API {
	/**
	 * Associative array of field IDs and saved values from the database.
	 *
	 * @since  0.1.0
	 * @var    array
	 * @access private
	 */
	private $settings;

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		if ( is_admin() ) {
			// Save active section's fields.
			add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'save_section' ) );
		}
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->settings = get_option( 'wpbr_settings', array() );
	}

	/**
	 * Gets all settings.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of field IDs and saved values.
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Gets the value of a single setting.
	 *
	 * @since 0.1.0
	 *
	 * @param  string $setting The array key associated with the setting.
	 * @return mixed The value of the setting or null if unavailable.
	 */
	public function get_setting( $setting ) {
		if ( ! empty( $this->settings ) && isset( $this->settings[ $setting ] ) ) {
			return $this->settings[ $setting ];
		}

		return null;
	}

	/**
	 * Gets default settings from framework.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of field IDs and default values.
	 */
	public function get_default_settings() {
		$default_settings = array();

		// Parse framework to retrieve default value of each field.
		foreach ( $this->framework as $tab ) {
			foreach ( $tab['sections'] as $section ) {
				foreach ( $section['fields'] as $field ) {
					if ( ! empty( $field['id'] ) ) {
						$field_id                      = $field['id'];
						$field_default                 = ! empty( $field['default'] ) ? $field['default'] : '';
						$default_settings[ $field_id ] = $field_default;
					}
				}
			}
		}

		return $default_settings;
	}

	/**
	 * Merges default settings with existing settings.
	 *
	 * This method is useful during plugin activation when settings do not yet
	 * exist in the database.
	 *
	 * @since 0.1.0
	 */
	private function merge_default_settings() {
		$default_settings = $this->get_default_settings();
		$this->settings = array_merge( $default_settings, $this->settings );
		$this->update_settings_option();
	}

	/**
	 * Saves settings section.
	 *
	 * When user saves changes on the settings page, fields from the active
	 * section are submitted. This validates the incoming nonce value, verifies
	 * user permissions, sanitizes the settings, and updates the option.
	 *
	 * @since 0.1.0
	 */
	public function save_section() {
		// If action is not set appropriately, return false.
		if ( empty( $_POST['action'] ) || 'wpbr_settings_save' !== sanitize_text_field( $_POST['action'] )  ) {
			return false;
		}

		// Validate nonce.
		if ( ! $this->has_valid_nonce() ) {
			$this->notices->add_notice( 'settings_nonce_error', 'error' );
			return false;
		}

		// Verify user has permission.
		if ( ! $this->has_permission() ) {
			$this->notices->add_notice( 'settings_permission_error', 'error' );
			return false;
		}

		// Get active tab and section.
		$active_tab     = $this->active_tab;
		$active_section = $this->active_section;

		// Get the settings posted by the user.
		$posted_settings = ! empty( $_POST['wpbr_settings'] ) ? wp_unslash( $_POST['wpbr_settings'] ) : array();

		/**
		 * Get the relevant fields being saved based on active tab and section.
		 * The framework is used to identify the type of field being saved in
		 * order to validate and sanitize it appropriately.
		 */
		$framework_fields = $this->framework[ $active_tab ]['sections'][ $active_section ]['fields'];

		// Loop through settings and save fields.
		foreach ( $framework_fields as $field => $atts ) {
			if ( ! empty( $posted_settings ) && isset( $posted_settings[ $field ] ) ) {
				$this->settings[ $field ] = $this->sanitize_field( $posted_settings[ $field ] );
			} else {
				$this->settings[ $field ] = '';
			}
		}

		// Update the settings option in the database.
		$this->update_settings_option();
	}

	/**
	 * Sanitize text recursively.
	 *
	 * Arrays are cleaned recursively. Other non-scalar values return empty
	 * string.
	 *
	 * @since 0.1.0
	 *
	 * @param string|array $var String or array.
	 * @return string|array Sanitized string or array.
	 */
	function sanitize_field( $var ) {
		if ( is_array( $var ) ) {
			return array_map( array( $this, 'sanitize_field' ), $var );
		}

		return is_scalar( $var ) ? sanitize_text_field( $var ) : '';
	}

	/**
	 * Updates the settings option in the database.
	 *
	 * @since 0.1.0
	 */
	private function update_settings_option() {
		$updated_option = update_option( 'wpbr_settings', $this->settings );
		$this->notices->add_notice( 'settings_update_success', 'success' );

		// TODO: Remove this error_log() before launch.
		error_log( print_r( get_option( 'wpbr_settings' ), true ) );
	}

	/**
	 * Determines if the nonce is valid.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean False if the field isn't set or the nonce value is
	 *                 invalid; otherwise true.
	 */
	private function has_valid_nonce() {
		// If the nonce field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['wpbr_settings_nonce'] ) ) { // Input var okay.
			return false;
		}

		$field  = sanitize_text_field( $_POST['wpbr_settings_nonce'] );
		$action = 'wpbr_settings_save';

		return wp_verify_nonce( $field, $action );
	}

	/**
	 * Determines if user has permissions to save settings.
	 *
	 * @since 0.1.0
	 */
	private function has_permission() {
		return current_user_can( 'manage_options' );
	}
}
