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
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'facebook';

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://graph.facebook.com';

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
		$this->business_path     = '/v2.9/' . $this->business_id;
		// TODO: Get Page Access Token from database instead of using constant.
		$this->access_token      = FACEBOOK_PAGE_ACCESS_TOKEN;

	}

	/**
	 * Requests business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	public function request_business() {

		// Define fields to be included in response.
		$fields = array(

			'id',
			'name',
			'link',
			'overall_star_rating',
			'rating_count',
			'phone',
			'location',

		);

		// Concatenate fields as required by Open Graph API.
		$fields = implode( ',', $fields );

		// Set up URL parameters.
		$url_params = array(

			'fields' => $fields,
			// TODO: Replace FACEBOOK_PAGE_ACCESS_TOKEN constant.
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN,

		);

		// Request data from remote API.
		$response = $this->request( $this->business_path, $url_params );

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

		// Define fields to be included in response.
		$fields = array(

			'rating',
			'reviewer',
			'review_text',
			'open_graph_story',
			'created_time',

		);

		// Concatenate fields as required by Open Graph API.
		$fields = implode( ',', $fields );

		// Set up URL parameters.
		$url_params = array(

			'limit'  => 24,
			'fields' => $fields,
			// TODO: Replace FACEBOOK_PAGE_ACCESS_TOKEN constant.
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN,

		);

		// Request data from remote API.
		$response = $this->request( $this->ratings_path, $url_params );

		// Return only the relevant portion of the response.
		return $response;

	}

}
