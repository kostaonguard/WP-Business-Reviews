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
	 * Set of review objects for the parent business.
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
		// TODO: Define WP_Query to get local reviews in database
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
	 * Sets reviews from remote API.
	 *
	 * @since 1.0.0
	 */
	public function set_reviews_from_api() {
		// Request reviews from remote API.
		$request  = WPBR_Request_Factory::create( $this->business_id, $this->platform );
		$response = $request->request_reviews();

		if ( is_array( $response ) ) {
			// Standardize API response data to match class properties.
			$reviews = $request->standardize_reviews( $response );

			foreach ( $reviews as $properties ) {
				$review = new WPBR_Review( $this->business_id, $this->platform );
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
				if ( $review instanceof WPBR_Review ) {
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
