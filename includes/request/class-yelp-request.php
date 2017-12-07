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

use WP_Business_Reviews\Includes\Request\Request_Base;

/**
 * Retrieves data from Yelp Fusion API.
 *
 * @since 0.1.0
 */
class Yelp_Request extends Request_Base {
	/**
	 * Instantiates the Yelp_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $client_id     The client ID of the Yelp app.
	 * @param string $client_secret The client secret of the Yelp app.
	 * @param string $token  Optional. Access token for Yelp Fusion API.
	 */
	public function __construct( $client_id, $client_secret, $token = '' ) {
		$this->client_id     = $client_id;
		$this->client_secret = $client_secret;
		$this->token         = $token;
	}

	/**
	 * Tests the connection to the API with a sample search request.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if connection was successful, otherwise false.
	 */
	public function is_connected() {
		$response = $this->search( 'PNC Park', 'Pittsburgh' );

		if ( isset( $response['error'] ) ) {
			return false;
		} else {
			return true;
		}
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
				'term'     => $term,
				'location' => $location,
			),
			'https://api.yelp.com/v3/businesses/search'
		);

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->token,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Retrieves business details based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 */
	public function get_business( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id;

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->token,
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
	 */
	public function get_reviews( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id . '/reviews';

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->token,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Retrieves a Yelp Fusion API access token.
	 *
	 * @since 0.1.0
	 *
	 * @return string The Yelp Fusion API access token.
	 */
	private function get_token() {
		if ( ! empty( $this->token ) ) {
			return $this->token;
		} else {
			$args = array(
				'user-agent'     => '',
				'body'           => array(
					'grant_type'    => 'client_credentials',
					'client_id'     => $this->client_id,
					'client_secret' => $this->client_secret,
				)
			);

			$response = $this->post( 'https://api.yelp.com/oauth2/token', $args );

			return $response;
		}
	}
}
