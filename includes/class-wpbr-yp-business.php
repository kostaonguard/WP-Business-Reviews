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
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	public function standardize_properties( $data ) {

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['businessName'] ) ? $data['businessName'] : '',
			'page_url'       => isset( $data['moreInfoURL'] ) ? $data['moreInfoURL'] : '',
			'image_url'      => '', // Unavailable.
			'rating'         => isset( $data['averageRating'] ) ? $data['averageRating'] : '',
			'rating_count'   => isset( $data['ratingCount'] ) ? $data['ratingCount'] : '',
			'phone'          => isset( $data['phone'] ) ? $data['phone'] : '',
			'street_address' => isset( $data['street'] ) ? $data['street'] : '',
			'city'           => isset( $data['city'] ) ? $data['city'] : '',
			'state_province' => isset( $data['state'] ) ? $data['state'] : '',
			'postal_code'    => isset( $data['zip'] ) ? $data['zip'] : '',
			'country'        => '', // Unavailable.
			'latitude'       => isset( $data['latitude'] ) ? $data['latitude'] : '',
			'longitude'      => isset( $data['longitude'] ) ? $data['longitude'] : '',

		);

		return $properties;

	}

}
