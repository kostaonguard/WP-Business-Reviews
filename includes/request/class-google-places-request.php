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

use WP_Business_Reviews\Includes\Request\Request_Base;

/**
 * Retrieves data from Google Places API.
 *
 * @since 0.1.0
 */
class Google_Places_Request extends Request_Base {
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
		$response = $this->search( 'PNC Park', 'Pittsburgh' );

		if ( isset( $response['status'] ) && 'REQUEST_DENIED' === $response['status'] ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Retrieves search results based on a search terms and location.
	 *
	 * @since 0.1.0
	 *
	 * @param string $terms    The search terms, usually a business name.
	 * @param string $location The location within which to search.
	 * @return array Associative array containing the response body.
	 */
	public function search( $terms, $location ) {
		$url = add_query_arg(
			array(
				'query' => $terms . ', ' . $location,
				'key'   => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/textsearch/json'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves business details based on Google Place ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Google Place ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_business( $id ) {
		$url = add_query_arg(
			array(
				'place_id' => $id,
				'key'      => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/details/json'
		);

		$response = $this->get( $url );

		return $response;
	}
}
