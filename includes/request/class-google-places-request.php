<?php
/**
 * Defines the Google_Places_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Google Places API.
 *
 * @since 0.1.0
 */
class Google_Places_Request extends Request {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'google_places';

	/**
	 * Google Places API key.
	 *
	 * @since 0.1.0
	 * @var string $key
	 */
	private $key;

	/**
	 * Instantiates the Google_Places_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Google Places API key.
	 */
	public function __construct( $key ) {
		$this->key = $key;
	}

	/**
	 * Tests the connection to the API with a sample search request.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if connection was successful, false otherwise.
	 */
	public function is_connected() {
		$response = $this->search_review_source( 'PNC Park', 'Pittsburgh' );

		if ( isset( $response['status'] ) && 'REQUEST_DENIED' === $response['status'] ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Searches review sources based on search terms and location.
	 *
	 * @since 0.1.0
	 *
	 * @param string $terms    The search terms, usually a Place name.
	 * @param string $location The location within which to search.
	 * @return array Array containing normalized review sources.
	 */
	public function search_review_source( $terms, $location ) {
		$review_sources = array();
		$query = trim( implode( array( $terms, $location ), ' ' ) );
		$url = add_query_arg(
			array(
				'query' => $query,
				'key'   => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/textsearch/json'
		);

		$response = $this->get( $url );

		if ( isset( $response['results'] ) ) {
			return $response['results'];
		} else {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}
	}

	/**
	 * Retrieves review source details based on Google Place ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $review_source_id The Google Place ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_review_source( $review_source_id ) {
		$url = add_query_arg(
			array(
				'placeid' => $review_source_id,
				'key'     => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/details/json'
		);

		$response = $this->get( $url );

		if ( isset( $response['result'] ) ) {
			return $response['result'];
		} else {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}
	}

	/**
	 * Retrieves reviews based on Google Place ID.
	 *
	 * Since Google Places API returns place and reviews data together, the
	 * same method can be used to return reviews.
	 *
	 * @since 0.1.0
	 *
	 * @param string $review_source_id The Google Place ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_reviews( $review_source_id ) {
		$response = $this->get_review_source( $review_source_id );
		$reviews  = $response['result']['reviews'];

		return $reviews;
	}
}
