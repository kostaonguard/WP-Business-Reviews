<?php

/**
 * Defines the WPBR_YP_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for YP.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_YP_Business extends WPBR_Business {

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
		$request = new WPBR_YP_Request( $business_id );
		$data    = $request->request_business();

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['businessName'] ) ? $data['businessName'] : '',
			'platform_url'   => isset( $data['moreInfoURL'] ) ? $data['moreInfoURL'] : '',
			'image_url'      => '', // Unavailable.
			'rating'         => isset( $data['averageRating'] ) ? $data['averageRating'] : '',
			'rating_count'   => isset( $data['ratingCount'] ) ? $data['ratingCount'] : '',
			'phone'          => isset( $data['phone'] ) ? $data['phone'] : '',
			'latitude'       => isset( $data['latitude'] ) ? $data['latitude'] : '',
			'longitude'      => isset( $data['longitude'] ) ? $data['longitude'] : '',
			'street_address' => isset( $data['street'] ) ? $data['street'] : '',
			'city'           => isset( $data['city'] ) ? $data['city'] : '',
			'state_province' => isset( $data['state'] ) ? $data['state'] : '',
			'postal_code'    => isset( $data['zip'] ) ? $data['zip'] : '',
			'country'        => '', // Unavailable.

		);

		return $properties;

	}

}
