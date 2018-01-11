<?php
/**
 * Defines the Yelp_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from Yelp Fusion API.
 *
 * @since 0.1.0
 */
class Yelp_Request extends Request {
	/**
	 * Instantiates the Yelp_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Yelp Fusion API key.
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

		if ( isset( $response['error'] ) ) {
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
		$url = add_query_arg(
			array(
				'term'     => $terms,
				'location' => $location,
				'limit'    => 10,
			),
			'https://api.yelp.com/v3/businesses/search'
		);

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		if ( isset( $response['businesses'] ) ) {
			foreach( $response['businesses'] as $review_source ) {
				$review_sources[] = $this->normalize_review_source( $review_source );
			}
		} else {
			return new \WP_Error( 'invalid_response_structure', __( 'Response could not be normalized due to invalid response structure.', 'wp-business-reviews' ) );
		}

		return $review_sources;
	}

	/**
	 * Retrieves business details based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_business( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id;

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Normalizes and sanitize a raw review source from the platform API.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review_source Review source data from platform API.
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

		// Set image.
		if ( isset( $r['image_url'] ) ) {
			$r_clean['image'] = $this->modify_image_size( $this->clean( $r['image_url'] ) );
		}

		// Set phone.
		if ( isset( $r['display_phone'] ) ) {
			$r_clean['phone'] =  $this->clean( $r['display_phone'] );
		}

		// Set formatted address.
		if ( isset( $r['location']['display_address'] ) ) {
			$r_clean['formatted_address'] = $this->format_address( $this->clean( $r['location']['display_address'] ) );
		}

		// Set street address.
		if ( isset( $r['location']['address1'] ) ) {
			$r_clean['street_address'] = $this->clean( $r['location']['address1'] );
		}

		// Set city.
		if ( isset( $r['location']['city'] ) ) {
			$r_clean['city'] = $this->clean( $r['location']['city'] );
		}

		// Set state.
		if ( isset( $r['location']['state'] ) ) {
			$r_clean['state_province'] = $this->clean( $r['location']['state'] );
		}

		// Set postal code.
		if ( isset( $r['location']['zip_code'] ) ) {
			$r_clean['postal_code'] = $this->clean( $r['location']['zip_code'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$r_clean['country'] = $this->clean( $r['location']['country'] );
		}

		// Set latitude.
		if ( isset( $r['coordinates']['latitude']) ) {
			$r_clean['latitude'] = $this->clean( $r['coordinates']['latitude'] );
		}

		// Set longitude.
		if ( isset( $r['coordinates']['longitude']) ) {
			$r_clean['longitude'] = $this->clean( $r['coordinates']['longitude'] );
		}

		// Merge clean response values with default values in case any values were not provided.
		$review_source = $this->args = wp_parse_args( $r_clean, $this->get_review_source_defaults() );

		return $review_source;
	}

	/**
	 * Retrieves reviews based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_reviews( $id ) {
		$url = 'https://api.yelp.com/v3/businesses/' . $id . '/reviews';

		$args = array(
			'user-agent'     => '',
			'headers' => array(
				'authorization' => 'Bearer ' . $this->key,
			),
		);

		$response = $this->get( $url, $args );

		return $response;
	}

	/**
	 * Modify the image URL from API response.
	 *
	 * The image returned by the Yelp Fusion API is 1000px wide, which is
	 * unnecessarily big for this plugin's purposes. Changing the suffix
	 * results in a more appropriate size.
	 *
	 * @since 0.1.0
	 *
	 * @param string $image Image URL.
	 * @return string Modified image URL.
	 */
	protected function modify_image_size( $image ) {
		return str_replace( 'o.jpg', 'l.jpg', $image );
	}

	/**
	 * Formats address from separate address components.
	 *
	 * @since 0.1.0
	 *
	 * @param array $address_components Associative array of address strings.
	 * @return string Formatted address.
	 */
	protected function format_address( $address_components ) {
		return trim( implode( $address_components, ', ' ) );
	}
}
