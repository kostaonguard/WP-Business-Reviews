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
		$response = $this->search( 'PNC Park', 'Pittsburgh' );

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
				'terms'  => $terms . ', ' . $location,
				'format' => 'json',
				'key'    => $this->key,
			),
			'http://api2.yp.com/listings/v1/search'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves business details based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_business( $id ) {
		$url = add_query_arg(
			array(
				'listingid' => $id,
				'format'     => 'json',
				'key'        => $this->key,
			),
			'http://api2.yp.com/listings/v1/details'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves reviews based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array Associative array containing the response body.
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

		return $response;
	}
}
