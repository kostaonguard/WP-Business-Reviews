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
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		// Request business details from API.
		$request = new WPBR_Facebook_Request( $this->business_id );
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
		$this->set_country_from_api( $data );
		$this->set_postal_code_from_api( $data );

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

		$this->platform_url = isset( $data['link'] ) ? $data['link'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_image_url_from_api( $data ) {

		if ( isset( $data['id'] ) ) {

			$this->image_url = "https://graph.facebook.com/v2.9/{$data['id']}/picture/?height=192";

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

		$this->rating = isset( $data['overall_star_rating'] ) ? $data['overall_star_rating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_rating_count_from_api( $data ) {

		$this->rating_count = isset( $data['rating_count'] ) ? $data['rating_count'] : '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_phone_from_api( $data ) {

		$this->phone = isset( $data['phone'] ) ? $data['phone'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_latitude_from_api( $data ) {

		$this->latitude = isset( $data['location']['latitude'] ) ? $data['location']['latitude'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_longitude_from_api( $data ) {

		$this->longitude = isset( $data['location']['longitude'] ) ? $data['location']['longitude'] : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_street_address_from_api( $data ) {

		$this->street_address = isset( $data['location']['street'] ) ? $data['location']['street'] : '';

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

		$this->postal_code = isset( $data['location']['zip'] ) ? $data['location']['zip'] : '';

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
