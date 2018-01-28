<?php
/**
 * Defines the YP_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from YP API.
 *
 * @since 0.1.0
 */
class YP_Request extends Request {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'yp';

	/**
	 * YP API key.
	 *
	 * @since 0.1.0
	 * @var string $key
	 */
	private $key;

	/**
	 * Instantiates the YP_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key YP API key.
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

		if (
			isset( $response['result'] )
			&& isset( $response['result']['metaProperties'] )
			&& isset( $response['result']['metaProperties']['resultCode'] )
			&& 'Failure' === $response['result']['metaProperties']['resultCode']
		) {
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
	 * @param string $terms    The search terms, usually a business name.
	 * @param string $location The location within which to search.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function search_review_source( $terms, $location ) {
		$url = add_query_arg(
			array(
				'term'  => $terms . ', ' . $location,
				'format' => 'json',
				'key'    => $this->key,
			),
			'http://api2.yp.com/listings/v1/search'
		);

		$response = $this->get( $url );

		if ( ! isset( $response['searchResult']['searchListings']['searchListing'] ) ) {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}

		return $response['searchResult']['searchListings']['searchListing'];
	}

	/**
	 * Retrieves review source details based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_review_source( $id ) {
		$url = add_query_arg(
			array(
				'listingid' => $id,
				'format'     => 'json',
				'key'        => $this->key,
			),
			'http://api2.yp.com/listings/v1/details'
		);

		$response = $this->get( $url );

		return $response['listingsDetailsResult']['listingsDetails']['listingDetail'][0];
	}

	/**
	 * Retrieves reviews based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_reviews( $id ) {
		$url = add_query_arg(
			array(
				'listingid' => $id,
				'format'     => 'json',
				'key'        => $this->key,
			),
			'http://api2.yp.com/listings/v1/reviews'
		);

		$response = $this->get( $url );

		if ( ! isset( $response['ratingsAndReviewsResult']['reviews']['review'] ) ) {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}

		return $response['ratingsAndReviewsResult']['reviews']['review'];
	}
}
