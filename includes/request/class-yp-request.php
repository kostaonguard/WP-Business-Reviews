<?php

/**
 * Defines the YP_Request subclass
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;
use WP_Error;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/***
 * Requests data from the YP API.
 *
 * @since 0.1.0
 * @see   Request
 */
class YP_Request extends Request {

	/**
	 * Reviews platform used in the request.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'yp';

	/**
	 * API host used in the request URL.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'http://api2.yp.com';

	/**
	 * Path used in the business request URL.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $business_path = '/listings/v1/details';

	/**
	 * Path used in the reviews request URL.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $reviews_path = '/listings/v1/reviews';

	/**
	 * API key used in the request URL.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $api_key;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
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
	 * @since 0.1.0
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
	 * @since 0.1.0
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
	 * @since 0.1.0
	 * @see Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array|WP_Error Standardized business properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_business( array $response ) {
		if ( ! isset( $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		} else {
			$r = $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0];
		}

		// Set defaults.
		$business = array(
			'platform'      => $this->platform,
			'business_id'   => $this->business_id,
			'business_name' => null,
			'meta'          => array(
				'wpbr_page_url'       => null,
				'wpbr_rating'         => null,
				'wpbr_rating_count'   => null,
				'wpbr_phone'          => null,
				'wpbr_street_address' => null,
				'wpbr_city'           => null,
				'wpbr_state_province' => null,
				'wpbr_postal_code'    => null,
				'wpbr_latitude'       => null,
				'wpbr_longitude'      => null,
			),
		);

		// Set business name.
		if ( isset( $r['businessName'] ) ) {
			$business['business_name'] = sanitize_text_field( $r['businessName'] );
		}

		// Set page URL.
		if ( isset( $r['moreInfoURL'] ) ) {
			$business['meta']['wpbr_page_url'] = sanitize_text_field( $r['moreInfoURL'] );
		}

		// Set rating.
		if (
			isset( $r['averageRating'] )
			&& is_numeric( $r['averageRating'] )
		) {
			$business['meta']['wpbr_rating'] = $r['averageRating'];
		}

		// Set rating count.
		if (
			isset( $r['ratingCount'] )
			&& is_numeric( $r['ratingCount'] )
		) {
			$business['meta']['wpbr_rating_count'] = $r['ratingCount'];
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$business['meta']['wpbr_phone'] = sanitize_text_field( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['street'] ) ) {
			$business['meta']['wpbr_street_address'] = sanitize_text_field( $r['street'] );
		}

		// Set city.
		if ( isset( $r['city'] ) ) {
			$business['meta']['wpbr_city'] = sanitize_text_field( $r['city'] );
		}

		// Set state.
		if ( isset( $r['state'] ) ) {
			$business['meta']['wpbr_state_province'] = sanitize_text_field( $r['state'] );
		}

		// Set postal code.
		if ( isset( $r['zip'] ) ) {
			$business['meta']['wpbr_postal_code'] = sanitize_text_field( $r['zip'] );
		}

		// Set latitude.
		if (
			isset( $r['latitude'] )
			&& is_float( $r['latitude'] )
		) {
			$business['meta']['wpbr_latitude'] = sanitize_text_field( $r['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['longitude'] )
			&& is_float( $r['longitude'] )
		) {
			$business['meta']['wpbr_longitude'] = sanitize_text_field( $r['longitude'] );
		}

		return $business;
	}

	/**
	 * Standardizes reviews response for a set of reviews.
	 *
	 * @since 0.1.0
	 *
	 * @param array $response Reviews data from remote API.
	 *
	 * @return array|WP_Error Standardized review properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_reviews( array $response ) {
		if ( ! isset( $response['ratingsAndReviewsResult']['reviews']['review'] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		}

		// Initialize array to store standardized properties.
		$reviews = array();

		// Loop through reviews and standardize properties.
		foreach ( $response['ratingsAndReviewsResult']['reviews']['review'] as $r ) {
			// Set defaults.
			$review = array(
				'review_title'       => null,
				'review_text'        => null,
				'meta'               => array(
					'wpbr_review_url'         => null,
					'wpbr_reviewer_name'      => null,
					'wpbr_reviewer_image_url' => null,
					'wpbr_rating'             => null,
					'wpbr_time_created'       => null,
				),
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
				$review['meta']['wpbr_reviewer_name'] = sanitize_text_field( $r['reviewer'] );
			}

			// Set rating.
			if (
				isset( $r['rating'] )
				&& is_numeric( $r['rating'] )
			) {
				$review['meta']['wpbr_rating'] = $r['rating'];
			}

			// Set time created.
			if ( isset( $r['reviewDate'] ) ) {
				$review['meta']['wpbr_time_created'] = strtotime( $r['reviewDate'] );
			}

			$reviews[] = $review;
		}

		return $reviews;
	}
}
