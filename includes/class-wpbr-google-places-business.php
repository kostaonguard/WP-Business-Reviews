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
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'google_places';

	/**
	 * Standardizes data from the remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	protected function standardize_response( $data ) {

		// Define variables that need special handling for this API.
		$image_url = '';
		$address_components = array();

		// Build image URL if photo reference is available.
		if ( isset( $data['photos'][0]['photo_reference'] ) ) {

			$photo_reference = sanitize_text_field( $data['photos'][0]['photo_reference'] );
			$image_url       = $this->build_image_url( $photo_reference );

		}

		// Prepare address components.
		if ( isset( $data['address_components'] ) ) {

			// Parse address components per Google Places' unique format.
			$address_components = $this->parse_address_components( $data['address_components'] );

			// Build street address.
			$street_address = $this->build_street_address( $address_components );

		}

		// Standardize data to match class properties.
		$standardized_data = array(

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

		return $standardized_data;

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
	 *
	 * @return array Address parts organized by type.
	 */
	protected function parse_address_components( $address_components ) {

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
	 * Build image URL from photo reference in Google Places API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $photo_reference Reference to first photo in API response.
	 *
	 * @return string URL of the business image.
	 */
	protected function build_image_url( $photo_reference ) {

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
	 * Build street address from Google Places API address components.
	 *
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 *
	 * @return string Street address where the business is located.
	 */
	protected function build_street_address( $address_components ) {

		$street_number = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route         = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise    = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';

		$street_address = $street_number . $route . $subpremise;

		return $street_address;

	}

}
