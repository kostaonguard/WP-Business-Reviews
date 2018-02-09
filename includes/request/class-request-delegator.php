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
	 * @var Request_Factory $request_factory
	 */
	private $request_factory;

	/**
	 * Factory that creates response normalizers.
	 *
	 * @since 0.1.0
	 *
	 * @var Response_Normalizer_Factory $normalizer_factory
	 */
	private $normalizer_factory;

	/**
	 * Request that retrieves data from remote API.
	 *
	 * @since 0.1.0
	 *
	 * @var Request $request
	 */
	private $request;

	/**
	 * Response normalizer that sanitizes and normalizes raw API responses.
	 *
	 * @since 0.1.0
	 *
	 * @var Response_Normalizer_Abstract $normalizer
	 */
	private $normalizer;

	/**
	 * Instantiates the Request_Delegator object.
	 *
	 * @since 0.1.0
	 *
	 * @param Request_Factory             $request_factory    Request factory.
	 * @param Response_Normalizer_Factory $normalizer_factory Normalizer factory.
	 */
	public function __construct(
		Request_Factory $request_factory,
		Response_Normalizer_Factory $normalizer_factory
	) {
		$this->request_factory    = $request_factory;
		$this->normalizer_factory = $normalizer_factory;
		$this->request            = null;
		$this->normalizer         = null;
	}

	public function init( $platform ) {
		$this->request    = $this->request_factory->create( $platform );
		$this->normalizer = $this->normalizer_factory->create( $platform );
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_ajax_wpbr_search_review_source', array( $this, 'ajax_search_review_source' ) );
		add_action( 'wp_ajax_wpbr_get_source_and_reviews', array( $this, 'ajax_get_source_and_reviews' ) );
	}

	/**
	 * Searches a remote reviews platform based on platform and search query.
	 *
	 * @since 0.1.0
	 *
	 * @param string $terms    The search terms.
	 * @param string $location The search location.
	 * @return array Normalized, sanitized response body.
	 */
	public function search_review_source( $terms, $location ) {
		$raw_response = $this->request->search_review_source( $terms, $location );

		if ( is_wp_error( $raw_response ) ) {
			return $raw_response->get_error_message();
		}

		$review_source = $this->normalizer->normalize_review_sources(
			$raw_response
		);

		return $review_source;
	}

	/**
	 * Requests review source based on the provided platform and review source ID.
	 *
	 * A review source is the business or entity with which individual reviews
	 * are associated.
	 *
	 * @since 0.1.0
	 *
	 * @param string $review_source_id The review source ID.
	 * @return Review_Source Normalized Review_Source object.
	 */
	public function get_review_source( $review_source_id ) {
		$raw_response = $this->request->get_review_source( $review_source_id );

		if ( is_wp_error( $raw_response ) ) {
			return $raw_response->get_error_message();
		}

		$review_source = $this->normalizer->normalize_review_source( $raw_response );

		return $review_source;
	}

	/**
	 * Requests reviews based on the provided platform and review source ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $review_source_id The review source ID.
	 * @return Review[] Array of normalized Review objects.
	 */
	public function get_reviews( $review_source_id ) {
		$raw_response = $this->request->get_reviews( $review_source_id );
		$reviews = array();

		if ( is_wp_error( $raw_response ) ) {
			return $raw_response->get_error_message();
		}

		$reviews = $this->normalizer->normalize_reviews(
			$raw_response,
			$review_source_id
		);

		return $reviews;
	}

	/**
	 * Searches a remote reviews platform based on platform and search query.
	 *
	 * @since 0.1.0
	 */
	public function ajax_search_review_source() {
		if ( ! isset( $_POST['platform'], $_POST['terms'], $_POST['location'] ) ) {
			wp_die();
		}

		// TODO: Verify nonce and permission.

		// Set request parameters from posted Ajax request.
		$platform = sanitize_text_field( $_POST['platform'] );
		$terms    = sanitize_text_field( $_POST['terms'] );
		$location = sanitize_text_field( $_POST['location'] );

		// Initialize the request and normalizer based on the platform.
		$this->init( $platform );

		// Get review source data from remote API.
		$review_source_array = $this->search_review_source( $terms, $location );

		// Send it back as JSON.
		wp_send_json( $review_source_array );
	}

	/**
	 * Requests review source and reviews via Ajax post request.
	 *
	 * Review source and its reviews are frequently requested together. This
	 * function sends data for both in a single response.
	 *
	 * @since 0.1.0
	 */
	public function ajax_get_source_and_reviews() {
		// Check for platform and review source ID in $_POST.
		if ( ! isset( $_POST['platform'], $_POST['reviewSourceId'] ) ) {
			wp_die();
		}

		// TODO: Verify nonce and permission.

		// Set request parameters from posted Ajax request.
		$platform         = sanitize_text_field( $_POST['platform'] );
		$review_source_id = sanitize_text_field( $_POST['reviewSourceId'] );

		// Initialize the request and normalizer based on the platform.
		$this->init( $platform );

		// Get review source and reviews data from remote API.
		$review_source_array = $this->get_review_source( $review_source_id );
		$reviews_array       = $this->get_reviews( $review_source_id );

		// Send it all back together as JSON.
		wp_send_json(
			array(
				'review_source' => $review_source_array,
				'reviews'       => $reviews_array,
			)
		);
	}
}
