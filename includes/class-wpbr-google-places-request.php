<?php

/**
 * Defines the WPBR_Google_Places_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Requests data from the Google Places API.
 *
 * @since 1.0.0
 * @see WPBR_Request
 */
class WPBR_Google_Places_Request extends WPBR_Request {

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://maps.googleapis.com';

	/**
	 * URL path used for Google Place requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $place_path = '/maps/api/place/details/json';

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
		$this->api_key     = GOOGLE_PLACES_API_KEY;

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

			'placeid' => $this->business_id,
			'key'     => $this->api_key,

		);

		// Request data from remote API.
		$response = $this->request( $this->place_path, $url_params );

		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Return only the relevant portion of the response.
		return $response['result'];

	}

	/**
	 * Requests reviews data from remote API.
	 *
	 * Since Google Places API returns business and reviews data together, the
	 * business request logic can be reused to access reviews.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Reviews data or WP_Error on failure.
	 */
	public function request_reviews() {

		// Use the business request as a starting point.
		$response = $this->request_business();

		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Return only the relevant portion of the response.
		return $response['reviews'];

	}

}
