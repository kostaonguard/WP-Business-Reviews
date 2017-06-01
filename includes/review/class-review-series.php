<?php

/**
 * Defines the Review_Series class
 *
 * @package WP_Business_Reviews\Includes\Review
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Review;
use WP_Business_Reviews\Includes\Request;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Implements the Review_Series object which contains a series of
 * standardized reviews for a single business.
 *
 * @since 1.0.0
 */
class Review_Series {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the parent business on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Post ID of the parent business in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_post_id;

	/**
	 * Series of review objects for the parent business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $reviews;

	/**
	 * Constructor.
	 *
	 * @param string $business_id ID of the business.
	 * @param string $platform Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id, $platform ) {
		$this->business_id = $business_id;
		$this->platform    = $platform;
		$this->set_reviews_from_api();
	}

	/**
	 * Sets properties from array of key-value pairs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	protected function set_properties( array $properties ) {
		foreach ( $properties as $property => $value ) {
			$this->$property = $value;
		}
	}

	/**
	 * Sets reviews from database.
	 *
	 * Wrapper for WP_Query that queries review posts based on the post ID of the
	 * parent business.
	 *
	 * @since 1.0.0
	 * @see WP_Query
	 *
	 * @param array $args Args passed to WP_Query.
	 *
	 * @return array Set of standardized review objects.
	 */
	public function set_reviews_from_posts( $args ) {
		// TODO: Define WP_Query to get local reviews in database
	}

	/**
	 * Sets reviews from remote API.
	 *
	 * @since 1.0.0
	 */
	public function set_reviews_from_api() {
		// Request reviews from remote API.
		$request  = Request\Request_Factory::create( $this->business_id, $this->platform );
		$response = $request->request_reviews();

		if ( is_wp_error( $response ) ) {
			/* translators: 1: Error code, 2: Error message. */
			printf( __( 'Reviews Error: [%1$s] %2$s' ) . '<br>', $response->get_error_code(), $response->get_error_message() );
			return;
		} else {
			// Standardize API response data to match class properties.
			$reviews = $request->standardize_reviews( $response );

			if ( is_wp_error( $reviews ) ) {
				/* translators: 1: Error code, 2: Error message. */
				printf( __( 'Reviews Error: %1$s' ) . '<br>', $reviews->get_error_message() );
				return;
			}

			foreach ( $reviews as $properties ) {
				$review = new Review( $this->business_id, $this->platform );
				$review->set_properties( $properties );
				$this->reviews[] = $review;
			}
		}
	}

	/**
	 * Inserts review posts into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_posts() {
		if ( is_array( $this->reviews ) && ! empty( $this->reviews ) ) {
			foreach ( $this->reviews as $review ) {
				if ( $review instanceof Review ) {
					$review->insert_post();
				}
			}
		}
	}

	/**
	 * Inserts or updates existing review posts based on remote API response.
	 *
	 * @since 1.0.0
	 */
	public function update_reviews_from_api() {
		$this->set_reviews_from_api();
		$this->insert_posts();
	}
}
