<?php
/**
 * Defines the Blueprint class
 *
 * @link https://wpbusinessReviews.com
 *
 * @package WP_Business_Reviews\Includes\Blueprint
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Blueprint;

/**
 * Determines which Reviews should be retrieved and how to present them.
 *
 * @since 0.1.0
 */
class Blueprint {
	/**
	 * The Review Source post ID.
	 *
	 * This ID ties the Blueprint settings to individual Reviews based on a common
	 * post parent. It is supplied to WP_Query when querying Review posts.
	 *
	 * @since 0.1.0
	 * @var int $review_source_post_id
	 */
	protected $review_source_post_id;

	/**
	 * Array of Blueprint settings.
	 *
	 * These settings determine Review presentation and filtering.
	 *
	 * @since 0.1.0
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * Instantiates the Blueprint object.
	 *
	 * @since 0.1.0
	 *
	 * @param int   $review_source_post_id The Review Source post ID.
	 * @param array $settings {
	 *     Blueprint settings.
	 *
	 *     @type string $theme             Optional. The aesthetic theme.
	 *     @type string $format            Optional. The presentation format.
	 *     @type string $max_columns       Optional. Maximum columns.
	 *     @type string $max_characters    Optional. Maximum characters before truncation.
	 *     @type string $line_breaks       Optional. Whether line breaks are enabled.
	 *     @type array  $review_components Optional. Array of enabled components.
	 * }
	 */
	public function __construct( $review_source_post_id, $settings ) {
		$this->review_source_post_id = $review_source_post_id;
		$this->settings    = $settings;
	}

	/**
	 * Retrieves the post ID of the Review Source associated with the review.
	 *
	 * @since 0.1.0
	 *
	 * @return int The Review Source post ID.
	 */
	public function get_review_source_post_id() {
		return $this->review_source_post_id;
	}

	/**
	 * Retrieves the Blueprint settings.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of Blueprint settings.
	 */
	public function get_settings() {
		return $this->settings;
	}
}
