<?php
/**
 * Defines the Facebook_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Facebook Graph API.
 *
 * @since 0.1.0
 */
class Facebook_Request extends Request {
	/**
	 * Instantiates the Facebook_Request object.
	 *
	 * @since 0.1.0
	 */
	public function __construct( $token ) {
		$this->token = $token;
	}

	/**
	 * Tests the connection to the API with a sample request.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if connection was successful, false otherwise.
	 */
	public function is_connected() {
		$url = add_query_arg(
			array(
				'access_token' => $this->token,
			),
			'https://graph.facebook.com/v2.11/me/'
		);

		$response = $this->get( $url );

		if ( isset( $response['error'] ) ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Retrieves Facebook pages from the Facebook Graph API.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array containing the response body.
	 */
	public function get_pages() {
		$url = add_query_arg(
			array(
				'access_token' => $this->token,
			),
			'https://graph.facebook.com/v2.11/me/accounts/'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Sets the Facebook user access token.
	 *
	 * @since 0.1.0
	 *
	 * @param string $token User access token.
	 */
	public function set_token( $token ) {
		$this->token = $token;
	}

	/**
	 * Determines if a token has been set.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if token is set, false otherwise.
	 */
	public function has_token() {
		return ! empty( $this->token );
	}
}
