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
use WP_Business_Reviews\Includes\Request\Response_Normalizer\Response_Normalizer_Factory;

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
	 *
	 * @var string $request_factory
	 */
	private $request_factory;

	/**
	 * Instantiates the Request_Delegator object.
	 *
	 * @since 0.1.0
	 *
	 * @param Request_Factory             $request_factory             Request factory.
	 * @param Response_Normalizer_Factory $response_normalizer_factory Response normalizer factory.
	 */
	public function __construct(
		Request_Factory $request_factory,
		Response_Normalizer_Factory $response_normalizer_factory
	) {
		$this->request_factory             = $request_factory;
		$this->response_normalizer_factory = $response_normalizer_factory;
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
	 * Searches a remote reviews platform based on platform and search query.
	 *
	 * @since 0.1.0
	 */
	public function ajax_search_review_source() {
		// TODO: Verify nonce and permission.

		if ( ! isset( $_POST['platform'], $_POST['terms'], $_POST['location'] ) ) {
			wp_die();
		}

		$platform = sanitize_text_field( $_POST['platform'] );
		$terms    = sanitize_text_field( $_POST['terms'] );
		$location = sanitize_text_field( $_POST['location'] );
		$response = $this->search_review_source( $platform, $terms, $location );
		wp_send_json( $response );
	}

	/**
	 * Searches a remote reviews platform based on platform and search query.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The review platform ID.
	 * @param string $terms    The search terms.
	 * @param string $location The search location.
	 * @return array Normalized, sanitized response body.
	 */
	public function search_review_source( $platform, $terms, $location ) {
		$request             = $this->request_factory->create( $platform );
		$normalizer          = $this->response_normalizer_factory->create( $platform );
		$raw_response        = $request->search_review_source( $terms, $location );

		if ( is_wp_error( $raw_response ) ) {
			return $raw_response->get_error_message();
		}

		$normalized_response = $normalizer->normalize_review_sources( $raw_response );

		return $normalized_response;
	}

	/**
	 * Requests reviews based on the provided platform and review source ID.
	 *
	 * @since 0.1.0
	 */
	public function ajax_get_reviews() {
		// TODO: Verify nonce and permission.

		if ( ! isset( $_POST['platform'], $_POST['reviewSourceId'] ) ) {
			wp_die();
		}

		$platform         = sanitize_text_field( $_POST['platform'] );
		$review_source_id = sanitize_text_field( $_POST['reviewSourceId'] );
		$response = $this->get_reviews( $platform, $review_source_id );
		wp_send_json( $response );
	}

	/**
	 * Requests reviews based on the provided platform and review source ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform         The review platform ID.
	 * @param string $review_source_id The review source ID.
	 * @return array Normalized, sanitized response body.
	 */
	public function get_reviews( $platform, $review_source_id ) {
		$request             = $this->request_factory->create( $platform );
		$normalizer          = $this->response_normalizer_factory->create( $platform );
		$raw_response        = $request->get_reviews( $review_source_id );

		if ( is_wp_error( $raw_response ) ) {
			return $raw_response->get_error_message();
		}

		$normalized_response = $normalizer->normalize_reviews( $raw_response );

		return $normalized_response;
	}
}
