<?php
/**
 * Defines the Google_Places_Response_Normalizer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a Google Places API response.
 *
 * @since 0.1.0
 */
class Google_Places_Response_Normalizer extends Response_Normalizer_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'google_places';

	/**
	 * @inheritDoc
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r          = $raw_review_source;
		$normalized = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['place_id'] ) ) {
			$normalized['review_source_id'] =  $this->clean( $r['place_id'] );
		}

		// Set name.
		if ( isset( $r['name'] ) ) {
			$normalized['name'] =  $this->clean( $r['name'] );
		}

		// Set page URL.
		if ( isset( $r['url'] ) ) {
			$normalized['url'] = $this->clean( $r['url'] );
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set icon.
		if ( isset( $r['icon'] ) ) {
			$normalized['icon'] = $this->clean( $r['icon'] );
		}

		// Set phone.
		if ( isset( $r['formatted_phone_number'] ) ) {
			$normalized['phone'] =  $this->clean( $r['formatted_phone_number'] );
		}

		// Set formatted address.
		if ( isset( $r['formatted_address'] ) ) {
			$normalized['formatted_address'] =  $this->clean( $r['formatted_address'] );
		}

		// Set address properties.
		if ( isset( $r['address_components'] ) ) {
			// Parse address components per Google Places' unique format.
			$address_components = $this->parse_address_components( $r['address_components'] );

			// Assemble normalized street address since it is not provided as a single field.
			$normalized['street_address'] = $this->normalize_street_address( $address_components );

			if ( isset( $address_components['city'] ) ) {
				$normalized['city'] = sanitize_text_field( $address_components['city'] );
			}

			if ( isset( $address_components['state_province'] ) ) {
				$normalized['state_province'] = sanitize_text_field( $address_components['state_province'] );
			}

			if ( isset( $address_components['postal_code'] ) ) {
				$normalized['postal_code'] = sanitize_text_field( $address_components['postal_code'] );
			}

			if ( isset( $address_components['country'] ) ) {
				$normalized['country'] = sanitize_text_field( $address_components['country'] );
			}
		}

		// Set latitude.
		if ( isset( $r['geometry']['location']['lat'] ) ) {
			$normalized['latitude'] = $this->clean( $r['geometry']['location']['lat'] );
		}

		// Set longitude.
		if ( isset( $r['geometry']['location']['lng'] ) ) {
			$normalized['longitude'] = $this->clean( $r['geometry']['location']['lng'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_source_defaults() );

		return $normalized;
	}

	/**
	 * @inheritDoc
	 */
	public function normalize_review( array $raw_review ) {
		$r          = $raw_review;
		$normalized = array();

		// Set reviewer.
		if ( isset( $r['author_name'] ) ) {
			$normalized['reviewer'] = $this->clean( $r['author_name'] );
		}

		// Set reviewer image.
		if ( isset( $r['profile_photo_url'] ) ) {
			$normalized['reviewer_image'] = $this->clean( $r['profile_photo_url'] );
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set timestamp.
		if ( isset( $r['time'] ) ) {
			$normalized['timestamp'] = $this->clean( $r['time'] );
		}

		// Set content.
		if ( isset( $r['text'] ) ) {
			$normalized['content'] = $this->clean( $r['text'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_defaults() );

		return $normalized;
	}

	/**
	 * Normalize street address from Google Places API address components.
	 *
	 * @since 0.1.0
	 *
	 * @param array $address_components Address parts organized by type.
	 * @return string Street address where the Place is located.
	 */
	protected function normalize_street_address( $address_components ) {
		$street_number  = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route          = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise     = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';
		$street_address = $street_number . $route . $subpremise;

		return $street_address;
	}

	/**
	 * Parse address components specific to the Google Places address format.
	 *
	 * The Google Places API response does not always include the same number
	 * of address components in the same order, so they need parsed by type
	 * before constructing the full address.
	 *
	 * @since 0.1.0
	 *
	 * @param array $address_components Address parts that form a full address.
	 * @return array Address parts organized by type.
	 */
	protected function parse_address_components( array $address_components ) {
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
}
