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
	 * Instantiates a Request_Base object.
	 *
	 * @since 0.1.0
	 *
	 * @see WP_HTTP::request()
	 */
	public function __construct( $url, $args = array() ) {
		$this->url = $url;
		$this->args = $args;
	}

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
	public function get() {
		$response = wp_safe_remote_get( $this->url, $this->args );

		if ( is_wp_error( $response ) ) {
			// TODO: Return WP_Error here for failed responses.
			return false;
		}

		$body = wp_remote_retrieve_body( $response );

		// TODO: Possibly filter the response body.
		return json_decode( $body, true );
	}
}
