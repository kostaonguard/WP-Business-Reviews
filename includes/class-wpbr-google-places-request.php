<?php

/**
 * Defines the WPBR_Google_Places_Request subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Requests data from the Google Places API.
 *
 * @since 1.0.0
 * @see WPBR_Request
 */
class WPBR_Google_Places_Request extends WPBR_Request {

	/**
	 * Reviews platform used in the request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'google_places';

	/**
	 * API host used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_host = 'https://maps.googleapis.com';

	/**
	 * URL path used for Google Place requests.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_path = '/maps/api/place/details/json';

	/**
	 * API key used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $api_key;

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	public function __construct( $business_id ) {
		$this->business_id = $business_id;
		// TODO: Get API key from database instead of using constant.
		$this->api_key     = GOOGLE_PLACES_API_KEY;
	}

	/**
	 * Requests business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Business data or WP_Error on failure.
	 */
	public function request_business() {
		// Define URL parameters of the request URL.
		$url_params = array(
			'placeid' => $this->business_id,
			'key'     => $this->api_key,
		);

		// Request data from remote API.
		$response = $this->request( $this->business_path, $url_params );

		return $response;
	}

	/**
	 * Requests reviews data from remote API.
	 *
	 * Since Google Places API returns business and reviews data together, the
	 * business request logic can be reused to access reviews.
	 *
	 * @since 1.0.0
	 *
	 * @return array|WP_Error Reviews data or WP_Error on failure.
	 */
	public function request_reviews() {
		return $this->request_business();
	}

