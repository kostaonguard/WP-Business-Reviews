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
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'yelp';

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://api.yelp.com';

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
	 * Requests business data from remote API.
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

		// Request data from remote API.
		$response = $this->request( $this->business_path, array(), $args );

		if ( is_wp_error( $response ) ) {

			return $response;

		}

		// Return only the relevant portion of the response.
		return $response;

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
