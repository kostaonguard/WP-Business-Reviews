<?php
/**
 * Defines the Request class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves and sanitizes data from a URL.
 *
 * @since 0.1.0
 */
class Request {
	/**
	 * Platform ID.
	 *
	 * @since 0.1.0
	 * @var string $platform
	 */
	protected $platform;

	/**
	 * Retrieves a response from a safe HTTP request using the GET method.
	 *
	 * @since 0.1.0
	 *
	 * @see wp_safe_remote_get()
	 *
	 * @param string $url Site URL to retrieve.
	 * @return array Associative array containing the response body.
	 */
	public function get( $url, $args = array() ) {
		$response = wp_safe_remote_get( $url, $args );

		return $this->process_response( $response );
	}

	/**
	 * Retrieves a response from a safe HTTP request using the POST method.
	 *
	 * @since 0.1.0
	 *
	 * @see wp_safe_remote_post()
	 *
	 * @param string $url Site URL to retrieve.
	 * @return array Associative array containing the response body.
	 */
	public function post( $url, $args = array() ) {
		$response = wp_safe_remote_post( $url, $args );

		return $this->process_response( $response );
	}

	/**
	 * Validates and decodes the response body.
	 *
	 * @param mixed $response The raw response.
	 * @return mixed Associative array of the response body.
	 */
	private function process_response( $response ) {
		if ( is_wp_error( $response ) ) {
			// TODO: Return WP_Error here for failed responses.
			return false;
		}

		$body = wp_remote_retrieve_body( $response );

		// TODO: Possibly filter the response body.
		return json_decode( $body, true );
	}

	/**
	 * Retrieves default values for a normalized review source.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of default values.
	 */
	protected function get_review_source_defaults() {
		return array (
			'platform'          => $this->platform,
			'review_source_id'  => null,
			'name'              => null,
			'url'               => null,
			'rating'            => null,
			'icon'              => null,
			'image'             => null,
			'phone'             => null,
			'formatted_address' => null,
			'street_address'    => null,
			'city'              => null,
			'state_province'    => null,
			'postal_code'       => null,
			'country'           => null,
			'latitude'          => null,
			'longitude'         => null,
		);
	}

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
}
