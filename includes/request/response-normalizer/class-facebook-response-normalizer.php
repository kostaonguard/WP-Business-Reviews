<?php
/**
 * Defines the Facebook_Response_Normalizer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request\Response_Normalizer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request\Response_Normalizer;

/**
 * Normalizes the structure of a Facebook API response.
 *
 * @since 0.1.0
 */
class Facebook_Response_Normalizer extends Response_Normalizer_Abstract {
	/**
	 * @inheritDoc
	 */
	protected $platform = 'facebook';

	/**
	 * @inheritDoc
	 */
	public function normalize_review_source( array $raw_review_source ) {
		$r          = $raw_review_source;
		$normalized = array();

		// Normalize...

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
		if ( isset( $r['reviewer']['name'] ) ) {
			$normalized['reviewer'] = $this->clean( $r['reviewer']['name'] );
		}

		// Set reviewer image.
		if ( isset( $r['reviewer']['picture']['data']['url'] ) ) {
			$normalized['reviewer_image'] = $this->clean(
				$r['reviewer']['picture']['data']['url']
			);
		}

		// Set rating.
		if ( isset( $r['rating'] ) ) {
			$normalized['rating'] = $this->clean( $r['rating'] );
		}

		// Set timestamp.
		if ( isset( $r['created_time'] ) ) {
			$normalized['timestamp'] = $this->clean( $r['created_time'] );
		}

		// Set content.
		if ( isset( $r['review_text'] ) ) {
			$normalized['content'] = $this->clean_multiline( $r['review_text'] );
		}

		// Merge normalized properties with default properites in case any are missing.
		$normalized = wp_parse_args( $normalized, $this->get_review_defaults() );

		return $normalized;
	}
}
