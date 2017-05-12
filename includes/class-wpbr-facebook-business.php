<?php

/**
 * Defines the WPBR_Facebook_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for Facebook.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_Facebook_Business extends WPBR_Business {

	/**
	 * Format properties from remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 *
	 * @return array Array of formatted properties.
	 */
	protected function format_properties_from_api( $business_id ) {

		// Request business details from API.
		$request = new WPBR_Facebook_Request( $business_id );
		$data    = $request->request_business();

		// Format image URL.
		$image_url = $this->format_image_url( $business_id );

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : '',
			'platform_url'   => isset( $data['link'] ) ? $data['link'] : '',
			'image_url'      => $image_url,
			'rating'         => isset( $data['overall_star_rating'] ) ? $data['overall_star_rating'] : '',
			'rating_count'   => isset( $data['rating_count'] ) ? $data['rating_count'] : '',
			'phone'          => isset( $data['phone'] ) ? $data['phone'] : '',
			'latitude'       => isset( $data['location']['latitude'] ) ? $data['location']['latitude'] : '',
			'longitude'      => isset( $data['location']['longitude'] ) ? $data['location']['longitude'] : '',
			'street_address' => isset( $data['location']['street_address'] ) ? $data['location']['street_address'] : '',
			'city'           => isset( $data['location']['city'] ) ? $data['location']['city'] : '',
			'state_province' => isset( $data['location']['state'] ) ? $data['location']['state'] : '',
			'postal_code'    => isset( $data['location']['zip'] ) ? $data['location']['zip'] : '',
			'country'        => isset( $data['location']['country'] ) ? $data['location']['country'] : '',

		);

		return $properties;

	}

	/**
	 * Format image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 * @return string $image_url URL of the business image.
	 */
	protected function format_image_url( $business_id ) {

		$image_url = "https://graph.facebook.com/v2.9/{$business_id}/picture/?height=192";

		return $image_url;

	}

}
