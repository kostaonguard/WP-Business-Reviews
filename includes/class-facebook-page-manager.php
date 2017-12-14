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

use WP_Business_Reviews\Includes\Settings\Serializer;
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
	 * Instantiates the Facebook_Page_Manager object.
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
		add_filter( 'wp_business_reviews_field_get_value_facebook_user_token', array( $this, 'save_user_token' ) );
	}

	public function save_user_token( $token ) {
		if ( ! isset( $_POST['wpbr_facebook_user_token'] ) ) {
			return $token;
		}

		$new_token = sanitize_text_field( $_POST['wpbr_facebook_user_token'] );

		// If new token successfully saves, update $token value prior to return.
		if ( $this->serializer->save( 'facebook_user_token', $new_token) ) {
			error_log( print_r( 'just saved a user token', true ) );
			$token = $new_token;

			do_action( 'wp_business_reviews_facebook_user_token_saved', 'facebook' );

			// Since user token was updated, Facebook pages will need refreshed.
			add_filter( 'wp_business_reviews_field_get_value_facebook_pages', array( $this, 'save_pages' ) );
		}

		$this->request->set_token( $token );

		return $token;
	}

	public function save_pages( $pages ) {
		if ( ! $this->request->has_token() ) {
			return $pages;
		}

		$new_pages = array();
		$response  = $this->request->get_pages();

		// Process the array of pages and pull out only the keys we need.
		if ( isset( $response['data'] ) ) {
			foreach ( $response['data'] as $page ) {
				if ( ! isset( $page['id'], $page['name'], $page['access_token'] ) ) {
					continue;
				}

				$new_pages[ $page['id'] ] = array(
					'name'  => $page['name'],
					'token' => $page['access_token'],
				);
			}
		}

		// If new pages successfully save, update $pages value prior to return.
		if ( $this->serializer->save( 'facebook_pages', $new_pages) ) {
			error_log( print_r( 'saved pages!', true ) );
			$pages = $new_pages;
		}

		return $pages;
	}
}
