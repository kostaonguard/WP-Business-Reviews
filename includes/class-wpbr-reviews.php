<?php

/**
 * Defines the WPBR_Reviews abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Reviews object which contains a list of normalized
 * reviews belonging to a single business from a single platform.
 *
 * @since 1.0.0
 */
abstract class WPBR_Reviews {

	/**
	 * ID of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * List of reviews for a single business.
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

		// Temp for testing.

		$data = $this->remote_get_reviews();
		$standardized_data = $this->standardize_reviews( $data );
		$this->set_reviews_from_array( $standardized_data );
		$this->insert_posts();

		echo '<pre>'; var_dump( $this ); echo '</pre>';

	}

	/**
	 * Get reviews data from remote API.
	 *
	 * @since 1.0.0
	 */
	public function remote_get_reviews() {

		// Request reviews from API.
		$request = WPBR_Request_Factory::create( $this->business_id, $this->platform );
		$data    = $request->request_reviews();

		return $data;

	}

	/**
	 * Standardizes a set of reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Multidimensional array of standardized properties and values.
	 */
	abstract public function standardize_reviews( $data );

	/**
	 * Initialize review objects based on array of standardized data.
	 *
	 * @since 1.0.0
	 *
	 * @param array $standardized_data Multidimensional array of standardized
	 *                                 properties and values.
	 *
	 * @return array Multidimensional array of review objects.
	 */
	public function set_reviews_from_array( $standardized_data ) {

		$reviews = array();

		foreach ( $standardized_data as $properties ) {

			$review = new WPBR_Google_Places_Review( $this->business_id );
			$review->set_properties_from_array( $properties );

			$reviews[] = $review;
		}

		$this->reviews = $reviews;

	}

	/**
	 * Standardizes a set of reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Multidimensional array of standardized properties and values.
	 */
	public function insert_posts() {

		foreach ( $this->reviews as $review ) {

			$review->insert_post();

		}

	}

}
