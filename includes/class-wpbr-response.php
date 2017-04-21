<?php

/**
 * Defines the WPBR_Response abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from one of the supported reviews APIs.
 *
 * Each reviews platform API returns a response with a unique structure. This
 * class normalizes that response by parsing the data into WPBR_Business and
 * WPBR_Review objects.
 *
 * @since 1.0.0
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
	 * URL used in the API request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $request_url;

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
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $request_url, $business_id ) {

		$this->request_url = $request_url;
		$this->business_id = $business_id;

		// Get unmodified response from platform API.
		$platform_response = $this->get_platform_response( $request_url );

		// Transform platform response into more manageable format.
		$json_decoded_data = $this->get_json_decoded_data( $platform_response );

		// Set properties in a consistent manner regardless of platform.
		$this->set_normalized_properties( $json_decoded_data );

	}

	/**
	 * Get unmodified response from platform API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $request_url URL used in the API request.
	 *
	 * @return array Unmodified response from platform API.
	 */
	protected function get_platform_response( $request_url ) {

		$response = wp_remote_get( $request_url );

		if( is_wp_error( $response ) ) {
			return false;
		}

		return $response;

	}

	/**
	 * Get JSON-decoded array of reviews data from platform API.
	 *
	 * @since 1.0.0
	 *
	 * @param string $response Unmodified response from platform API.
	 *
	 * @return array JSON-decoded array of reviews data.
	 */
	protected function get_json_decoded_data( $response ) {

		$response_body = wp_remote_retrieve_body( $response );

		$json_decoded_data = json_decode( $response_body, true );

		return $json_decoded_data;

	}

	/**
	 * Translate API data into normalized property values.
	 *
	 * Every reviews platform returns data with a different structure. This
	 * function and the setter functions within ensure that the properties of
	 * this class follow a consistent structure regardless of platform.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 *
	 * @return array
	 */
	protected function set_normalized_properties( $data ) {

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
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_name( $data );

	/**
	 * Set the URL of the business page on the reviews platform.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_platform_url( $data );

	/**
	 * Set the URL of the business image or avatar.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_image_url( $data );

	/**
	 * Set the business rating.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_rating( $data );

	/**
	 * Set the total number of business reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_review_count( $data );

	/**
	 * Set the formatted business phone number.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_phone( $data );

	/**
	 * Set the formatted business address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_business_address( $data );

	/**
	 * Set the collection of individual reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	abstract public function set_reviews( $data );

}
