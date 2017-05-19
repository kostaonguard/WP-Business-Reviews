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
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'yelp';

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

		// Define variables that need special handling for this API.
		$page_url = 'https://www.yelp.com/biz/' . $this->business_id;

		// Build image URL.
		$image_url = '';

		if ( isset( $data['image_url'] ) ) {

			$image_url = $this->build_image_url( $data['image_url'] );

		}

		// Standardize data to match class properties.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : null,
			'page_url'       => $page_url,
			'image_url'      => $image_url,
			'rating'         => isset( $data['rating'] ) ? $data['rating'] : null,
			'rating_count'   => isset( $data['review_count'] ) ? $data['review_count'] : null,
			'phone'          => isset( $data['display_phone'] ) ? $data['display_phone'] : null,
			'street_address' => isset( $data['location']['address1'] ) ? $data['location']['address1'] : null,
			'city'           => isset( $data['location']['city'] ) ? $data['location']['city'] : null,
			'state_province' => isset( $data['location']['state'] ) ? $data['location']['state'] : null,
			'postal_code'    => isset( $data['location']['zip_code'] ) ? $data['location']['zip_code'] : null,
			'country'        => isset( $data['location']['country'] ) ? $data['location']['country'] : null,
			'latitude'       => isset( $data['coordinates']['latitude'] ) ? $data['coordinates']['latitude'] : null,
			'longitude'      => isset( $data['coordinates']['longitude'] ) ? $data['coordinates']['longitude'] : null,

		);

		return $properties;

	}

	/**
	 * Build image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url URL of the original business image.
	 *
	 * @return string URL of the sized business image.
	 */
	protected function build_image_url( $image_url ) {

		if ( ! empty( $image_url ) ) {

			// Replace original size with more appropriate square size.
			$image_url_sized = str_replace( 'o.jpg', 'ls.jpg', $image_url );

			return $image_url_sized;

		} else {

			return '';

		}

	}

}
