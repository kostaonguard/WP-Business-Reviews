<?php
/**
 * Defines the Request_Base class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from a URL.
 *
 * @since 0.1.0
 */
class Request_Base {
	/**
	 * Retrieves a response from a safe HTTP request using the GET method.
	 *
	 * @since 0.1.0
	 *
	 * @see wp_safe_remote_get()
	 *
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
}
