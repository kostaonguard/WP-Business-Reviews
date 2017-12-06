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
	 * This method is a wrapper for `wp_safe_remote_get()` which means the URL
	 * is validated to avoid redirection and request forgery attacks.
	 *
	 * @since 0.1.0
	 *
	 * @see wp_safe_remote_get()
	 *
	 * @return array Associative array containing the response body.
	 */
	public function get( $url, $args = array() ) {
		$response = wp_safe_remote_get( $url, $args );

		if ( is_wp_error( $response ) ) {
			// TODO: Return WP_Error here for failed responses.
			return false;
		}

		$body = wp_remote_retrieve_body( $response );

		// TODO: Possibly filter the response body.
		return json_decode( $body, true );
	}
}
