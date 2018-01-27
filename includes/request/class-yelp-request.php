<?php
/**
 * Defines the Yelp_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Yelp API.
 *
 * @since 0.1.0
 */
class Yelp_Request extends Request {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'yelp';

	/**
	 * Yelp API key.
	 *
	 * @since 0.1.0
	 * @var string $key
	 */
	private $key;

	/**
	 * Instantiates the Yelp_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Yelp API key.
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

		if ( isset( $response['error'] ) ) {
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
				'term'     => $terms,
				'location' => $location,
				'limit'    => 10,
			),
			'https://api.yelp.com/v3/businesses/search'
		);

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		if ( ! isset( $response['businesses'] ) ) {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}

		return $response['businesses'];
	}

	/**
	 * Retrieves review source details based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_review_source( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id;

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Retrieves reviews based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_reviews( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id . '/reviews';

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		if ( ! isset( $response['reviews'] ) ) {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}

		return $response['reviews'];
	}
}
