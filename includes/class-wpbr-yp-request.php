<?php

/**
 * Defines the WPBR_YP_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Requests data from the YP API.
 *
 * @since 1.0.0
 * @see WPBR_Request
 */
class WPBR_YP_Request extends WPBR_Request {

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'http://api2.yp.com';

	/**
	 * URL path used for YP Listing requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $listings_path = '/listings/v1/details';

	/**
	 * API key used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_key;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
		// TODO: Get API key from database instead of using constant.
		$this->api_key     = YP_API_KEY;

	}

	/**
	 * Request business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	public function request_business() {

		// Define URL parameters of the request URL.
		$url_params = array(

			'key'       => $this->api_key,
			'format'    => 'json',
			'listingid' => $this->business_id,

		);

		// Build the request URL (host + path + parameters).
		$url = add_query_arg( $url_params, $this->api_host . $this->listings_path );

		// Initiate request to the YP API.
		$response = wp_safe_remote_get( $url );

		// Return WP_Error on failure.
		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Get just the response body.
		$body = wp_remote_retrieve_body( $response );

		// Convert to a more manageable array.
		$data = json_decode( $body, true );

		// Return relevant portion of business data.
		return $data['listingsDetailsResult']['listingsDetails']['listingDetail'][0];

	}

	/**
	 * Request reviews data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Reviews data or WP_Error on failure.
	 */
	public function request_reviews() {

		// TODO: Define how reviews are requested.

	}

}
