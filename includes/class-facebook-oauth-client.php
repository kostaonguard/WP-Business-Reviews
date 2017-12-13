<?php
/**
 * Defines the Facebook_Oauth_Client class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Settings\Serializer;
use WP_Business_Reviews\Includes\Request\Facebook_Request;

/**
 * Handles the OAuth2 token received after Facebook authentication.
 *
 * The Facebook OAuth client handles the reception and renewal of Facebook
 * access tokens.
 *
 * @since 0.1.0
 */
class Facebook_Oauth_Client {
	/**
	 * Serializer.
	 *
	 * @since 0.1.0
	 * @var Serializer $serializer
	 */
	private $serializer;

	/**
	 * Facebook request.
	 *
	 * @since 0.1.0
	 * @var Facebook_Request $request
	 */
	private $request;

	/**
	 * Instantiates the Facebook_Oauth_Client object.
	 *
	 * @since 0.1.0
	 *
	 * @param Serializer       $serializer Settings saver.
	 * @param Facebook_Request $request    Facebook request.
	 */
	public function __construct( Serializer $serializer, Facebook_Request $request ) {
		$this->serializer = $serializer;
		$this->request    = $request;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'save_user_access_token' ) );
	}

	public function save_user_access_token() {
		error_log( print_r( 'saving user access token', true ) );
	}

	public function save_page_access_tokens() {
		// Use user access token to retrieve page access tokens.
		// Save page access tokens to database.
	}
}
