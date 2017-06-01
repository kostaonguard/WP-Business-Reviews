<?php
/**
 * Defines the Facebook_Request subclass
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
 * Requests data from the Facebook Open Graph API.
 *
 * @since 1.0.0
 * @see Request
 */
class Facebook_Request extends Request {

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
		$this->business_path = "/v2.9/$this->business_id";
		$this->reviews_path  = "/v2.9/{$this->business_id}/ratings";
		// TODO: Get Page Access Token from database instead of using constant.
		$this->access_token = FACEBOOK_PAGE_ACCESS_TOKEN;
	}

	/**
	 * Requests business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Business data or WP_Error on failure.
	 */
	public function request_business() {
		// Define fields to be included in response.
		$fields = array(
			'id',
			'name',
			'link',
			'picture.height(192)',
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
	 * @return array|WP_Error Reviews data or WP_Error on failure.
	 */
	public function request_reviews() {
		// Define fields to be included in response.
		$fields = array(
			'reviewer{id,name,picture.height(144)}',
			'open_graph_story',
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
		$response = $this->request( $this->reviews_path, $url_params );

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
		if (
			isset( $r['link'] )
			&& filter_var( $r['link'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['wpbr_page_url'] = $r['link'];
		}

		// Set image URL.
		if (
			isset( $r['picture']['data']['url'] )
			&& filter_var( $r['picture']['data']['url'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['wpbr_image_url'] = $r['picture']['data']['url'];
		}

		// Set rating.
		if (
			isset( $r['overall_star_rating'] )
			&& is_numeric( $r['overall_star_rating'] )
		) {
			$business['meta']['wpbr_rating'] = $r['overall_star_rating'];
		}

		// Set rating count.
		if (
			isset( $r['rating_count'] )
			&& is_numeric( $r['rating_count'] )
		) {
			$business['meta']['wpbr_rating_count'] = $r['rating_count'];
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$business['meta']['wpbr_phone'] = sanitize_text_field( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['location']['street'] ) ) {
			$business['meta']['wpbr_street_address'] = sanitize_text_field( $r['location']['street'] );
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
		if ( isset( $r['location']['zip'] ) ) {
			$business['meta']['wpbr_postal_code'] = sanitize_text_field( $r['location']['zip'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$business['meta']['wpbr_country'] = sanitize_text_field( $r['location']['country'] );
		}

		// Set latitude.
		if (
			isset( $r['location']['latitude'] )
			&& is_float( $r['location']['latitude'] )
		) {
			$business['meta']['wpbr_latitude'] = sanitize_text_field( $r['location']['latitude'] );
		}

		// Set longitude.
		if (
			isset( $r['location']['longitude'] )
			&& is_float( $r['location']['longitude'] )
		) {
			$business['meta']['wpbr_longitude'] = sanitize_text_field( $r['location']['longitude'] );
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
		if ( ! isset( $response['data'] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		}

		// Initialize array to store standardized properties.
		$reviews = array();

		// Loop through reviews and standardize properties.
		foreach ( $response['data'] as $r ) {
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
			if ( isset( $r['open_graph_story']['message'] ) ) {
				$review['review_text'] = sanitize_text_field( $r['open_graph_story']['message'] );
			}

			// Get reviewer ID in order to build review URL.
			if ( isset( $r['reviewer']['id'] ) ) {
				$reviewer_id = intval( $r['reviewer']['id'] );
			}

			// Get review ID in order to build review URL.
			if ( isset( $r['open_graph_story']['id'] ) ) {
				$review_id = intval( $r['open_graph_story']['id'] );
			}

			// Set review URL using the reviewer ID and review ID.
			if (
				isset( $reviewer_id )
				&& isset( $review_id )
			) {
				$review['meta']['wpbr_review_url'] = "https://www.facebook.com/{$reviewer_id}/posts/{$review_id}";
			}

			// Set reviewer name.
			if ( isset( $r['reviewer']['name'] ) ) {
				$review['meta']['wpbr_reviewer_name'] = sanitize_text_field( $r['reviewer']['name'] );
			}

			// Set reviewer image URL.
			if (
				isset( $r['reviewer']['picture']['data']['url'] )
				&& filter_var( $r['reviewer']['picture']['data']['url'], FILTER_VALIDATE_URL )
			) {
				$review['meta']['wpbr_reviewer_image_url'] = $r['reviewer']['picture']['data']['url'];
			}

			// Set rating.
			if (
				isset( $r['open_graph_story']['data']['rating']['value'] )
				&& is_numeric( $r['open_graph_story']['data']['rating']['value'] )
			) {
				$review['meta']['wpbr_rating'] = $r['open_graph_story']['data']['rating']['value'];
			}

			// Set time created.
			if ( isset( $r['open_graph_story']['start_time'] ) ) {
				$review['meta']['wpbr_time_created'] = strtotime( $r['open_graph_story']['start_time'] );
			}

			$reviews[] = $review;
		}

		return $reviews;
	}
}
