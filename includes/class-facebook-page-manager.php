<?php
/**
 * Defines the Facebook_Page_Manager class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Serializer\Settings_Serializer;
use WP_Business_Reviews\Includes\Request\Facebook_Request;

/**
 * Manages tokens and requests related to Facebook pages.
 *
 * In order to retrieve reviews from Facebook pages, a user access token must
 * first be received from the WP Business Reviews Server plugin. Once received,
 * the user access token is used to request page access tokens, which are then
 * saved to the WordPress database so that reviews may be requested.
 *
 * @since 0.1.0
 *
 * @see WP_Business_Reviews/Includes/Request/Facebook_Request
 */
class Facebook_Page_Manager {
	/**
	 * Settings serializer.
	 *
	 * @since 0.1.0
	 * @var Settings_Serializer $serializer
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
	 * Instantiates the Facebook_Page_Manager object.
	 *
	 * @since 0.1.0
	 *
	 * @param Settings_Serializer $serializer Settings saver.
	 * @param Facebook_Request    $request    Facebook request.
	 */
	public function __construct( Settings_Serializer $serializer, Facebook_Request $request ) {
		$this->serializer = $serializer;
		$this->request    = $request;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'save_token' ), 1 );
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'save_pages' ), 1 );
	}

	public function save_token() {
		if ( ! isset( $_POST['wpbr_facebook_user_token'] ) ) {
			return false;
		}

		$token = sanitize_text_field( $_POST['wpbr_facebook_user_token'] );

		// Update the request token so it can be used in other methods.
		$this->request->set_token( $token );

		if ( $this->serializer->save( 'facebook_user_token', $token ) ) {
			/**
			 * Fires after Facebook user token successfully saves.
			 *
			 * @since 0.1.0
			 */
			do_action( 'wp_business_reviews_facebook_user_token_saved', 'facebook' );
			return true;
		} else {
			return false;
		}
	}

	public function save_pages() {
		if ( ! $this->request->has_token() ) {
			return false;
		}

		$pages = array();
		$response  = $this->request->get_pages();

		// Process the array of pages and pull out only the keys we need.
		if ( isset( $response['data'] ) ) {
			foreach ( $response['data'] as $page ) {
				if ( ! isset( $page['id'], $page['name'], $page['access_token'] ) ) {
					continue;
				}

				$pages[ $page['id'] ] = array(
					'name'  => $page['name'],
					'token' => $page['access_token'],
				);
			}
		}

		return $this->serializer->save( 'facebook_pages', $pages );
	}
}
