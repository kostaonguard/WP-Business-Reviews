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
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		// Request business details from API.
		$request = new WPBR_YP_Request( $this->business_id );
		$data    = $request->request_business();

		// Set properties from API response.
		$this->set_name_from_api( $data );
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

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_name_from_api( $data ) {

		$this->name = isset( $data['businessName'] ) ? $data['businessName'] : '';

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_platform_url_from_api( $data ) {

		$this->platform_url = isset( $data['moreInfoURL'] ) ? $data['moreInfoURL'] : '';

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

		$this->rating = isset( $data['averageRating'] ) ? $data['averageRating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_rating_count_from_api( $data ) {

		$this->rating_count = isset( $data['ratingCount'] ) ? $data['ratingCount'] : '';

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

		$this->latitude = isset( $data['latitude'] ) ? $data['latitude'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_longitude_from_api( $data ) {

		$this->longitude = isset( $data['longitude'] ) ? $data['longitude'] : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_street_address_from_api( $data ) {

		$this->street_address = isset( $data['street'] ) ? $data['street'] : '';

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_city_from_api( $data ) {

		$this->city = isset( $data['city'] ) ? $data['city'] : '';

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_state_province_from_api( $data ) {

		$this->state_province = isset( $data['state'] ) ? $data['state'] : '';

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_postal_code_from_api( $data ) {

		$this->postal_code = isset( $data['zip'] ) ? $data['zip'] : '';

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_country_from_api( $data ) {

		// YP API does not include country.
		$this->country = '';

	}

}
