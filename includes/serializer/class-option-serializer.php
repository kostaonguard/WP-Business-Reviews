<?php
/**
 * Defines the Option_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves options to the database.
 *
 * @since 0.1.0
 */
class Option_Serializer extends Serializer_Abstract {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_post_wp_business_reviews_save_settings', array( $this, 'save_from_post_array' ) );
	}

	/**
	 * Saves a single sanitized key-value pair.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key   The key being saved.
	 * @param mixed  $value The value being saved.
	 * @return boolean True if value saved successfully, false otherwise.
	 */
	public function save( $key, $value ) {
		return update_option( $this->prefix . $key, $this->clean( $value ) );
	}

	/**
	 * Saves an array of key-value pairs.
	 *
	 * @since 0.1.0
	 *
	 * @param array $values Key-value pairs to be saved.
	 */
	public function save_multiple( array $values ) {
		foreach ( $values as $key => $value ) {
			$this->save( $key, $value );
		}
	}

	/**
	 * Saves settings section to database.
	 *
	 * @since 0.1.0
	 */
	public function save_from_post_array() {
		if ( empty( $_POST['wp_business_reviews'] ) ) {
			$this->redirect();
		}

		if (
			! $this->has_valid_nonce(
				'wp_business_reviews_save_settings',
				'wp_business_reviews_settings_nonce'
			)
			|| ! $this->has_permission()
		) {
			$this->redirect();
		}

		$settings = $_POST['wp_business_reviews'];
		$section = sanitize_text_field( $_POST['wp_business_reviews_subtab'] );

		$this->save_multiple( $settings );

		/**
		 * Fires after all posted settings have been saved.
		 *
		 * @since 0.1.0
		 *
		 * @param string $section Name of the updated setting.
		 */
		do_action( 'wp_business_reviews_saved_settings', $section );

		$this->redirect();
	}

	/**
	 * Redirects to the page from which settings were saved.
	 *
	 * If an active tab or subtab is provided, it will be included in the redirect URL.
	 *
	 * @since 0.1.0
	 */
	public function redirect() {
		if ( empty( $_POST['_wp_http_referer'] ) ) {
			wp_safe_redirect( wp_login_url() );
			exit;
		}

		$referer = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );

		if (
			empty( $_POST['wp_business_reviews_tab'] )
			|| empty( $_POST['wp_business_reviews_subtab'] )
		) {
			wp_safe_redirect( $referer );
			exit;
		}

		$active_tab = sanitize_text_field(
			wp_unslash( $_POST['wp_business_reviews_tab'] )
		);
		$active_subtab = sanitize_text_field(
			wp_unslash( $_POST['wp_business_reviews_subtab'] )
		);

		// Parse referer into path and query string.
		$parsed_url = parse_url( $referer );

		// Parse query string into array of query parts.
		parse_str( $parsed_url['query'], $query_args );

		// Update active tab and subtab.
		$query_args['wpbr_tab']    = $active_tab;
		$query_args['wpbr_subtab'] = $active_subtab;

		// Stringify the query parts.
		$query_string = http_build_query( $query_args );

		// Assemble the redirect location.
		$redirect = $parsed_url['path'] . '?' . $query_string;

		wp_safe_redirect( $redirect );
		exit;
	}
}
