<?php
/**
 * Defines the Serializer_Abstract class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves values to the database.
 *
 * @since 0.1.0
 */
abstract class Serializer_Abstract {
	/**
	 * The prefix prepended to the saved key.
	 *
	 * @since 0.1.0
	 * @var string $prefix
	 */
	protected $prefix = 'wp_business_reviews_';

	/**
	 * User capability required in order to save.
	 *
	 * @since 0.1.0
	 * @var string $capability
	 */
	protected $capability = 'manage_options';

	/**
	 * Recursively sanitizes a given value.
	 *
	 * @param string|array $value The value to be sanitized.
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
	 * Sanitizes a multiline value while retaining line breaks.
	 *
	 * The regular expression accounts for double line breaks. The reassembled
	 * sanitized string only contains single line breaks.
	 *
	 * @param string|array $value The value to be sanitized.
	 * @return string|array Clean multiline string.
	 */
	protected function clean_multiline( $value ) {
		return implode( "\n", array_map( 'sanitize_text_field', preg_split( "/\n?\n/", $value ) ) );
	}

	/**
	 * Determines if a valid nonce has been provided.
	 *
	 * @since 0.1.0
	 *
	 * @param string|int $action Should give context to what is taking place and be the same when nonce was created.
	 * @param string     $name   Nonce name.
	 * @return false|int False if the nonce is invalid, 1 if the nonce is valid and generated between
	 *                   0-12 hours ago, 2 if the nonce is valid and generated between 12-24 hours ago.
	 */
	public function has_valid_nonce( $action, $name ) {
		if ( empty( $_POST[ $name ] ) ) {
			// Nonce field is not present or not populated, and therefore invalid.
			return false;
		}

		$nonce = sanitize_text_field( wp_unslash( $_POST[ $name ] ) );

		return wp_verify_nonce( $nonce, $action );
	}

	/**
	 * Verifies user has permission to save.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if user has permission, false if not.
	 */
	public function has_permission() {
		return current_user_can( $this->capability );
	}

	/**
	 * Redirects to the page from which the post was saved.
	 *
	 * @since 0.1.0
	 */
	public function redirect() {
		if ( empty( $_POST['_wp_http_referer'] ) ) {
			wp_safe_redirect( wp_login_url() );
			exit;
		}

		$redirect = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );

		wp_safe_redirect( $redirect );
		exit;
	}
}
