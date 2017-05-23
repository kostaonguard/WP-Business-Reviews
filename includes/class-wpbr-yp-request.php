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
	 * Path used in the business request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path = '/listings/v1/details';

	/**
	 * Path used in the reviews request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviews_path = '/listings/v1/reviews';

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
		// Define URL parameters of the request URL.
		$url_params = array(
			'key'       => $this->api_key,
			'format'    => 'json',
			'listingid' => $this->business_id,
		);

		// Request data from remote API.
		$response = $this->request( $this->reviews_path, $url_params );

		return $response;
	}

	/**
	 * Standardize business response.
	 *
	 * @since 1.0.0
	 * @see WPBR_Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array|WP_Error Standardized business properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_business( array $response ) {
		if ( ! isset( $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response structure is not suitable for standardization.', 'wpbr' ) );
		} else {
			$r = $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0];
		}

		// Set defaults.
		$business = array(
			'platform'      => $this->platform,
			'business_id'   => $this->business_id,
			'business_name' => null,
			'meta'          => array(
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
			),
		);

		// Set business name.
		if ( isset( $r['businessName'] ) ) {
			$business['business_name'] = sanitize_text_field( $r['businessName'] );
		}

		// Set page URL.
		if ( isset( $r['moreInfoURL'] ) ) {
			$business['meta']['page_url'] = sanitize_text_field( $r['moreInfoURL'] );
		}

		// Set rating.
		if (
			isset( $r['averageRating'] )
			&& is_numeric( $r['averageRating'] )
		) {
			$business['meta']['rating'] = $r['averageRating'];
		}

		// Set rating count.
		if (
			isset( $r['ratingCount'] )
			&& is_numeric( $r['ratingCount'] )
		) {
			$business['meta']['rating_count'] = $r['ratingCount'];
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$business['meta']['phone'] = sanitize_text_field( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['street'] ) ) {
			$business['meta']['street_address'] = sanitize_text_field( $r['street'] );
		}

		// Set city.
		if ( isset( $r['city'] ) ) {
			$business['meta']['city'] = sanitize_text_field( $r['city'] );
		}

		// Set state.
		if ( isset( $r['state'] ) ) {
			$business['meta']['state_province'] = sanitize_text_field( $r['state'] );
		}

		// Set postal code.
		if ( isset( $r['zip'] ) ) {
			$business['meta']['postal_code'] = sanitize_text_field( $r['zip'] );
		}

		// Set latitude.
		if (
			isset( $r['latitude'] )
			&& is_float( $r['latitude'] )
		) {
			$business['meta']['latitude'] = sanitize_text_field( $r['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['longitude'] )
			&& is_float( $r['longitude'] )
		) {
			$business['meta']['longitude'] = sanitize_text_field( $r['longitude'] );
		}

		return $business;
	}

	/**
	 * Standardizes reviews response for a set of reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $response Reviews data from remote API.
	 *
	 * @return array Standardized set of reviews data.
	 */
	public function standardize_reviews( array $response ) {
		// Initialize array to store standardized properties.
		$reviews = array();

		// Loop through reviews and standardize properties.
		foreach ( $response['ratingsAndReviewsResult']['reviews']['review'] as $r ) {
			// Set defaults.
			$review = array(
				'platform'           => $this->platform,
				'business_id'        => $this->business_id,
				'review_title'       => null,
				'review_text'        => null,
				'review_url'         => null,
				'reviewer_name'      => null,
				'reviewer_image_url' => null,
				'rating'             => null,
				'time_created'       => null,
			);

			// Set review title.
			if ( isset( $r['reviewSubject'] ) ) {
				$review['review_title'] = sanitize_text_field( $r['reviewSubject'] );
			}

			// Set review text.
			if ( isset( $r['reviewBody'] ) ) {
				$review['review_text'] = sanitize_text_field( $r['reviewBody'] );
			}

			// Set reviewer name.
			if ( isset( $r['reviewer'] ) ) {
				$review['reviewer_name'] = sanitize_text_field( $r['reviewer'] );
			}

			// Set rating.
			if (
				isset( $r['rating'] )
				&& is_numeric( $r['rating'] )
			) {
				$review['rating'] = $r['rating'];
			}

			// Set time created.
			if ( isset( $r['reviewDate'] ) ) {
				$review['time_created'] = strtotime( $r['reviewDate'] );
			}

			$reviews[] = $review;
		}

		return $reviews;
	}
}
