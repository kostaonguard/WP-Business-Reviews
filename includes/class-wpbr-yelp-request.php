<?php

/**
 * Defines the WPBR_Yelp_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Requests data from the Yelp Fusion API.
 *
 * @since 1.0.0
 * @see WPBR_Request
 */
class WPBR_Yelp_Request extends WPBR_Request {

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://api.yelp.com';

	/**
	 * URL path used for Yelp Business requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path;

	/**
	 * OAuth2 token required for Yelp Fusion API requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $access_token;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	public function __construct( $business_id ) {

		$this->business_id   = $business_id;
		$this->business_path = '/v3/businesses/' . $this->business_id;
		// TODO: Get Yelp access token from database instead of using constant.
		$this->access_token  = YELP_OAUTH_TOKEN;

	}

	/**
	 * Request business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	public function request_business() {

		// Define args to be passed with the request.
		$args = array(

			'user-agent' => '',
			'headers' => array(

				'authorization' => 'Bearer ' . $this->access_token,

			),

		);

		// Initiate request to the Yelp Fusion API.
		$response = wp_safe_remote_get( $this->api_host . $this->business_path, $args );

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
