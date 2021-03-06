<?php
/**
 * Defines the Request abstract class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;
use WP_Error;

/**
 * Requests data from remote API.
 *
 * Each reviews platform API requires a unique request. While the specific
 * requests are unique, functionality to request business and reviews data from
 * the API must be provided.
 *
 * @since 0.1.0
 */
abstract class Request {
	/**
	 * Reviews platform used in the request.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business used in the request URL.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $business_id;

	/**
	 * API host used in the request URL.
	 *
	 * @since 0.1.0
	 * @var string
	 */
	protected $api_host;

	/**
	 * Instantiates the Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	abstract public function __construct( $business_id );

	/**
	 * Requests data from remote API.
	 *
	 * This method is a wrapper for wp_safe_remote_get(). It dynamically
	 * generates requests based on the path, URL parameters, and arguments
	 * provided to it.
	 *
	 * @since 0.1.0
	 *
	 * @param string $path       Optional. Path used in the request URL.
	 * @param array  $url_params Optional. URL parameters.
	 * @param array  $args       Optional. Arguments for wp_safe_remote_get().
	 *
	 * @return array|WP_Error API response or WP_Error on failure.
	 */
	protected function request( $path = '', $url_params = array(), $args = array() ) {
		// Ensure host is set to make a request.
		if ( empty( $this->api_host ) ) {
			return;
		}

		// Build the request URL (host + path).
		$url = $this->api_host . $path;

		// Add URL parameters.
		if ( ! empty( $url_params ) ) {
			$url = add_query_arg( $url_params, $url );
		}

		// Initiate request to the Google Places API.
		$response = wp_safe_remote_get( $url, $args );

		// Return early on error.
		if ( is_wp_error( $response ) ) {
			return $response;
		}

		// Check the response code.
		$response_code    = wp_remote_retrieve_response_code( $response );
		$response_message = wp_remote_retrieve_response_message( $response );

		if ( 200 != $response_code && ! empty( $response_message ) ) {
			return new WP_Error( $response_code, $response_message );
		} elseif ( 200 != $response_code ) {
			return new WP_Error( $response_code, __( 'An unknown error occurred.', 'wp-business-reviews' ) );
		}

		// Get just the response body.
		$response_body = wp_remote_retrieve_body( $response );

		return json_decode( $response_body, true );
	}

}
