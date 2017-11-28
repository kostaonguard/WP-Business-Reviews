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
 * Saves settings to the database.
 *
 * @since 0.1.0
 */
class Serializer {
	/**
	* Registers functionality with WordPress hooks.
	*
	* @since 0.1.0
	*/
	public function register() {
		add_action( 'admin_post_wp_business_reviews_save_settings', array( $this, 'save' ) );
	}

	/**
	 * Saves settings to database.
	 *
	 * @since 0.1.0
	 */
	public function save() {
		error_log( print_r( $_POST, true ) );

		// Validate nonce and verify user has permission to save.
		if ( $this->has_valid_nonce() && $this->has_permission() ) {

			if ( ! empty( $_POST['wp_business_reviews_settings'] ) ) {
				foreach ( $_POST['wp_business_reviews_settings'] as $option => $new_value ) {
					// TODO: Sanitize value before saving.
					update_option( 'wp_business_reviews_' . $option, $new_value );
				}
			}

		} else {
			// TODO: Display an error message.
		}

		$this->redirect();
	}

	/**
	 * Determines if a valid nonce has been provided.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if valid, false if invalid.
	 */
	private function has_valid_nonce() {
		if ( ! empty( $_POST['wp_business_reviews_settings_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['wp_business_reviews_settings_nonce'] ) );
		} else {
			// Nonce field is not present or not populated, and therefore invalid.
			error_log('invalid nonce');
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
	private function has_permission() {
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		} else {
			error_log( 'user does not have permission' );
			return false;
		}
	}

	/**
	 * Redirects to the page from which settings were saved.
	 *
	 * If an active tab or subtab is provided, it will be included in the redirect URL.
	 *
	 * @since 0.1.0
	 */
	private function redirect() {
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
