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
	 * @param array $raw_review_source Raw data from platform API.
	 * @return Review Normalized Review object.
	 */
	abstract public function normalize_review_source( array $raw_review_source );

	/**
	 * Normalizes and sanitizes multiple review sources.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review_sources Raw data from platform API.
	 * @return Review_Source Array of normalized Review_Source objects.
	 */
	public function normalize_review_sources( array $raw_review_sources ) {
		$review_sources = array();

		foreach ( $raw_review_sources as $raw_review_source ) {
			$review_sources[] = $this->normalize_review_source( $raw_review_source );
		}

		return $review_sources;
	}

	/**
	 * Normalizes and sanitizes a raw review from the platform API.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review Raw data from platform API.
	 * @param string $review_source_id Review Source ID associated with the Review.
	 * @return Review Normalized Review object.
	 */
	abstract public function normalize_review( array $raw_review, $review_source_id );

	/**
	 * Normalizes and sanitizes multiple reviews.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_review Raw data from platform API.
	 * @param string $review_source_id Review Source ID associated with the Review.
	 * @return Review[] Array of normalized Review objects.
	 */
	public function normalize_reviews( array $raw_reviews, $review_source_id ) {
		$reviews = array();

		foreach ( $raw_reviews as $raw_review ) {
			$reviews[] = $this->normalize_review(
				$raw_review,
				$review_source_id
			);
		}

		return $reviews;
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
			'rating_count'      => 0,
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

	/**
	 * Sanitizes a multiline value while retaining line breaks.
	 *
	 * The regular expression accounts for double line breaks. The reassembled
	 * sanitized string only contains single line breaks.
	 *
	 * @param string|array $value The value to be sanitized.
	 * @return string|array Clean multiline string.
	 */
	protected function clean_multiline( $value ) {
		return implode( "\n", array_map( 'sanitize_text_field', preg_split( "/\n?\n/", $value ) ) );
	}
}
