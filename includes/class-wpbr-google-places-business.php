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
	 * Format properties from remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business.
	 *
	 * @return array Array of formatted properties.
	 */
	protected function format_properties_from_api( $business_id ) {

		// Request business details from API.
		$request = new WPBR_Google_Places_Request( $business_id );
		$data    = $request->request_business();

		// Format image URL.
		$photo_reference = sanitize_text_field( $data['photos'][0]['photo_reference'] );
		$image_url       = $this->format_image_url( $photo_reference );

		// Parse address components per Google Places' unique format.
		$address_components = $this->format_address_components( $data['address_components'] );

		// Format street address.
		$street_address = $this->format_street_address( $address_components );

		// Prepare properties to be set.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : '',
			'platform_url'   => isset( $data['url'] ) ? $data['url'] : '',
			'image_url'      => $image_url,
			'rating'         => isset( $data['rating'] ) ? $data['rating'] : '',
			'rating_count'   => '', // Unavailable.
			'phone'          => isset( $data['formatted_phone_number'] ) ? $data['formatted_phone_number'] : '',
			'latitude'       => isset( $data['geometry']['location']['lat'] ) ? $data['geometry']['location']['lat'] : '',
			'longitude'      => isset( $data['geometry']['location']['lng'] ) ? $data['geometry']['location']['lng'] : '',
			'street_address' => $street_address,
			'city'           => isset( $address_components['city'] ) ? $address_components['city'] : '',
			'state_province' => isset( $address_components['state_province'] ) ? $address_components['state_province'] : '',
			'postal_code'    => isset( $address_components['postal_code'] ) ? $address_components['postal_code'] : '',
			'country'        => isset( $address_components['country'] ) ? $address_components['country'] : '',

		);

		return $properties;

	}

	/**
	 * Format address components specific to the Google Places address format.
	 *
	 * The Google Places API response does not always include the same number
	 * of address components in the same order, so they need formatted by type
	 * before constructing the full address.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts that form a full address.
	 *
	 * @return array Address parts organized by type.
	 */
	protected function format_address_components( $address_components ) {

		$formatted_components = array();

		foreach ( $address_components as $component ) {

			switch ( $component['types'][0] ) {

				case 'subpremise' :
					$formatted_components['subpremise'] = $component['short_name'];
					break;

				case 'street_number' :
					$formatted_components['street_number'] = $component['short_name'];
					break;

				case 'route' :
					$formatted_components['route'] = $component['short_name'];
					break;

				case 'locality' :
					$formatted_components['city'] = $component['short_name'];
					break;

				case 'administrative_area_level_1' :
					$formatted_components['state_province'] = $component['short_name'];
					break;

				case 'country' :
					$formatted_components['country'] = $component['short_name'];
					break;

				case 'postal_code' :
					$formatted_components['postal_code'] = $component['short_name'];
					break;

			}

		}

		return $formatted_components;

	}

	/**
	 * Format image URL from Google Places API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $photo_reference Reference to first photo in API response.
	 *
	 * @return string $image_url URL of the business image.
	 */
	protected function format_image_url( $photo_reference ) {

		if ( ! empty( $photo_reference ) ) {

			$image_url = add_query_arg( array(

				'maxheight'      => '192',
				'photoreference' => $photo_reference,
				// TODO: Replace GOOGLE_PLACES_API_KEY constant.
				'key'            => GOOGLE_PLACES_API_KEY,

			), 'https://maps.googleapis.com/maps/api/place/photo' );

			return $image_url;

		} else {

			return '';

		}

	}

	/**
	 * Format street address from Google Places API address components.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 *
	 * @return string $street_address Street address where the business is located.
	 */
	protected function format_street_address( $address_components ) {

		$street_number = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route         = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise    = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';

		$street_address = $street_number . $route . $subpremise;

		return $street_address;

	}

}
