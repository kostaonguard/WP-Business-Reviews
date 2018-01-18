<?php
/**
 * Defines the Response_Normalizer_Abstract class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a remote API response.
 *
 * @since 0.1.0
 */
abstract class Response_Normalizer_Abstract {
	/**
	 * Platform ID.
	 *
	 * @since 0.1.0
	 * @var string $platform
	 */
	protected $platform;

	/**
	 * Normalizes and sanitizes a raw review source from the platform API.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review_source Review source data from platform API.
	 * @return array Normalized review source.
	 */
	abstract public function normalize_review_source( array $raw_review_source );

	/**
	 * Normalizes and sanitizes multiple review sources.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review_sources Collection of raw review sources.
	 * @return array Collection of normalized review sources.
	 */
	public function normalize_review_sources( array $raw_review_sources ) {
		$normalized = array();

		foreach ( $raw_review_sources as $raw_review_source ) {
			$normalized[] = $this->normalize_review_source( $raw_review_source );
		}

		return $normalized;
	}

	/**
	 * Normalizes and sanitizes a raw review from the platform API.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review Review data from platform API.
	 * @return array Normalized review.
	 */
	abstract public function normalize_review( array $raw_review );

	/**
	 * Normalizes and sanitizes multiple reviews.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_reviews Collection of raw review data.
	 * @return array Collection of normalized reviews.
	 */
	public function normalize_reviews( array $raw_reviews ) {
		$normalized = array();

		foreach ( $raw_reviews as $raw_review ) {
			$normalized[] = $this->normalize_review( $raw_review );
		}

		return $normalized;
	}

	/**
	 * Retrieves default values for a normalized review source.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of default values.
	 */
	protected function get_review_source_defaults() {
		return array(
			'platform'          => $this->platform,
			'review_source_id'  => null,
			'name'              => null,
			'url'               => null,
			'rating'            => 0,
			'icon'              => null,
			'image'             => null,
			'phone'             => null,
			'formatted_address' => null,
			'street_address'    => null,
			'city'              => null,
			'state_province'    => null,
			'postal_code'       => null,
			'country'           => null,
			'latitude'          => null,
			'longitude'         => null,
		);
	}

	/**
	 * Retrieves default values for a normalized review.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of default values.
	 */
	protected function get_review_defaults() {
		return array(
			'platform'       => $this->platform,
			'reviewer'       => null,
			'reviewer_image' => null,
			'rating'         => 0,
			'timestamp'      => null,
			'content'        => null,
		);
	}

	/**
	 * Recursively sanitizes a given value.
	 *
	 * @param string|array $value The value to be sanitized.
	 * @return string|array Array of clean values or single clean value.
	 */
	protected function clean( $value ) {
		if ( is_array( $value ) ) {
			return array_map( array( $this, 'clean' ), $value );
		} else {
			return is_scalar( $value ) ? sanitize_text_field( $value ) : '';
		}
	}
}
