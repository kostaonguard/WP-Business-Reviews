<?php

/**
 * Defines the WPBR_Yelp_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for Yelp.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_Yelp_Business extends WPBR_Business {

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
		$request = new WPBR_Yelp_Request( $business_id );
		$data    = $request->request_business();

		// Format image URL.
		$image_url = isset( $data['image_url'] ) ? $data['image_url'] : '';
		$image_url = $this->format_image_url( $image_url );

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : '',
			'platform_url'   => isset( $data['url'] ) ? $data['url'] : '',
			'image_url'      => $image_url,
			'rating'         => isset( $data['rating'] ) ? $data['rating'] : '',
			'rating_count'   => isset( $data['review_count'] ) ? $data['review_count'] : '',
			'phone'          => isset( $data['display_phone'] ) ? $data['display_phone'] : '',
			'latitude'       => isset( $data['coordinates']['latitude'] ) ? $data['coordinates']['latitude'] : '',
			'longitude'      => isset( $data['coordinates']['longitude'] ) ? $data['coordinates']['longitude'] : '',
			'street_address' => isset( $data['location']['address1'] ) ? $data['location']['address1'] : '',
			'city'           => isset( $data['location']['city'] ) ? $data['location']['city'] : '',
			'state_province' => isset( $data['location']['state'] ) ? $data['location']['state'] : '',
			'postal_code'    => isset( $data['location']['zip_code'] ) ? $data['location']['zip_code'] : '',
			'country'        => isset( $data['location']['country'] ) ? $data['location']['country'] : '',

		);

		return $properties;

	}

	/**
	 * Format image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url URL of the original business image.
	 * @return string URL of the sized business image.
	 */
	protected function format_image_url( $image_url ) {

		if ( ! empty( $image_url ) ) {

			// Replace original size with more appropriate square size.
			$image_url_sized = str_replace( 'o.jpg', 'ls.jpg', $image_url );

			return $image_url_sized;

		} else {

			return '';

		}

	}

}
