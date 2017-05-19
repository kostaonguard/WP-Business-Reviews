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
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'yp';

	/**
	 * Standardizes business properties from the remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Business portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	public function standardize_properties( $data ) {

		// Standardize data to match class properties.
		$properties = array(

			'business_name'  => isset( $data['businessName'] ) ? $data['businessName'] : null,
			'page_url'       => isset( $data['moreInfoURL'] ) ? $data['moreInfoURL'] : null,
			'image_url'      => null, // Unavailable.
			'rating'         => isset( $data['averageRating'] ) ? $data['averageRating'] : null,
			'rating_count'   => isset( $data['ratingCount'] ) ? $data['ratingCount'] : null,
			'phone'          => isset( $data['phone'] ) ? $data['phone'] : null,
			'street_address' => isset( $data['street'] ) ? $data['street'] : null,
			'city'           => isset( $data['city'] ) ? $data['city'] : null,
			'state_province' => isset( $data['state'] ) ? $data['state'] : null,
			'postal_code'    => isset( $data['zip'] ) ? $data['zip'] : null,
			'country'        => null, // Unavailable.
			'latitude'       => isset( $data['latitude'] ) ? $data['latitude'] : null,
			'longitude'      => isset( $data['longitude'] ) ? $data['longitude'] : null,

		);

		return $properties;

	}

}
