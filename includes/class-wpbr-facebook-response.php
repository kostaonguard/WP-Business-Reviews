<?php

/**
 * Defines the WPBR_Facebook_Response subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from the Facebook Graph API.
 *
 * This class normalizes the Facebook Graph API response by parsing the data
 * into WPBR_Business and WPBR_Review objects.
 *
 * @since 1.0.0
 * @see WPBR_Response
 */
class WPBR_Facebook_Response extends WPBR_Response {

	/**
	 * Set the business name.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_name( $data ) {

		$this->business_name = $data['name'];

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

		$this->business_rating = $data['overall_star_rating'];

	}

	/**
	 * Set the total number of business reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_review_count( $data ) {

		$this->business_review_count = $data['rating_count'];

	}

	/**
	 * Set the formatted business phone number.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_phone( $data ) {

		$this->business_phone = $data['phone'];

	}

	/**
	 * Set the formatted business address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_address( $data ) {

		$this->business_address = $data['single_line_address'];

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
