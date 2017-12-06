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
class Google_Places_Request extends Base_Request {
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
	 */
	public function test_connection() {
		$response = $this->search_business( 'PNC Park', 'Pittsburgh' );

		return $response;
	}

	/**
	 * Retrieves search results based on a search term and location.
	 *
	 * @since 0.1.0
	 *
	 * @param string $term     The search term, usually a business name.
	 * @param string $location The location within which to search.
	 */
	public function search( $term, $location ) {
		$url = add_query_arg(
			array(
				'query' => $term . ', ' . $location,
				'key'   => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/textsearch/json'
		);

		$reponse = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves business details based on Google Place ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Google Place ID.
	 */
	public function get_business( $id ) {
		$url = add_query_arg(
			array(
				'place_id' => $id,
				'key'      => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/details/json'
		);

		$reponse = $this->get( $url );

		return $response;
	}
}
