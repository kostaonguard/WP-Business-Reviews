<?php

/**
 * Defines the WPBR_Reviews_Set class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Reviews_Set object which contains a set of
 * standardized reviews for a single business.
 *
 * @since 1.0.0
 */
class WPBR_Reviews_Set {

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
	 * Set of reviews from the parent business.
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

	}

	/**
	 * Gets local review posts from database.
	 *
	 * Wrapper for WP_Query that gets review posts based on the post ID of the
	 * parent business.
	 *
	 * @since 1.0.0
	 * @see WP_Query
	 *
	 * @param array $args Args passed to WP_Query.
	 *
	 * @return array Set of standardized review objects.
	 */
	public function get_local_reviews( $args ) {

		// TODO: Define WP_Query to get local reviews in database.

	}

	/**
	 * Gets reviews from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return array Set of standardized review objects.
	 */
	public function get_remote_reviews() {

		// Initialize array in which standardized reviews will be added.
		$standardized_reviews = array();

		// Request reviews from remote API.
		$request        = WPBR_Request_Factory::create( $this->business_id, $this->platform );
		$remote_reviews = $request->request_reviews();


		if ( ! is_array( $remote_reviews ) || empty( $remote_reviews ) ) {

			return array();

		}

		// Standardize reviews so that properties are consistent, regardless of platform.
		foreach ( $remote_reviews as $remote_review ) {

			// Create new review based on platform.
			$review = WPBR_Review_Factory::create( $this->business_id, $this->platform );

			// Standardize data to match class properties.
			$properties = $review->standardize_properties( $remote_review );
			$review->set_properties_from_array( $properties );

			$standardized_reviews[] = $review;

		}

		return $standardized_reviews;

	}

	/**
	 * Sets reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $reviews Array of review objects.
	 */
	public function set_reviews( $reviews ) {

		$this->reviews = is_array( $reviews ) ? $reviews : null;

	}

	/**
	 * Inserts review posts into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_posts() {

		if ( ! is_array( $this->reviews ) || empty( $this->reviews ) ) {

			return;

		}

		foreach ( $this->reviews as $review ) {

			if ( $review instanceof WPBR_Review ) {

				$review->insert_post();

			}

		}

	}

	/**
	 * Inserts or updates existing review posts based on remote API response.
	 *
	 * @since 1.0.0
	 */
	public function update_reviews_from_api() {

		$remote_reviews = $this->get_remote_reviews();
		$this->set_reviews( $remote_reviews );
		$this->insert_posts();

	}

}
