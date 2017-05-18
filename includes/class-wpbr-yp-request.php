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
	 * URL path used for business requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path = '/listings/v1/details';

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
	 * Requests business data from remote API.
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

		// Request data from remote API.
		$response = $this->request( $this->business_path, $url_params );

		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Return only the relevant portion of the response.
		return $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0];

	}

	/**
	 * Requests reviews data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Reviews data or WP_Error on failure.
	 */
	public function request_reviews() {

		// TODO: Define how reviews are requested.

	}

}
