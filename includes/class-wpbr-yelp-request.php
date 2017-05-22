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
	 * @return array|WP_Error Business data or WP_Error on failure.
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
		$properties['page_url'] = "https://www.yelp.com/biz/{$this->business_id}";

		// Set image URL.
		$properties['image_url'] = $this->build_image_url( $r['image_url'] );

		// Set rating.
		if (
			isset( $r['rating'] )
			&& is_numeric( $r['rating'] )
		) {
			$properties['rating'] = $r['rating'];
		}

		// Set rating count.
		if (
			isset( $r['review_count'] )
			&& is_numeric( $r['review_count'] )
		) {
			$properties['rating_count'] = $r['review_count'];
		}

		// Set phone.
		if ( isset( $r['display_phone'] ) ) {
			$properties['phone'] = sanitize_text_field( $r['display_phone'] );
		}

		// Set street address.
		if ( isset( $r['location']['address1'] ) ) {
			$properties['street_address'] = sanitize_text_field( $r['location']['address1'] );
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
		if ( isset( $r['location']['zip_code'] ) ) {
			$properties['postal_code'] = sanitize_text_field( $r['location']['zip_code'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$properties['country'] = sanitize_text_field( $r['location']['country'] );
		}

		// Set latitude.
		if (
			isset( $r['coordinates']['latitude'] )
			&& is_float( $r['coordinates']['latitude'] )
		) {
			$properties['latitude'] = sanitize_text_field( $r['coordinates']['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['coordinates']['longitude'] )
			&& is_float( $r['coordinates']['longitude'] )
		) {
			$properties['longitude'] = sanitize_text_field( $r['coordinates']['longitude'] );
		}

		return $properties;
	}

	/**
	 * Build image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url URL of the original business image.
	 *
	 * @return string URL of the sized business image.
	 */
	protected function build_image_url( $image_url ) {
		if ( ! empty( $image_url ) ) {
			// Replace original size with more appropriate square size.
			$image_url_sized = str_replace( 'o.jpg', 'ls.jpg', $image_url );

			return $image_url_sized;
		} else {
			return null;
		}
	}
}
