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
	 * The Blueprint post ID.
	 *
	 * @since 0.1.0
	 * @var int $post_id
	 */
	protected $post_id;

	/**
	 * The Review Source post ID.
	 *
	 * This ID ties the Blueprint settings to individual Reviews based on a common
	 * post parent. It is supplied to WP_Query when querying Review posts.
	 *
	 * @since 0.1.0
	 * @var int $post_parent
	 */
	protected $post_parent;

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
	 * @param int   $post_id     The Blueprint post ID.
	 * @param int   $post_parent The Review Source post ID.
	 * @param array $settings    Array of Blueprint settings.
	 */
	public function __construct( $post_id, $post_parent, $settings ) {
		$this->post_id     = $post_id;
		$this->post_parent = $post_parent;
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
