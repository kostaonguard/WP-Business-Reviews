<?php
/**
 * Defines the Blueprint_Shortcode class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Shortcode
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Shortcode;

use WP_Business_Reviews\Includes\Deserializer\Blueprint_Deserializer;
use WP_Business_Reviews\Includes\Deserializer\Review_Deserializer;
use WP_Business_Reviews\Includes\Review\Review_Collection;
use WP_Business_Reviews\Includes\View;

/**
 * Outputs a result as defined by a Blueprint.
 *
 * @since 0.1.0
 */
class Blueprint_Shortcode {
	/**
	 * Instantiates the Blueprint_Shortcode object.
	 *
	 * @since 0.1.0
	 *
	 * @param Blueprint_Deserializer $blueprint_deserializer Blueprint retriever.
	 * @param Review_Deserializer    $review_deserializer    Review retriever.
	 */
	public function __construct(
		Blueprint_Deserializer $blueprint_deserializer,
		Review_Deserializer $review_deserializer
	) {
		$this->blueprint_deserializer = $blueprint_deserializer;
		$this->review_deserializer    = $review_deserializer;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_shortcode( 'wp_business_reviews_blueprint', array( $this, 'init' ) );
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
		), $atts, 'wp_business_reviews_blueprint' );

		$blueprint = $this->blueprint_deserializer->get( $atts['id'] );

		// Request reviews based on the review source post ID.
		$reviews = $this->review_deserializer->query(
			array(
				'post_parent' => $blueprint->get_review_source_post_id(),
			)
		);

		// Create a Review Collection with a unique ID.
		$review_collection = new Review_Collection(
			$reviews,
			$blueprint
		);

		// Pass the Review Collection to the front end as a JS object.
		$review_collection->print_js_object();

		// Render the wrapper within which the collection will be rendered.
		$render = $review_collection->render( false );

		return $render;
	}
}
