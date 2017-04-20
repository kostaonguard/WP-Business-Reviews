<?php

/**
 * Normalize the response from one of the supported reviews APIs
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 */

/**
 * Normalize the response from one of the supported reviews APIs.
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @author     WordImpress, LLC <info@wordimpress.com>
 */
abstract class WPBR_Response {

	/**
	 * Reviews platform associated with the business.
	 *
	 * e.g. 'google_places', 'facebook', 'yelp', 'yp'
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_name;

	/**
	 * URL of the business page on the reviews platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_platform_url;

	/**
	 * URL of the business image or avatar.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_image_url;

	/**
	 * Average numerical rating of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var float
	 */
	protected $business_rating;

	/**
	 * Total reviews of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $business_review_count;

	/**
	 * Formatted phone number of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_phone;

	/**
	 * Formatted street address of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_address;

	/**
	 * Collection of reviews by individuals.
	 *
	 * Number and order of reviews are determined by the platform API.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $reviews;

	/**
	 * Initialize the response.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $platform, $business_id ) {

		$this->platform    = $platform;
		$this->business_id = $business_id;

		// Get data but don't update properties until data is normalized.
		$json_decoded_data = $this->get_json_decoded_data( $business_id );

		// Update properties in a consistent manner regardless of platform.
		$this->normalize_properties( $json_decoded_data );

	}

	/**
	 * Get JSON-decoded array of reviews data from platform API.
	 *
	 * @since 1.0.0
	 * @param string $business_id ID of the business used in API request.
	 *
	 * @return array JSON-decoded array of reviews data.
	 */
	abstract public function get_json_decoded_data( $business_id );

	/**
	 * Translate API data into normalized property values.
	 *
	 * Every reviews platform returns data with a different structure. This
	 * function and the setter functions within ensure that the properties of
	 * this class follow a consistent structure regardless of platform.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 *
	 * @return array
	 */
	protected function normalize_properties( $data ) {

		// Each of these setter methods must be customized per platform.
		$this->set_business_name( $data );
		$this->set_business_platform_url( $data );
		$this->set_business_image_url( $data );
		$this->set_business_rating( $data );
		$this->set_business_review_count( $data );
		$this->set_business_phone( $data );
		$this->set_business_address( $data );
		$this->set_reviews( $data );

	}

	/**
	 * Set the business name.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_name( $data );

	/**
	 * Set the URL of the business page on the reviews platform.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_platform_url( $data );

	/**
	 * Set the URL of the business image or avatar.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_image_url( $data );

	/**
	 * Set the business rating.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_rating( $data );

	/**
	 * Set the total number of business reviews.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_review_count( $data );

	/**
	 * Set the formatted business phone number.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_phone( $data );

	/**
	 * Set the formatted business address.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_address( $data );

	/**
	 * Set the collection of individual reviews.
	 *
	 * @since 1.0.0
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_reviews( $data );

}
