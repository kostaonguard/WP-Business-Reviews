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
	 * Standardizes business properties from the remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Business portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	public function standardize_properties( $data ) {

		// Build image URL.
		$image_url = '';

		if ( isset( $data['photos'][0]['photo_reference'] ) ) {

			$image_url = $this->build_image_url( $data['photos'][0]['photo_reference'] );

		}

		// Prepare address components.
		$address_components = array();
		$street_address = null;

		if ( isset( $data['address_components'] ) ) {

			// Parse address components per Google Places' unique format.
			$address_components = $this->parse_address_components( $data['address_components'] );

			// Build street address.
			$street_address = $this->build_street_address( $address_components );

		}

		// Standardize data to match class properties.
		$properties = array(

			'business_name'  => isset( $data['name'] ) ? $data['name'] : null,
			'page_url'       => isset( $data['url'] ) ? $data['url'] : null,
			'image_url'      => $image_url,
			'rating'         => isset( $data['rating'] ) ? $data['rating'] : null,
			'rating_count'   => null, // Unavailable.
			'phone'          => isset( $data['formatted_phone_number'] ) ? $data['formatted_phone_number'] : null,
			'street_address' => $street_address,
			'city'           => isset( $address_components['city'] ) ? $address_components['city'] : null,
			'state_province' => isset( $address_components['state_province'] ) ? $address_components['state_province'] : null,
			'postal_code'    => isset( $address_components['postal_code'] ) ? $address_components['postal_code'] : null,
			'country'        => isset( $address_components['country'] ) ? $address_components['country'] : null,
			'latitude'       => isset( $data['geometry']['location']['lat'] ) ? $data['geometry']['location']['lat'] : null,
			'longitude'      => isset( $data['geometry']['location']['lng'] ) ? $data['geometry']['location']['lng'] : null,

		);

		return $properties;

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
