<?php
/**
 * Defines the Google_Places_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Google Places API.
 *
 * @since 0.1.0
 */
class Google_Places_Request extends Request {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'google_places';

	/**
	 * Google Places API key.
	 *
	 * @since 0.1.0
	 * @var string $key
	 */
	private $key;

	/**
	 * Instantiates the Google_Places_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Google Places API key.
	 */
	public function __construct( $key ) {
		$this->key = $key;
	}

	/**
	 * Tests the connection to the API with a sample search request.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if connection was successful, false otherwise.
	 */
	public function is_connected() {
		$response = $this->search( 'PNC Park', 'Pittsburgh' );

		if ( isset( $response['status'] ) && 'REQUEST_DENIED' === $response['status'] ) {
			return false;
		} else {
			return true;
		}
	}

	/**
	 * Searches review sources based on search terms and location.
	 *
	 * @since 0.1.0
	 *
	 * @param string $terms    The search terms, usually a business name.
	 * @param string $location The location within which to search.
	 * @return array Array containing normalized review sources.
	 */
	public function search_review_source( $terms, $location ) {
		$review_sources = array();
		$query = trim( implode( array( $terms, $location ), ' ' ) );
		$url = add_query_arg(
			array(
				'query' => $query,
				'key'   => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/textsearch/json'
		);

		$response = $this->get( $url );

		if ( isset( $response['results'] ) ) {
			foreach( $response['results'] as $review_source ) {
				$review_sources[] = $this->normalize_review_source( $review_source );
			}
		} else {
			return new \WP_Error( 'invalid_response_structure', __( 'Response could not be normalized due to invalid response structure.', 'wp-business-reviews' ) );
		}
		return $review_sources;
	}

	/**
	 * Retrieves review source details based on Google Place ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Google Place ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_review_source( $id ) {
		$url = add_query_arg(
			array(
				'place_id' => $id,
				'key'      => $this->key,
			),
			'https://maps.googleapis.com/maps/api/place/details/json'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Normalizes and sanitize a raw review source from the platform API.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review_source Review source data from platform API.
	 *
	 * @return array|WP_Error Standardized review source properties or WP_Error
	 *                        if response structure is invalid.
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r = $raw_review_source;
		$r_clean = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['id'] ) ) {
			$r_clean['platform_id'] =  $this->clean( $r['id'] );
		}

		// Set name.
		if ( isset( $r['name'] ) ) {
			$r_clean['name'] =  $this->clean( $r['name'] );
		}

		// Set page URL.
		if ( isset( $r['url'] ) ) {
			$r_clean['url'] = $this->clean( $r['url'] );
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$r_clean['rating'] = $this->clean( $r['rating'] );
		}

		// Set icon.
		if ( isset( $r['icon'] ) ) {
			$r_clean['icon'] = $this->clean( $r['icon'] );
		}

		// Set image.
		if ( isset( $r['photos'][0]['photo_reference'] ) ) {
			$photo_reference = $this->clean( $r['photos'][0]['photo_reference'] );
			$r_clean['image'] = $this->build_image( $photo_reference );
		}

		// Set phone.
		if ( isset( $r['formatted_phone_number'] ) ) {
			$r_clean['phone'] =  $this->clean( $r['formatted_phone_number'] );
		}

		// Set display address.
		if ( isset( $r['formatted_address'] ) ) {
			$r_clean['display_address'] =  $this->clean( $r['formatted_address'] );
		}

		// Set address properties.
		if ( isset( $r['address_components'] ) ) {
			// Parse address components per Google Places' unique format.
			$address_components = $this->parse_address_components( $r['address_components'] );

			// Build street address since it is not provided as a single field.
			$r_clean['street_address'] = $this->build_street_address( $address_components );

			if ( isset( $address_components['city'] ) ) {
				$r_clean['city'] = sanitize_text_field( $address_components['city'] );
			}

			if ( isset( $address_components['state_province'] ) ) {
				$r_clean['state_province'] = sanitize_text_field( $address_components['state_province'] );
			}

			if ( isset( $address_components['postal_code'] ) ) {
				$r_clean['postal_code'] = sanitize_text_field( $address_components['postal_code'] );
			}

			if ( isset( $address_components['country'] ) ) {
				$r_clean['country'] = sanitize_text_field( $address_components['country'] );
			}
		}

		// Set latitude.
		if ( isset( $r['geometry']['location']['lat'] ) ) {
			$r_clean['latitude'] = $this->clean( $r['geometry']['location']['lat'] );
		}

		// Set longitude.
		if ( isset( $r['geometry']['location']['lng'] ) ) {
			$r_clean['latitude'] = $this->clean( $r['geometry']['location']['lng'] );
		}

		// Merge clean response values with default values in case any values were not provided.
		$review_source = $this->args = wp_parse_args( $r_clean, $this->get_review_source_defaults() );

		return $review_source;
	}

	/**
	 * Build image URL from photo reference in Google Places API response.
	 *
	 * @since 0.1.0
	 *
	 * @param string $photo_reference Reference to first photo in API response.
	 * @return string|null URL of the business image.
	 */
	protected function build_image( $photo_reference ) {
		$image = add_query_arg( array(
			'maxheight'      => '192',
			'photoreference' => $photo_reference,
			'key'            => $this->key,
		), 'https://maps.googleapis.com/maps/api/place/photo' );

		return $image;
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
	 *
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

	/**
	 * Build street address from Google Places API address components.
	 *
	 * @since 0.1.0
	 *
	 * @param array $address_components Address parts organized by type.
	 * @return string Street address where the business is located.
	 */
	protected function build_street_address( $address_components ) {
		$street_number  = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route          = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise     = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';
		$street_address = $street_number . $route . $subpremise;

		return $street_address;
	}
}
