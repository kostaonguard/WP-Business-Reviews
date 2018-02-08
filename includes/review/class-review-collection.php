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
	 * User-defined Blueprint.
	 *
	 * @since 0.1.0
	 * @var Blueprint $blueprint
	 */
	protected $blueprint;

	/**
	 * Array of Review objects.
	 *
	 * @since 0.1.0
	 * @var Review[] $reviews
	 */
	protected $reviews;

	/**
	 * Instantiates the Review_Collection object.
	 *
	 * @since 0.1.0
	 *
	 * @param Review[]  $reviews   Array of Review objects.
	 * @param Blueprint $blueprint Blueprint containing presentation settings.
	 */
	public function __construct( array $reviews = array(), Blueprint $blueprint ) {
		$this->reviews   = $reviews;
		$this->blueprint = $blueprint;
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
			'wpBusinessReviewsCollection',
			array(
				'settings' => $this->blueprint->get_settings(),
				'reviews' => $this->reviews,
			)
		);
	}

	/**
	 * Renders a given view.
	 *
	 * @since 0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/review/review-collection.php' );
		$view_object->render(
			array(
				'blueprint' => $this->blueprint,
				'reviews'   => $this->reviews,
			)
		);
	}
}
