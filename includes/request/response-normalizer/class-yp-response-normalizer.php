<?php
/**
 * Defines the YP_Response_Normalizer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a YP API response.
 *
 * @since 0.1.0
 */
class YP_Response_Normalizer extends Response_Normalizer_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'yp';

	/**
	 * @inheritDoc
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r          = $raw_review_source;
		$normalized = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['listingId'] ) ) {
			$normalized['review_source_id'] = $this->clean( $r['listingId'] );
		}

		// Set name.
		if ( isset( $r['businessName'] ) ) {
			$normalized['name'] = $this->clean( $r['businessName'] );
		}

		// Set page URL.
		if ( isset( $r['businessNameURL'] ) ) {
			$normalized['url'] = $this->clean( $r['businessNameURL'] );
		}

		// Set rating.
		if ( isset( $r['averageRating'] ) ) {
			$normalized['rating'] = $this->clean( $r['averageRating'] );
		}

		// Set phone.
		if ( isset( $r['phone'] ) ) {
			$normalized['phone'] = $this->clean( $r['phone'] );
		}

		// Set street address.
		if ( isset( $r['street'] ) ) {
			$normalized['street_address'] = $this->clean( $r['street'] );
		}

		// Set city.
		if ( isset( $r['city'] ) ) {
			$normalized['city'] = $this->clean( $r['city'] );
		}

		// Set state.
		if ( isset( $r['state'] ) ) {
			$normalized['state_province'] = $this->clean( $r['state'] );
		}

		// Set postal code.
		if ( isset( $r['zip'] ) ) {
			$normalized['postal_code'] = $this->clean( $r['zip'] );
		}

		// Set formatted address by concatenating address components.
		if (
			isset(
				$normalized['street_address'],
				$normalized['city'],
				$normalized['state_province'],
				$normalized['postal_code']
			)
		) {
			$normalized['formatted_address'] = $this->format_address(
				$normalized['street_address'],
				$normalized['city'],
				$normalized['state_province'],
				$normalized['postal_code']
			);
		}

		// Set latitude.
		if ( isset( $r['latitude'] ) ) {
			$normalized['latitude'] = $this->clean( $r['latitude'] );
		}

		// Set longitude.
		if ( isset( $r['longitude'] ) ) {
			$normalized['longitude'] = $this->clean( $r['longitude'] );
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
		if ( isset( $r['reviewer'] ) ) {
			$normalized['reviewer'] = $this->clean( $r['reviewer'] );
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set timestamp.
		if ( isset( $r['reviewDate'] ) ) {
			$normalized['timestamp'] = $this->clean( $r['reviewDate'] );
		}

		// Set content.
		if ( isset( $r['reviewBody'] ) ) {
			$normalized['content'] = $this->clean( $r['reviewBody'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_defaults() );

		return $normalized;
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
