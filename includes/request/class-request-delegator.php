<?php
/**
 * Defines the Request_Delegator class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

use WP_Business_Reviews\Includes\Request\Request_Factory;

/**
 * Searches a remote reviews platform.
 *
 * @since 0.1.0
 */
class Request_Delegator {
	/**
	 * Factory that creates requests.
	 *
	 * @since 0.1.0
	 * @var string $request_factory
	 */
	private $request_factory;

	/**
	 * Instantiates the Request_Delegator object.
	 *
	 * @param Request_Factory $request_factory Factory that creates requests
	 *                                         based on platform ID.
	 */
	public function __construct( Request_Factory $request_factory ) {
		$this->request_factory = $request_factory;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_ajax_wpbr_search_review_source', array( $this, 'ajax_search_review_source' ) );
		add_action( 'wp_ajax_wpbr_get_reviews', array( $this, 'ajax_get_reviews' ) );
	}

	/**
	 * Searches a remote reviews platform using arguments from Ajax request.
	 *
	 * @since 0.1.0
	 */
	public function ajax_search_review_source() {
		// TODO: Verify nonce and permission.

		if ( ! isset( $_REQUEST['platform'], $_REQUEST['terms'], $_REQUEST['location'] ) ) {
			wp_die();
		}

		$platform = sanitize_text_field( $_REQUEST['platform'] );
		$terms    = sanitize_text_field( $_REQUEST['terms'] );
		$location = sanitize_text_field( $_REQUEST['location'] );
		$response = $this->search_review_source( $platform, $terms, $location );
		wp_send_json( $response );
	}

	/**
	 * Searches a remote reviews platform using provided arguments.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The review platform ID.
	 * @param string $terms    The search terms.
	 * @param string $location The search location.
	 * @return array Associative array containing the response body.
	 */
	public function search_review_source( $platform, $terms, $location ) {
		$request = $this->request_factory->create( $platform );

		return $request->search_review_source( $terms, $location );
	}


	public function ajax_get_reviews() {
		if ( ! isset( $_REQUEST['platform'], $_REQUEST['reviewSourceId'] ) ) {
			wp_die();
		}

		$platform         = sanitize_text_field( $_REQUEST['platform'] );
		$review_source_id = sanitize_text_field( $_REQUEST['reviewSourceId'] );
		$response = $this->get_reviews( $platform, $review_source_id );
		wp_send_json( $response );
	}

	public function get_reviews( $platform, $review_source_id ) {
		$request = $this->request_factory->create( $platform );

		return $request->get_reviews( $review_source_id );
	}
}
