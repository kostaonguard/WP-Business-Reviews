<?php
/**
 * Defines the Review class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Review
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Review;

/**
 * Represents a single review associated with a review source.
 *
 * @since 0.1.0
 */
class Review {
	/**
	 * Instantiates the Review object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform Platform ID.
	 * @param array $components {
	 *     Review components.
	 *
	 *     @type string $review_url     Optional. Review URL.
	 *     @type string $reviewer       Optional. Name of the reviewer.
	 *     @type string $reviewer_image Optional. Image of the reviewer.
	 *     @type int    $rating         Optional. Numerical rating.
	 *     @type string $timestamp      Optional. Unix timestamp of the review.
	 *     @type array  $content        Optional. Review content.
	 * }
	 */
	public function __construct(
		$platform,
		$review_source_id,
		array $components
	) {
		$this->platform         = $platform;
		$this->review_source_id = $review_source_id;
		$this->components       = $components;
	}

	/**
	 * Retrieves default values for a review components.
	 *
	 * @since 0.1.0
	 *
	 * @return array Associative array of components.
	 */
	public static function get_default_components() {
		return array(
			'review_url'     => null,
			'reviewer'       => null,
			'reviewer_image' => null,
			'rating'         => 0,
			'timestamp'      => null,
			'content'        => null,
		);
	}
}
