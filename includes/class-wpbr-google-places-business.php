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

		// Request business details from API.
		$request = new WPBR_Google_Places_Request( $this->business_id );
		$data    = $request->request_business();
		
		// Set properties from API response.
		$this->set_name_from_api( $data );
		$this->set_platform_url_from_api( $data );
		$this->set_image_url_from_api( $data );
		$this->set_rating_from_api( $data );
		$this->set_phone_from_api( $data );
		$this->set_latitude_from_api( $data );
		$this->set_longitude_from_api( $data );

		/**
		 * Setting address properties from the Google Places API requires
		 * special parsing because of the unique and unpredictable format in
		 * which it returns address components.
		 */

		// Parse address components into a more reliable format.
		$address_components = $this->parse_address_components( $data['address_components'] );

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
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_name_from_api( $data ) {

		$this->name = isset( $data['name'] ) ? $data['name'] : '';

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

		// Google Places API does not include rating count.
		$this->rating_count = '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_phone_from_api( $data ) {

		$this->phone = isset( $data['formatted_phone_number'] ) ? $data['formatted_phone_number'] : '';

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_latitude_from_api( $data ) {

		$this->latitude = isset( $data['geometry']['location']['lat'] ) ? $data['geometry']['location']['lat'] : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_longitude_from_api( $data ) {

		$this->longitude = isset( $data['geometry']['location']['lng'] ) ? $data['geometry']['location']['lng'] : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	protected function set_image_url_from_api( $data ) {

		$photoreference = isset( $data['photos'][0]['photo_reference'] ) ? $data['photos'][0]['photo_reference'] : '';

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
