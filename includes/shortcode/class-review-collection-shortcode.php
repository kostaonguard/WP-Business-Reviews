<?php
/**
 * Defines the Review_Collection_Shortcode class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Shortcode
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Shortcode;

use WP_Business_Reviews\Includes\Deserializer\Review_Collection_Deserializer;
use WP_Business_Reviews\Includes\Review\Review_Collection;
use WP_Business_Reviews\Includes\Deserializer\Review_Deserializer;
use WP_Business_Reviews\Includes\View;

/**
 * Outputs a result as defined by a Blueprint.
 *
 * @since 0.1.0
 */
class Review_Collection_Shortcode {
	/**
	 * Review Collection deserializer.
	 *
	 * @since 0.1.0
	 * @var Review_Collection_Deserializer $collection_deserializer
	 */
	private $collection_deserializer;

	/**
	 * Review deserializer.
	 *
	 * @since 0.1.0
	 * @var string $review_deserializer
	 */
	private $review_deserializer;

	/**
	 * Instantiates the Review_Collection_Shortcode object.
	 *
	 * @since 0.1.0
	 *
	 * @param Review_Collection_Deserializer $collection_deserializer Retriever of Review Collections.
	 * @param Review_Deserializer            $review_deserializer     Retriever of Reviews.
	 */
	public function __construct(
		Review_Collection_Deserializer $collection_deserializer,
		Review_Deserializer $review_deserializer
	) {
		$this->collection_deserializer = $collection_deserializer;
		$this->review_deserializer     = $review_deserializer;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_shortcode( 'wp_business_reviews_collection', array( $this, 'init' ) );
	}

	/**
	 * Initializes the Review_Collection.
	 *
	 * @since 0.1.0
	 *
	 * @param array $atts {
	 *     Shortcode attributes.
	 *
	 *     @type int $id Review_Collection post ID.
	 * }
	 */
	public function init( $atts ) {
		$atts = shortcode_atts( array(
			'id' => 0,
		), $atts, 'wp_business_reviews_collection' );

		$review_collection = $this->collection_deserializer->get( $atts['id'] );

		// Request reviews based on the review source post ID.
		$reviews = $this->review_deserializer->query(
			array(
				'post_parent' => $review_collection->get_review_source_post_id(),
			)
		);

		// Pass the Review Collection to the front end as a JS object.
		$review_collection->set_reviews( $reviews );
		$review_collection->print_js_object();

		// Render the wrapper within which the collection will be rendered.
		return $review_collection->render( false );
	}
}
