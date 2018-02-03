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
	 * Review objects.
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
	 * @param Blueprint $blueprint User-defined settings that determine which
	 *                             reviews to display and how to display them.
	 */
	public function __construct( Blueprint $blueprint ) {
		$this->blueprint = $blueprint;
		$this->reviews = array();
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
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/review-collection.php' );
		$view_object->render(
			array(
				'blueprint' => $this->blueprint,
				'reviews'   => $this->reviews,
			)
		);
	}
}
