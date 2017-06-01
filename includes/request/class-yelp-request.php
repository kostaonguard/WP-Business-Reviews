<?php

/**
 * Defines the Yelp_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WP_Business_Reviews
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

namespace WP_Business_Reviews\Includes\Request;
use WP_Error;

/***
 * Requests data from the Yelp Fusion API.
 *
 * @since 1.0.0
 * @see Request
 */
class Yelp_Request extends Request {

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
	 * Path used in the business request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path;

	/**
	 * Path used in the reviews request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviews_path;

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
		$this->business_path = "/v3/businesses/$this->business_id";
		$this->reviews_path = "/v3/businesses/{$this->business_id}/reviews";
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
		// Define args to be passed with the request.
		$args = array(
			'user-agent' => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->access_token,
			),
		);

		// Request data from remote API.
		$response = $this->request( $this->reviews_path, array(), $args );

		return $response;
	}

	/**
	 * Standardize business response.
	 *
	 * @since 1.0.0
	 * @see Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array|WP_Error Standardized business properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_business( array $response ) {
		if ( empty( $response ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		} else {
			$r = $response;
		}

		// Set defaults.
		$business = array(
			'platform'      => $this->platform,
			'business_id'   => $this->business_id,
			'business_name' => null,
			'meta'          => array(
				'wpbr_page_url'       => null,
				'wpbr_image_url'      => null,
				'wpbr_rating'         => null,
				'wpbr_rating_count'   => null,
				'wpbr_phone'          => null,
				'wpbr_street_address' => null,
				'wpbr_city'           => null,
				'wpbr_state_province' => null,
				'wpbr_postal_code'    => null,
				'wpbr_country'        => null,
				'wpbr_latitude'       => null,
				'wpbr_longitude'      => null,
			),
		);

		// Set business name.
		if ( isset( $r['name'] ) ) {
			$business['business_name'] = sanitize_text_field( $r['name'] );
		}

		// Set page URL.
		$business['meta']['wpbr_page_url'] = "https://www.yelp.com/biz/{$this->business_id}";

		// Set image URL.
		if (
			isset( $r['image_url'] )
			&& filter_var( $r['image_url'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['wpbr_image_url'] = $this->build_image_url( $r['image_url'] );
		}

		// Set rating.
		if (
			isset( $r['rating'] )
			&& is_numeric( $r['rating'] )
		) {
			$business['meta']['wpbr_rating'] = $r['rating'];
		}

		// Set rating count.
		if (
			isset( $r['review_count'] )
			&& is_numeric( $r['review_count'] )
		) {
			$business['meta']['wpbr_rating_count'] = $r['review_count'];
		}

		// Set phone.
		if ( isset( $r['display_phone'] ) ) {
			$business['meta']['wpbr_phone'] = sanitize_text_field( $r['display_phone'] );
		}

		// Set street address.
		if ( isset( $r['location']['address1'] ) ) {
			$business['meta']['wpbr_street_address'] = sanitize_text_field( $r['location']['address1'] );
		}

		// Set city.
		if ( isset( $r['location']['city'] ) ) {
			$business['meta']['wpbr_city'] = sanitize_text_field( $r['location']['city'] );
		}

		// Set state.
		if ( isset( $r['location']['state'] ) ) {
			$business['meta']['wpbr_state_province'] = sanitize_text_field( $r['location']['state'] );
		}

		// Set postal code.
		if ( isset( $r['location']['zip_code'] ) ) {
			$business['meta']['wpbr_postal_code'] = sanitize_text_field( $r['location']['zip_code'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$business['meta']['wpbr_country'] = sanitize_text_field( $r['location']['country'] );
		}

		// Set latitude.
		if (
			isset( $r['coordinates']['latitude'] )
			&& is_float( $r['coordinates']['latitude'] )
		) {
			$business['meta']['wpbr_latitude'] = sanitize_text_field( $r['coordinates']['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['coordinates']['longitude'] )
			&& is_float( $r['coordinates']['longitude'] )
		) {
			$business['meta']['wpbr_longitude'] = sanitize_text_field( $r['coordinates']['longitude'] );
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
	 * @return array|WP_Error Standardized review properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_reviews( array $response ) {
		if ( ! isset( $response['reviews'] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		}

		// Initialize array to store standardized properties.
		$reviews = array();

		// Loop through reviews and standardize properties.
		foreach ( $response['reviews'] as $r ) {
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

			// Set review text.
			if ( isset( $r['text'] ) ) {
				$review['review_text'] = sanitize_text_field( $r['text'] );
			}

			// Set review URL.
			if (
				isset( $r['url'] )
				&& filter_var( $r['url'], FILTER_VALIDATE_URL )
			) {
				$review['meta']['wpbr_review_url'] = $r['url'];
			}

			// Set reviewer name.
			if ( isset( $r['user']['name'] ) ) {
				$review['meta']['wpbr_reviewer_name'] = sanitize_text_field( $r['user']['name'] );
			}

			// Set reviewer image URL.
			if (
				isset( $r['user']['image_url'] )
				&& filter_var( $r['user']['image_url'], FILTER_VALIDATE_URL )
			) {
				$review['meta']['wpbr_reviewer_image_url'] = $this->build_image_url( $r['user']['image_url'] );
			}

			// Set rating.
			if (
				isset( $r['rating'] )
				&& is_numeric( $r['rating'] )
			) {
				$review['meta']['wpbr_rating'] = $r['rating'];
			}

			// Set time created.
			if ( isset( $r['time_created'] ) ) {
				$review['meta']['wpbr_time_created'] = strtotime( $r['time_created'] );
			}

			$reviews[] = $review;
		}

		return $reviews;
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
