<?php

/**
 * Defines the WPBR_Request abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Requests data from remote API.
 *
 * Each reviews platform API requires a unique request. While the specific
 * requests are unique, functionality to request business and reviews data from
 * the API must be provided.
 *
 * @since 1.0.0
 */
abstract class WPBR_Request {

	/**
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business used in the request URL.
	 * 
	 * This is the ID of business on the reviews platform (not the post ID).
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host;

	/**
	 * URL path used for business requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path;

	/**
	 * URL path used for reviews requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviews_path;

	/**
	 * Requests data from remote API.
	 *
	 * This method dynamically creates requests based on the path and URL
	 * parameters provided to it. It is the foundation of all requests made to
	 * remote APIs.
	 *
	 * @since 1.0.0
	 *
	 * @param string $path       Path used in the request URL.
	 * @param array  $url_params URL parameters used in the request URL.
	 * @param array  $args       Arguments passed to wp_safe_remote_get().
	 *
	 * @return WP_Error|array API response data or WP_Error on failure.
	 */
	protected function request( $path, $url_params = array(), $args = array() ) {

		if ( empty( $this->api_host ) || empty( $path ) ) {

			return array();

		}

		// Build the request URL (host + path).
		$url = $this->api_host . $path;

		// Add URL parameters if defined.
		if ( ! empty( $url_params ) ) {

			$url = add_query_arg( $url_params, $url );

		}

		// Initiate request to the Google Places API.
		$response = wp_safe_remote_get( $url, $args );

		// Return WP_Error on failure.
		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Get just the response body.
		$body = wp_remote_retrieve_body( $response );

		// Convert to a more manageable array.
		$data = json_decode( $body, true );

		// Return relevant portion of business data.
		return $data;

	}

	/**
	 * Request business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	abstract public function request_business();

	/**
	 * Request reviews data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Reviews data or WP_Error on failure.
	 */
	abstract public function request_reviews();

}
