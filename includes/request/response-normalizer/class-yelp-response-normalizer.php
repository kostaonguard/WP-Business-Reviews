<?php
/**
 * Defines the Yelp_Response_Normalizer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a Yelp API response.
 *
 * @since 0.1.0
 */
class Yelp_Response_Normalizer extends Response_Normalizer_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'yelp';

	/**
	 * @inheritDoc
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r          = $raw_review_source;
		$normalized = array();

		// Set ID of the review source on the platform.
		if ( isset( $r['id'] ) ) {
			$normalized['review_source_id'] =  $this->clean( $r['id'] );
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

		// Set image.
		if ( isset( $r['image_url'] ) ) {
			$normalized['image'] = $this->modify_image_size( $this->clean( $r['image_url'] ) );
		}

		// Set phone.
		if ( isset( $r['display_phone'] ) ) {
			$normalized['phone'] =  $this->clean( $r['display_phone'] );
		}

		// Set formatted address.
		if ( isset( $r['location']['display_address'] ) ) {
			$normalized['formatted_address'] = $this->format_address( $this->clean( $r['location']['display_address'] ) );
		}

		// Set street address.
		if ( isset( $r['location']['address1'] ) ) {
			$normalized['street_address'] = $this->clean( $r['location']['address1'] );
		}

		// Set city.
		if ( isset( $r['location']['city'] ) ) {
			$normalized['city'] = $this->clean( $r['location']['city'] );
		}

		// Set state.
		if ( isset( $r['location']['state'] ) ) {
			$normalized['state_province'] = $this->clean( $r['location']['state'] );
		}

		// Set postal code.
		if ( isset( $r['location']['zip_code'] ) ) {
			$normalized['postal_code'] = $this->clean( $r['location']['zip_code'] );
		}

		// Set country.
		if ( isset( $r['location']['country'] ) ) {
			$normalized['country'] = $this->clean( $r['location']['country'] );
		}

		// Set latitude.
		if ( isset( $r['coordinates']['latitude']) ) {
			$normalized['latitude'] = $this->clean( $r['coordinates']['latitude'] );
		}

		// Set longitude.
		if ( isset( $r['coordinates']['longitude']) ) {
			$normalized['longitude'] = $this->clean( $r['coordinates']['longitude'] );
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
		if ( isset( $r['user']['name'] ) ) {
			$normalized['reviewer'] = $this->clean( $r['user']['name'] );
		}

		// Set image.
		if ( isset( $r['user']['image_url'] ) ) {
			$normalized['image'] = $this->modify_image_size(
				$this->clean( $r['user']['image_url'] )
			);
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set timestamp.
		if ( isset( $r['time_created'] ) ) {
			$normalized['timestamp'] = $this->clean( $r['time_created'] );
		}

		// Set content.
		if ( isset( $r['text'] ) ) {
			$normalized['content'] = $this->clean_multiline( $r['text'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_defaults() );

		return $normalized;
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
