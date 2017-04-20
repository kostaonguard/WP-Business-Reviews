<?php

/**
 * Normalize the response from the Google Places API
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 */

/**
 * Normalize the response from the Google Places API.
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @author     WordImpress, LLC <info@wordimpress.com>
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
		// TODO: Implement set_business_rating() method.
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
		// TODO: Implement set_business_phone() method.
	}

	/**
	 * Set the formatted business address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Array of reviews data, varies by platform.
	 */
	public function set_business_address( $data ) {
		// TODO: Implement set_business_address() method.
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
