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
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'yp';

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
	 * @return array|WP_Error Business data or WP_Error on failure.
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
		// Drill down to the relevant portion of the response.
		$r = $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0];

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
		if ( isset( $r['businessName'] ) ) {
			$properties['business_name'] = sanitize_text_field( $r['businessName'] );
		}

		// Set page URL.
		if ( isset( $r['moreInfoURL'] ) ) {
			$properties['page_url'] = sanitize_text_field( $r['moreInfoURL'] );
		}

		// Set rating.
		if (
			isset( $r['averageRating'] )
			&& is_numeric( $r['averageRating'] )
		) {
			$properties['rating'] = $r['averageRating'];
		}

		// Set rating count.
		if (
			isset( $r['ratingCount'] )
			&& is_numeric( $r['ratingCount'] )
		) {
			$properties['rating_count'] = $r['ratingCount'];
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$properties['phone'] = sanitize_text_field( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['street'] ) ) {
			$properties['street_address'] = sanitize_text_field( $r['street'] );
		}

		// Set city.
		if ( isset( $r['city'] ) ) {
			$properties['city'] = sanitize_text_field( $r['city'] );
		}

		// Set state.
		if ( isset( $r['state'] ) ) {
			$properties['state_province'] = sanitize_text_field( $r['state'] );
		}

		// Set postal code.
		if ( isset( $r['zip'] ) ) {
			$properties['postal_code'] = sanitize_text_field( $r['zip'] );
		}

		// Set latitude.
		if (
			isset( $r['latitude'] )
			&& is_float( $r['latitude'] )
		) {
			$properties['latitude'] = sanitize_text_field( $r['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['longitude'] )
			&& is_float( $r['longitude'] )
		) {
			$properties['longitude'] = sanitize_text_field( $r['longitude'] );
		}

		return $properties;
	}

}
