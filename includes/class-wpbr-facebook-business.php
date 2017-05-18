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
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'facebook';

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

		// Build image URL.
		$image_url = $this->build_image_url();

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : '',
			'page_url'       => isset( $data['link'] ) ? $data['link'] : '',
			'image_url'      => $image_url,
			'rating'         => isset( $data['overall_star_rating'] ) ? $data['overall_star_rating'] : '',
			'rating_count'   => isset( $data['rating_count'] ) ? $data['rating_count'] : '',
			'phone'          => isset( $data['phone'] ) ? $data['phone'] : '',
			'street_address' => isset( $data['location']['street_address'] ) ? $data['location']['street_address'] : '',
			'city'           => isset( $data['location']['city'] ) ? $data['location']['city'] : '',
			'state_province' => isset( $data['location']['state'] ) ? $data['location']['state'] : '',
			'postal_code'    => isset( $data['location']['zip'] ) ? $data['location']['zip'] : '',
			'country'        => isset( $data['location']['country'] ) ? $data['location']['country'] : '',
			'latitude'       => isset( $data['location']['latitude'] ) ? $data['location']['latitude'] : '',
			'longitude'      => isset( $data['location']['longitude'] ) ? $data['location']['longitude'] : '',

		);

		return $properties;

	}

	/**
	 * Format image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL of the business image.
	 */
	protected function build_image_url() {

		$image_url = "https://graph.facebook.com/v2.9/{$this->business_id}/picture/?height=192";

		return $image_url;

	}

}
