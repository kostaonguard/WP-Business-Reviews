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
	 * @inheritDoc
	 */
	protected $platform = 'facebook';

	/**
	 * Facebook user token.
	 *
	 * @since 0.1.0
	 * @var string $user_token
	 */
	protected $user_token;

	/**
	 * Array of Facebook Pages and Page tokens.
	 *
	 * @since 0.1.0
	 * @var array $pages
	 */
	protected $pages;

	/**
	 * Instantiates the Facebook_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $user_token Facebook user token.
	 * @param array  $pages      Array of Facebook Pages and Page tokens.
	 */
	public function __construct( $user_token, array $pages = array() ) {
		$this->user_token = $user_token;
		$this->pages = $pages;
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
				'access_token' => $this->user_token,
			),
			'https://graph.facebook.com/v2.11/me/'
		);

		$response = $this->get( $url );

		if ( isset( $response['error'] ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Retrieves Facebook pages from the Facebook Graph API.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array containing the response body.
	 */
	public function get_review_sources() {
		$url = add_query_arg(
			array(
				'access_token' => $this->user_token,
			),
			'https://graph.facebook.com/v2.11/me/accounts/'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves reviews based on Facebook Page ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $review_source_id The Facebook Page ID.
	 * @return array|WP_Error Associative array containing response or WP_Error
	 *                        if response structure is invalid.
	 */
	public function get_reviews( $review_source_id ) {
		if ( ! isset( $this->pages[ $review_source_id ] ) ) {
			return new \WP_Error( 'missing_facebook_page_token', __( 'Facebook Page access token could not be found.', 'wp-business-reviews' ) );
		}

		$page_token = $this->pages[ $review_source_id ]['token'];

		$url = add_query_arg(
			array(
				'limit'        => 24,
				'fields'       => 'reviewer{id,name,picture.height(144)},created_time,rating,review_text,open_graph_story{id}',
				'access_token' => $page_token,
			),
			"https://graph.facebook.com/v2.11/{$review_source_id}/ratings"
		);

		// Request data from remote API.
		$response = $this->get( $url );

		if ( ! isset( $response['data'] ) ) {
			return new \WP_Error( 'invalid_response_structure', __( 'Invalid response structure.', 'wp-business-reviews' ) );
		}

		return $response['data'];
	}

	/**
	 * Sets the Facebook user access token.
	 *
	 * @since 0.1.0
	 *
	 * @param string $user_token User access token.
	 */
	public function set_token( $user_token ) {
		$this->user_token = $user_token;
	}

	/**
	 * Determines if a token has been set.
	 *
	 * @since 0.1.0
	 *
	 * @return boolean True if token is set, false otherwise.
	 */
	public function has_token() {
		return ! empty( $this->user_token );
	}
}
