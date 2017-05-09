<?php
/**
 * Defines the WPBR_Facebook_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Requests data from the Facebook Open Graph API.
 *
 * @since 1.0.0
 * @see WPBR_Request
 */
class WPBR_Facebook_Request extends WPBR_Request {
	
	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://graph.facebook.com';

	/**
	 * URL path used for Facebook page requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $page_path;

	/**
	 * Page Access Token required for Open Graph Page requests.
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

		$this->business_id       = $business_id;
		$this->page_path         = '/v2.9/' . $this->business_id;
		// TODO: Get Page Access Token from database instead of using constant.
		$this->access_token      = FACEBOOK_PAGE_ACCESS_TOKEN;

	}

	/**
	 * Request business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	public function request_business() {

		// Define fields to be included in response.
		$fields = array(

			'name',
			'link',
			'overall_star_rating',
			'rating_count',
			'phone',
			'location',

		);

		// Concatenate fields as required by Open Graph API.
		$fields = implode( ',', $fields );

		// Define URL parameters of the request URL.
		$url_params = array(

			'fields'        => $fields,
			'access_token' => $this->access_token,

		);

		// Build the request URL (host + path + parameters).
		$url = add_query_arg( $url_params, $this->api_host . $this->page_path );

		// Initiate request to the Open Graph API.
		$response = wp_remote_get( $url );

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
