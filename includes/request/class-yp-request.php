<?php
/**
 * Defines the YP_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

/**
 * Retrieves data from YP API.
 *
 * @since 0.1.0
 */
class YP_Request extends Request {
	/**
	 * Instantiates the YP_Request object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key YP API key.
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

		if (
			isset( $response['result'] )
			&& isset( $response['result']['metaProperties'] )
			&& isset( $response['result']['metaProperties']['resultCode'] )
			&& 'Failure' === $response['result']['metaProperties']['resultCode']
		) {
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
				'term'  => $terms . ', ' . $location,
				'format' => 'json',
				'key'    => $this->key,
			),
			'http://api2.yp.com/listings/v1/search'
		);

		$response = $this->get( $url );

		if ( isset( $response['searchResult']['searchListings']['searchListing'] ) ) {
			$listings = $response['searchResult']['searchListings']['searchListing'];

			foreach ( $listings as $review_source ) {
				$review_sources[] = $this->normalize_review_source( $review_source );
			}
		} else {
			return new \WP_Error( 'invalid_response_structure', __( 'Response could not be normalized due to invalid response structure.', 'wp-business-reviews' ) );
		}

		return $review_sources;
	}

	/**
	 * Retrieves business details based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_business( $id ) {
		$url = add_query_arg(
			array(
				'listingid' => $id,
				'format'     => 'json',
				'key'        => $this->key,
			),
			'http://api2.yp.com/listings/v1/details'
		);

		$response = $this->get( $url );

		return $response;
	}

	/**
	 * Retrieves reviews based on YP listing ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The YP listing ID.
	 * @return array Associative array containing the response body.
	 */
	public function get_reviews( $id ) {
		$url = add_query_arg(
			array(
				'listingid' => $id,
				'format'     => 'json',
				'key'        => $this->key,
			),
			'http://api2.yp.com/listings/v1/reviews'
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
	 * @return array|WP_Error Standardized review source properties or WP_Error
	 *                        if response structure is invalid.
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r = $raw_review_source;
		$r_clean = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['listingId'] ) ) {
			$r_clean['platform_id'] = $this->clean( $r['listingId'] );
		}

		// Set name.
		if ( isset( $r['businessName'] ) ) {
			$r_clean['name'] = $this->clean( $r['businessName'] );
		}

		// Set page URL.
		if ( isset( $r['businessNameURL'] ) ) {
			$r_clean['url'] = $this->clean( $r['businessNameURL'] );
		}

		// Set rating.
		if ( isset( $r['averageRating'] ) ) {
			$r_clean['rating'] = $this->clean( $r['averageRating'] );
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$r_clean['phone'] = $this->clean( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['street'] ) ) {
			$r_clean['street_address'] = $this->clean( $r['street'] );
		}

		// Set city.
		if ( isset( $r['city'] ) ) {
			$r_clean['city'] = $this->clean( $r['city'] );
		}

		// Set state.
		if ( isset( $r['state'] ) ) {
			$r_clean['state_province'] = $this->clean( $r['state'] );
		}

		// Set postal code.
		if ( isset( $r['zip'] ) ) {
			$r_clean['postal_code'] = $this->clean( $r['zip'] );
		}

		// Set formatted address by concatenating address components.
		if (
			isset(
				$r_clean['street_address'],
				$r_clean['city'],
				$r_clean['state_province'],
				$r_clean['postal_code']
			)
		) {
			$r_clean['formatted_address'] = $this->format_address(
				$r_clean['street_address'],
				$r_clean['city'],
				$r_clean['state_province'],
				$r_clean['postal_code']
			);
		}

		// Set latitude.
		if ( isset( $r['latitude'] ) ) {
			$r_clean['latitude'] = $this->clean( $r['latitude'] );
		}

		// Set longitude.
		if ( isset( $r['longitude'] ) ) {
			$r_clean['longitude'] = $this->clean( $r['longitude'] );
		}

		// Merge clean response values with default values in case any values were not provided.
		$review_source = $this->args = wp_parse_args( $r_clean, $this->get_review_source_defaults() );

		return $review_source;
	}

	/**
	 * Formats address from separate address components.
	 *
	 * @param string $street_address Street address.
	 * @param string $city           City.
	 * @param string $state_province State.
	 * @param string $postal_code    Zip code.
	 * @return string Concatenated, formatted address.
	 */
	protected function format_address( $street_address, $city, $state_province, $postal_code ) {
		return  "{$street_address}, {$city}, {$state_province} {$postal_code}";
	}
}
