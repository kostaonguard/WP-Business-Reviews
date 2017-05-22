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
		$this->business_id   = $business_id;
		$this->business_path = '/v2.9/' . $this->business_id;
		// TODO: Get Page Access Token from database instead of using constant.
		$this->access_token = FACEBOOK_PAGE_ACCESS_TOKEN;
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

			'fields'       => $fields,
			// TODO: Replace FACEBOOK_PAGE_ACCESS_TOKEN constant.
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN,

		);

		// Request data from remote API.
		$response = $this->request( $this->business_path, $url_params );

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

			'limit'        => 24,
			'fields'       => $fields,
			// TODO: Replace FACEBOOK_PAGE_ACCESS_TOKEN constant.
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN,

		);

		// Request data from remote API.
		$response = $this->request( $this->ratings_path, $url_params );

		// Return only the relevant portion of the response.
		return $response;

	}

	/**
	 * Standardize business properties.
	 *
	 * @since 1.0.0
	 * @see WPBR_Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array Standardized business properties.
	 */
	public function standardize_business_properties( $response ) {
		$r = $response;

		// Set defaults.
		$properties = array(
			'platform'       => $this->platform,
			'business_id'    => $this->business_id,
			'business_name'  => null,
			'page_url'       => null,
			'image_url'      => null,
			'rating'         => null,
			'rating_count'   => null,
			'phone'          => null,
			'street_address' => null,
			'city'           => null,
			'state_province' => null,
			'postal_code'    => null,
			'country'        => null,
			'latitude'       => null,
			'longitude'      => null,
		);

		// Set business name.
		if ( isset( $r['name'] ) ) {
			$properties['business_name'] = sanitize_text_field( $r['name'] );
		}

		// Set page URL.
		if (
			isset( $r['link'] )
			&& filter_var( $r['link'], FILTER_VALIDATE_URL )
		) {
			$properties['page_url'] = $r['link'];
		}

		// Set image URL.
		$properties['image_url'] = "https://graph.facebook.com/v2.9/{$this->business_id}/picture/?height=192";

		// Set rating.
		if (
			isset( $r['overall_star_rating'] )
			&& is_numeric( $r['overall_star_rating'] )
		) {
			$properties['rating'] = $r['overall_star_rating'];
		}

		// Set rating count.
		if (
			isset( $r['rating_count'] )
			&& is_numeric( $r['rating_count'] )
		) {
			$properties['rating_count'] = $r['rating_count'];
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$properties['phone'] = sanitize_text_field( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['location']['street'] ) ) {
			$properties['street_address'] = sanitize_text_field( $r['location']['street'] );
		}

		// Set city.
		if ( isset( $r['location']['city'] ) ) {
			$properties['city'] = sanitize_text_field( $r['location']['city'] );
		}

		// Set state.
		if ( isset( $r['location']['state'] ) ) {
			$properties['state_province'] = sanitize_text_field( $r['location']['state'] );
		}

		// Set postal code.
		if ( isset( $r['location']['zip'] ) ) {
			$properties['postal_code'] = sanitize_text_field( $r['location']['zip'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$properties['country'] = sanitize_text_field( $r['location']['country'] );
		}

		// Set latitude.
		if (
			isset( $r['location']['latitude'] )
			&& is_float( $r['location']['latitude'] )
		) {
			$properties['latitude'] = sanitize_text_field( $r['location']['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['location']['longitude'] )
			&& is_float( $r['location']['longitude'] )
		) {
			$properties['longitude'] = sanitize_text_field( $r['location']['longitude'] );
		}

		return $properties;
	}
}
