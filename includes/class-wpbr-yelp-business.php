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
	 * Sets properties from remote API call.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		// Call the API.
		$api_call = new WPBR_Yelp_Business_API_Call( $this->business_id );

		// Get JSON-decoded response.
		$body = $api_call->get_response_body();

		// Set properties from API response.
		$this->set_name_from_api( $body );
		$this->set_platform_url_from_api( $body );
		$this->set_image_url_from_api( $body );
		$this->set_rating_from_api( $body );
		$this->set_rating_count_from_api( $body );
		$this->set_phone_from_api( $body );
		$this->set_latitude_from_api( $body );
		$this->set_longitude_from_api( $body );
		$this->set_street_address_from_api( $body );
		$this->set_city_from_api( $body );
		$this->set_state_province_from_api( $body );
		$this->set_postal_code_from_api( $body );
		$this->set_country_from_api( $body );

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_name_from_api( $body ) {

		$this->name = isset( $body['name'] ) ? $body['name'] : '';

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_platform_url_from_api( $body ) {

		$this->platform_url = isset( $body['url'] ) ? $body['url'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_image_url_from_api( $body ) {

		$image_url_original = isset( $body['image_url'] ) ? $body['image_url'] : '';

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
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_rating_from_api( $body ) {

		$this->rating = isset( $body['rating'] ) ? $body['rating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_rating_count_from_api( $body ) {

		$this->rating_count = isset( $body['review_count'] ) ? $body['review_count'] : '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_phone_from_api( $body ) {

		$this->phone = isset( $body['display_phone'] ) ? $body['display_phone'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_latitude_from_api( $body ) {

		$this->latitude = isset( $body['coordinates']['latitude'] ) ? $body['coordinates']['latitude'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_longitude_from_api( $body ) {

		$this->longitude = isset( $body['coordinates']['longitude'] ) ? $body['coordinates']['longitude'] : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_street_address_from_api( $body ) {

		$this->street_address = isset( $body['location']['address1'] ) ? $body['location']['address1'] : '';

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_city_from_api( $body ) {

		$this->city = isset( $body['location']['city'] ) ? $body['location']['city'] : '';

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_state_province_from_api( $body ) {

		$this->state_province = isset( $body['location']['state'] ) ? $body['location']['state'] : '';

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_postal_code_from_api( $body ) {

		$this->postal_code = isset( $body['location']['zip_code'] ) ? $body['location']['zip_code'] : '';

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_country_from_api( $body ) {

		$this->country = isset( $body['location']['country'] ) ? $body['location']['country'] : '';

	}

}
