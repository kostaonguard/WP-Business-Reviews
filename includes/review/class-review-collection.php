<?php
/**
 * Defines the Review_Collection class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Review
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Review;

use WP_Business_Reviews\Includes\Blueprint\Blueprint;
use WP_Business_Reviews\Includes\View;

/**
 * Stores a collection of Review objects.
 *
 * @since 0.1.0
 */
class Review_Collection {
	/**
	 * Title of the Review Collection.
	 *
	 * @since 0.1.0
	 * @var string $title
	 */
	protected $title;

	/**
	 * The Review Source post ID.
	 *
	 * This ID ties the Review_Collection settings to individual Reviews based on a
	 * common post parent. It is supplied to WP_Query when querying Review posts.
	 *
	 * @since 0.1.0
	 * @var int $review_source_post_id
	 */
	protected $review_source_post_id;

	/**
	 * Array of Review_Collection settings.
	 *
	 * These settings determine Review presentation and filtering.
	 *
	 * @since 0.1.0
	 * @var array $settings
	 */
	protected $settings;

	/**
	 * Array of Review objects.
	 *
	 * @since 0.1.0
	 * @var Review[] $reviews
	 */
	protected $reviews;

	/**
	 * Unique identifier to differentiate between multiple Review_Collection objects.
	 *
	 * This uniqued ID may be passed by a widget or shortcode, which allows more
	 * than one Review_Collection to appear on screen.
	 *
	 * @since 0.1.0
	 * @var string $unique_id
	 */
	protected $unique_id;

	/**
	 * Instantiates the Review_Collection object.
	 *
	 * @since 0.1.0
	 *
	 * @param string   $title                 Title of the Review Collection.
	 * @param Review[] $reviews               Optional. Array of Review objects.
	 * @param int      $review_source_post_id Post ID of the review source.
	 * @param array    $settings {
	 *     Review_Collection settings.
	 *
	 *     @type string $theme             Optional. The aesthetic theme.
	 *     @type string $format            Optional. The presentation format.
	 *     @type string $max_columns       Optional. Maximum columns.
	 *     @type string $max_characters    Optional. Maximum characters before truncation.
	 *     @type string $line_breaks       Optional. Whether line breaks are enabled.
	 *     @type array  $review_components Optional. Array of enabled components.
	 * }
	 */
	public function __construct(
		$title,
		array $reviews = array(),
		$review_source_post_id,
		$settings
	) {
		$this->title                 = $title;
		$this->reviews               = $reviews;
		$this->review_source_post_id = $review_source_post_id;
		$this->settings              = $settings;
		$this->unique_id             = wp_rand();
	}

	/**
	 * Prints the Review_Collection object as a JavaScript object.
	 *
	 * This makes the Review_Collection available to other scripts on the front end
	 * of the WordPress website.
	 *
	 * @since 0.1.0
	 */
	public function print_js_object() {
		wp_localize_script(
			'wpbr-public-main-script',
			'wpbrReviewCollection' . $this->unique_id,
			array(
				'settings' => $this->get_settings(),
				'reviews' => $this->get_reviews(),
			)
		);
	}

	/**
	 * Retrieves the title of the Review Collection.
	 *
	 * @since 0.1.0
	 *
	 * @return string Title of the Review Collection.
	 */
	public function get_title() {
		return $this->title;
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
	 * Retrieves the Review Collection settings.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of Review Collection settings.
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Retrieves an array of Reviews.
	 *
	 * @since 0.1.0
	 *
	 * @return Review[] Array of Review objects.
	 */
	public function get_reviews() {
		return $this->reviews;
	}

	/**
	 * Sets reviews.
	 *
	 * @since 0.1.0
	 *
	 * @param Review[] $reviews Array of Review objects.
	 */
	public function set_reviews( array $reviews ) {
		$this->reviews = $reviews;
	}

	/**
	 * Renders a given view.
	 *
	 * @since 0.1.0
	 *
	 * @param bool $echo Optional. Whether to echo the output immediately. Defaults to true.
	 */
	public function render( $echo = true ) {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/review/review-collection.php' );

		return $view_object->render(
			array(
				'unique_id' => $this->unique_id,
			),
			$echo
		);
	}
}
