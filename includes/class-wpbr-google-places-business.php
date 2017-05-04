<?php

/**
 * Defines the WPBR_Google_Places_Business subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object for Google Places.
 *
 * @since 1.0.0
 * @see WPBR_Business
 */
class WPBR_Google_Places_Business extends WPBR_Business {

	/**
	 * Sets properties from remote API.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		// Call the API.
		$api_call = new WPBR_Google_Places_API_Call( $this->business_id );

		// Get JSON-decoded response body.
		$body = $api_call->get_response_body();

		// Set properties from API response.
		$this->set_name_from_api( $body );
		$this->set_platform_url_from_api( $body );
		$this->set_image_url_from_api( $body );
		$this->set_rating_from_api( $body );
		$this->set_phone_from_api( $body );
		$this->set_latitude_from_api( $body );
		$this->set_longitude_from_api( $body );

		/**
		 * Setting address properties from the Google Places API requires
		 * special parsing because of the unique and unpredictable format in
		 * which it returns address components.
		 */

		// Parse address components into a more reliable format.
		$address_components = $this->parse_address_components( $body['result']['address_components'] );

		// Set properties from parsed address components.
		$this->set_street_address_from_api( $address_components );
		$this->set_city_from_api( $address_components );
		$this->set_state_province_from_api( $address_components );
		$this->set_country_from_api( $address_components );
		$this->set_postal_code_from_api( $address_components );

	}

	/**
	 * Parse address components specific to the Google Places address format.
	 *
	 * The Google Places API response does not always include the same number
	 * of address components in the same order, so they need parsed by type
	 * before constructing the full address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts that form a full address.
	 * @return array Address parts organized by type.
	 */
	protected function parse_address_components( $address_components ) {

		$parsed_components = array();

		foreach ( $address_components as $component ) {

			switch ( $component['types'][0] ) {

				case 'subpremise' :
					$parsed_components['subpremise'] = $component['short_name'];
					break;

				case 'street_number' :
					$parsed_components['street_number'] = $component['short_name'];
					break;

				case 'route' :
					$parsed_components['route'] = $component['short_name'];
					break;

				case 'locality' :
					$parsed_components['city'] = $component['short_name'];
					break;

				case 'administrative_area_level_1' :
					$parsed_components['state_province'] = $component['short_name'];
					break;

				case 'country' :
					$parsed_components['country'] = $component['short_name'];
					break;

				case 'postal_code' :
					$parsed_components['postal_code'] = $component['short_name'];
					break;

			}

		}

		return $parsed_components;

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_name_from_api( $body ) {

		$this->name = isset( $body['result']['name'] ) ? $body['result']['name'] : '';

	}

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_platform_url_from_api( $body ) {

		$this->platform_url = isset( $body['result']['url'] ) ? $body['result']['url'] : '';

	}

	/**
	 * Set rating from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_rating_from_api( $body ) {

		$this->rating = isset( $body['result']['rating'] ) ? $body['result']['rating'] : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_rating_count_from_api( $body ) {

		// Google Places API does not include rating count.
		$this->rating_count = '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_phone_from_api( $body ) {

		$this->phone = isset( $body['result']['formatted_phone_number'] ) ? $body['result']['formatted_phone_number'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_latitude_from_api( $body ) {

		$this->latitude = isset( $body['result']['geometry']['location']['lat'] ) ? $body['result']['geometry']['location']['lat'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_longitude_from_api( $body ) {

		$this->longitude = isset( $body['result']['geometry']['location']['lng'] ) ? $body['result']['geometry']['location']['lng'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $body JSON-decoded response body.
	 */
	protected function set_image_url_from_api( $body ) {

		$photoreference = isset( $body['result']['photos'][0]['photo_reference'] ) ? $body['result']['photos'][0]['photo_reference'] : '';

		if ( ! empty( $photoreference ) ) {

			$this->image_url = add_query_arg( array(

				'maxheight'      => '192',
				'photoreference' => $photoreference,
				'key'            => GOOGLE_PLACES_API_KEY,

			), 'https://maps.googleapis.com/maps/api/place/photo' );

		}

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 */
	protected function set_street_address_from_api( $address_components ) {

		$street_number = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route         = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise    = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';

		$this->street_address = $street_number . $route . $subpremise;

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 */
	protected function set_city_from_api( $address_components ) {

		$this->city = isset( $address_components['city'] ) ? $address_components['city'] : '';

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 */
	protected function set_state_province_from_api( $address_components ) {

		$this->state_province = isset( $address_components['state_province'] ) ? $address_components['state_province'] : '';

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 */
	protected function set_postal_code_from_api( $address_components ) {

		$this->postal_code = isset( $address_components['postal_code'] ) ? $address_components['postal_code'] : '';

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 */
	protected function set_country_from_api( $address_components ) {

		$this->country = isset( $address_components['country'] ) ? $address_components['country'] : '';

	}

}
