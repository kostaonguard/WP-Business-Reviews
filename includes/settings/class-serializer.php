<?php
/**
 * Defines the Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

/**
 * Saves information to the database.
 *
 * @since 0.1.0
 */
class Serializer {
	/**
	 * Array of keys that are allowed to be saved.
	 *
	 * @since 0.1.0
	 * @var array $allowed_keys
	 */
	protected $allowed_keys;

	/**
	 * Instantiates the Serializer object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $allowed_keys Keys that are allowed to be saved.
	 */
	public function __construct( array $allowed_keys = array() ) {
		$this->allowed_keys = $allowed_keys;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_post_wp_business_reviews_save_settings', array( $this, 'save_all' ) );
	}

	/**
	 * Saves all valid settings to database.
	 *
	 * @since 0.1.0
	 */
	public function save_all() {
		// Make sure settings exist
		if ( ! empty( $_POST['wp_business_reviews_settings'] ) ) {
			$settings = $_POST['wp_business_reviews_settings'];
		} else {
			return;
		}

		// Validate nonce and verify user has permission to save.
		if ( $this->has_valid_nonce() && $this->has_permission() ) {
			foreach ( $settings as $key => $value ) {
				$this->save( $key, $value);
			}
		} else {
			// TODO: Display an error message regarding permission.
		}

		$this->redirect();
	}

	/**
	 * Saves a single sanitized setting to the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key   Key of the setting being saved.
	 * @param mixed  $value Value of the setting being saved.
	 * @return boolean True if option saved, false if update failed or
	 *                 key is not allowed.
	 */
	public function save( $key, $value ) {
		if ( $this->is_allowed_key( $key ) ) {
			$clean_value = $this->clean( $value );

			if ( update_option( 'wp_business_reviews_' . $key, $clean_value  ) ) {
				/**
				 * Triggers dynamic action using the key that was just saved.
				 *
				 * @since 0.1.0
				 *
				 * @param string $key        Key of the setting being saved.
				 * @param mixed $clean_value Sanitized value of the setting
				 *                           being saved.
				 */
				do_action( 'wp_business_reviews_save_' . $key, $clean_value );

				return true;
			}
		}

		// Key either is not allowed or failed to save.
		return false;
	}

	/**
	 * Recursively sanitizes a given value.
	 *
	 * @param string|array $value Value to be sanitized.
	 * @return string|array Array of clean values or single clean value.
	 */
	protected function clean( $value ) {
		if ( is_array( $value ) ) {
			return array_map( array( $this, 'clean' ), $value );
		} else {
			return is_scalar( $value ) ? sanitize_text_field( $value ) : '';
		}
	}

	/**
	 * Determines if a valid nonce has been provided.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if valid, false if invalid.
	 */
	protected function has_valid_nonce() {
		if ( ! empty( $_POST['wp_business_reviews_settings_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['wp_business_reviews_settings_nonce'] ) );
		} else {
			// Nonce field is not present or not populated, and therefore invalid.
			error_log( 'invalid nonce' );
			return false;
		}

		return wp_verify_nonce( $nonce, 'wp_business_reviews_save_settings' );
	}

	/**
	 * Verifies user has permission to save settings.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if user has permission, false if not.
	 */
	protected function has_permission() {
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		} else {
			error_log( 'user does not have permission' );
			return false;
		}
	}

	/**
	 * Determines if key is allowed to be saved.
	 *
	 * If `allowed_keys` property is empty, then any key is allowed.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Unique identifier of the value to be saved.
	 */
	protected function is_allowed_key( $key ) {
		if ( ! empty( $this->allowed_keys ) ) {
			return in_array( $key, $this->allowed_keys );
		} else {
			return true;
		}
	}

	/**
	 * Redirects to the page from which settings were saved.
	 *
	 * If an active tab or subtab is provided, it will be included in the redirect URL.
	 *
	 * @since 0.1.0
	 */
	protected function redirect() {
		$active_tab = $active_subtab = $referer = '';

		if ( ! empty( $_POST['wp_business_reviews_tab'] ) ) {
			$active_tab = sanitize_text_field( wp_unslash( $_POST['wp_business_reviews_tab'] ) );
		}

		if ( ! empty( $_POST['wp_business_reviews_subtab'] ) ) {
			$active_subtab = sanitize_text_field( wp_unslash( $_POST['wp_business_reviews_subtab'] ) );
		}

		if ( ! empty( $_POST['_wp_http_referer'] ) ) {
			$referer = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );
		} else {
			$referer = wp_login_url();
		}

		// Parse referer into path and query string.
		$parsed_url = parse_url( $referer );

		// Parse query string into array of query parts.
		parse_str( $parsed_url['query'], $query_parts );

		// Update active tab and subtab.
		$query_parts['wpbr_tab'] = $active_tab;
		$query_parts['wpbr_subtab'] = $active_subtab;

		// Stringify the query parts.
		$query_string = http_build_query( $query_parts );

		// Assemble the redirect location.
		$redirect = $parsed_url['path'] . '?' . $query_string;

		wp_safe_redirect( $redirect );
		exit;
	}
}
