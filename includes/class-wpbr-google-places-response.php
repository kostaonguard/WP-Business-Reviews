<?php

/**
 * Defines the WPBR_Google_Places_Response subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from the Google Places API.
 *
 * This class normalizes the Google Places API response by parsing the data
 * into WPBR_Business and WPBR_Review objects.
 *
 * @since 1.0.0
 * @see WPBR_Response
 */
class WPBR_Google_Places_Response extends WPBR_Response {

	/**
	 * Set the business name.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_name( $data ) {

		$this->business_name = $data['result']['name'];

	}

	/**
	 * Set the URL of the business page on the reviews platform.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_platform_url( $data ) {
		// TODO: Implement set_business_platform_url() method.
	}

	/**
	 * Set the URL of the business image or avatar.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_image_url( $data ) {
		// TODO: Implement set_business_image_url() method.
	}

	/**
	 * Set the business rating.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_rating( $data ) {

		$this->business_rating = $data['result']['rating'];

	}

	/**
	 * Set the total number of business reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_review_count( $data ) {
		// TODO: Implement set_business_review_count() method.
	}

	/**
	 * Set the formatted business phone number.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_phone( $data ) {

		$this->business_phone = $data['result']['formatted_phone_number'];

	}

	/**
	 * Set the formatted business address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_address( $data ) {

		$this->business_address = $data['result']['formatted_address'];

	}

	/**
	 * Set the collection of individual reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_reviews( $data ) {
		// TODO: Implement set_reviews() method.
	}

}