	/**
	 * Standardize business response.
	 *
	 * @since 1.0.0
	 * @see WPBR_Business
	 *
	 * @param array $response Business data from remote API.
	 *
	 * @return array|WP_Error Standardized business properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_business( array $response ) {
		if ( ! isset( $response['result'] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		} else {
			$r = $response['result'];
		}

		// Set defaults.
		$business = array(
			'platform'      => $this->platform,
			'business_id'   => $this->business_id,
			'business_name' => null,
			'meta'          => array(
				'page_url'       => null,
				'image_url'      => null,
				'rating'         => null,
				'phone'          => null,
				'street_address' => null,
				'city'           => null,
				'state_province' => null,
				'postal_code'    => null,
				'country'        => null,
				'latitude'       => null,
				'longitude'      => null,
			),
		);

		// Set business name.
		if ( isset( $r['name'] ) ) {
			$business['business_name'] = sanitize_text_field( $r['name'] );
		}

		// Set page URL.
		if (
			isset( $r['url'] )
			&& filter_var( $r['url'], FILTER_VALIDATE_URL )
		) {
			$business['meta']['page_url'] = $r['url'];
		}

		// Set image URL.
		if ( isset( $r['photos'][0]['photo_reference'] ) ) {
			$photo_reference = sanitize_text_field( $r['photos'][0]['photo_reference'] );
			$business['meta']['image_url'] = $this->build_image_url( $photo_reference );
		}

		// Set rating.
		if (
			isset( $r['rating'] )
			&& is_numeric( $r['rating'] )
		) {
			$business['meta']['rating'] = $r['rating'];
		}

		// Set phone.
		if ( isset( $r['formatted_phone_number'] ) ) {
			$business['meta']['phone'] = sanitize_text_field( $r['formatted_phone_number'] );
		}

		// Set address properties.
		if ( isset( $r['address_components'] ) ) {
			// Parse address components per Google Places' unique format.
			$address_components = $this->parse_address_components( $r['address_components'] );

			// Build street address since it is not provided as a single field.
			$business['meta']['street_address'] = $this->build_street_address( $address_components );

			if ( isset( $address_components['city'] ) ) {
				$business['meta']['city'] = sanitize_text_field( $address_components['city'] );
			}

			if ( isset( $address_components['state_province'] ) ) {
				$business['meta']['state_province'] = sanitize_text_field( $address_components['state_province'] );
			}

			if ( isset( $address_components['postal_code'] ) ) {
				$business['meta']['postal_code'] = sanitize_text_field( $address_components['postal_code'] );
			}

			if ( isset( $address_components['country'] ) ) {
				$business['meta']['country'] = sanitize_text_field( $address_components['country'] );
			}
		}

		// Set latitude.
		if (
			isset( $r['geometry']['location']['lat'] )
			&& is_float( $r['geometry']['location']['lat'] )
		) {
			$business['meta']['latitude'] = sanitize_text_field( $r['geometry']['location']['lat'] );
		}

		// Set longitude.
		if (
			isset( $r['geometry']['location']['lng'] )
			&& is_float( $r['geometry']['location']['lng'] )
		) {
			$business['meta']['longitude'] = sanitize_text_field( $r['geometry']['location']['lng'] );
		}

		return $business;
	}

	/**
	 * Standardizes reviews response for a set of reviews.
	 *
	 * @since 1.0.0
	 *
	 * @param array $response Reviews data from remote API.
	 *
	 * @return array|WP_Error Standardized review properties or WP_Error if
	 *                        response structure does not meet expectations.
	 */
	public function standardize_reviews( array $response ) {
		if ( ! isset( $response['result']['reviews'] ) ) {
			return new WP_Error( 'invalid_response_structure', __( 'Response could not be standardized.', 'wpbr' ) );
		}

		// Initialize array to store standardized properties.
		$reviews = array();

		// Loop through reviews and standardize properties.
		foreach ( $response['result']['reviews'] as $r ) {
			// Set defaults.
			$review = array(
				'review_title'       => null,
				'review_text'        => null,
				'meta'               => array(
					'review_url'         => null,
					'reviewer_name'      => null,
					'reviewer_image_url' => null,
					'rating'             => null,
					'time_created'       => null,
				),
			);

			// Set review text.
			if ( isset( $r['text'] ) ) {
				$review['review_text'] = sanitize_text_field( $r['text'] );
			}

			// Set review URL.
			if (
				isset( $r['author_url'] )
				&& filter_var( $r['author_url'], FILTER_VALIDATE_URL )
			) {
				$review['meta']['review_url'] = $this->build_review_url( $r['author_url'] );
			}

			// Set reviewer name.
			if ( isset( $r['author_name'] ) ) {
				$review['meta']['reviewer_name'] = sanitize_text_field( $r['author_name'] );
			}

			// Set reviewer image URL.
			if (
				isset( $r['profile_photo_url'] )
				&& filter_var( $r['profile_photo_url'], FILTER_VALIDATE_URL )
			) {
				$review['meta']['reviewer_image_url'] = $r['profile_photo_url'];
			}

			// Set rating.
			if (
				isset( $r['rating'] )
				&& is_numeric( $r['rating'] )
			) {
				$review['meta']['rating'] = $r['rating'];
			}

			// Set time created.
			if ( isset( $r['time'] ) ) {
				$review['meta']['time_created'] = intval( $r['time'] );
			}

			$reviews[] = $review;
		}

		return $reviews;
	}

	/**
	 * Build image URL from photo reference in Google Places API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $photo_reference Reference to first photo in API response.
	 *
	 * @return string|null URL of the business image.
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
			return null;
		}
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
	 * @since 1.0.0
	 *
	 * @param array $address_components Address parts organized by type.
	 *
	 * @return string Street address where the business is located.
	 */
	protected function build_street_address( $address_components ) {
		$street_number  = isset( $address_components['street_number'] ) ? $address_components['street_number'] . ' ' : '';
		$route          = isset( $address_components['route'] ) ? $address_components['route'] : '';
		$subpremise     = isset( $address_components['subpremise'] ) ? ' #' . $address_components['subpremise'] : '';
		$street_address = $street_number . $route . $subpremise;

		return $street_address;
	}

	/**
	 * Build Google Places review URL from author URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $author_url Author URL returned by the API.
	 *
	 * @return string URL to a single Google Places review.
	 */
	protected function build_review_url( $author_url ) {
		if (
			! empty( $author_url )
			&& filter_var( $author_url, FILTER_VALIDATE_URL )
		) {
			// Parse reviewer ID to use when building the review URL.
			preg_match( '/contrib\/(.+)\/reviews/', $author_url, $matches );
			$reviewer_id = $matches[1];

			// Build review URL.
			return "https://www.google.com/maps/contrib/{$reviewer_id}/place/$this->business_id";
		}
	}
}
