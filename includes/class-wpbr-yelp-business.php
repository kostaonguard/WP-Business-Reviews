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
	 * Set properties based on remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 */
	protected function set_properties_from_api( $business_id ) {

		// Request business details from API.
		$request = new WPBR_Yelp_Request( $business_id );
		$data    = $request->request_business();

		// Set properties from API response.
		$this->set_business_name_from_api( $data );
		$this->set_platform_url_from_api( $data );
		$this->set_image_url_from_api( $data );
		$this->set_rating_from_api( $data );
		$this->set_rating_count_from_api( $data );
		$this->set_phone_from_api( $data );
		$this->set_latitude_from_api( $data );
		$this->set_longitude_from_api( $data );
		$this->set_street_address_from_api( $data );
		$this->set_city_from_api( $data );
		$this->set_state_province_from_api( $data );
		$this->set_postal_code_from_api( $data );
		$this->set_country_from_api( $data );

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_business_name_from_api( $data ) {

		$this->business_name = isset( $data['name'] ) ? $data['name'] : '';

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_platform_url_from_api( $data ) {

		$this->platform_url = isset( $data['url'] ) ? $data['url'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_image_url_from_api( $data ) {

		$image_url_original = isset( $data['image_url'] ) ? $data['image_url'] : '';

		if ( ! empty( $image_url_original ) ) {

			// Replace original size with more appropriate square size.
			$image_url_sized = str_replace( 'o.jpg', 'ls.jpg', $image_url_original );
			$this->image_url = $image_url_sized;

		}

	}

	/**
	 * Set rating from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_rating_from_api( $data ) {

		$this->rating = isset( $data['rating'] ) ? $data['rating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_rating_count_from_api( $data ) {

		$this->rating_count = isset( $data['review_count'] ) ? $data['review_count'] : '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_phone_from_api( $data ) {

		$this->phone = isset( $data['display_phone'] ) ? $data['display_phone'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_latitude_from_api( $data ) {

		$this->latitude = isset( $data['coordinates']['latitude'] ) ? $data['coordinates']['latitude'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_longitude_from_api( $data ) {

		$this->longitude = isset( $data['coordinates']['longitude'] ) ? $data['coordinates']['longitude'] : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_street_address_from_api( $data ) {

		$this->street_address = isset( $data['location']['address1'] ) ? $data['location']['address1'] : '';

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_city_from_api( $data ) {

		$this->city = isset( $data['location']['city'] ) ? $data['location']['city'] : '';

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_state_province_from_api( $data ) {

		$this->state_province = isset( $data['location']['state'] ) ? $data['location']['state'] : '';

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_postal_code_from_api( $data ) {

		$this->postal_code = isset( $data['location']['zip_code'] ) ? $data['location']['zip_code'] : '';

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_country_from_api( $data ) {

		$this->country = isset( $data['location']['country'] ) ? $data['location']['country'] : '';

	}

}
