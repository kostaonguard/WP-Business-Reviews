<?php
/**
 * Defines the Review_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

use WP_Business_Reviews\Includes\Review\Review;

/**
 * Retrieves reviews from the database.
 *
 * @since 0.1.0
 */
class Review_Deserializer extends Post_Deserializer {
	/**
	 * The post type being retrieved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'wpbr_review';

	/**
	 * Gets a single Review object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_id ID of the post to retrieve.
	 * @return Review|false Review object or false if review post not found.
	 */
	public function get_review( $post_id ) {
		$post = $this->get_post( $post_id );
		$review = $this->convert_post_to_review( $post );

		return $review;
	}

	/**
	 * Queries Review objects.
	 *
	 * @since 0.1.0
	 *
	 * @param string|array $args URL query string or array of vars.
	 * @return Review[]|false Array of Review objects or false if no posts found.
	 */
	public function query_reviews( $args ) {
		$reviews = array();
		$posts   = $this->query_posts( $args );

		foreach ( $posts as $post ) {
			$reviews[] = $this->convert_post_to_review( $post );
		}

		return $reviews;
	}

	/**
	 * Converts a WP_Post object into a Review object.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Post $post The WP_Post object to be converted.
	 * @return Review The new Review object.
	 */
	protected function convert_post_to_review( $post ) {
		$post_id          = $post->ID;
		$post_parent      = $post->post_parent;
		$review_source_id = $this->get_meta( $post_id, 'review_source_id' );
		$components       = array();
		$component_keys   = array_keys( Review::get_default_components() );

		// Map post meta to components.
		foreach ( $component_keys as $key ) {
			$components[ $key ] = $this->get_meta( $post_id, $key );
		}

		// Add review content from post content field.
		$components['content'] = $post->post_content;

		$review = new Review(
			$this->get_platform( $post ),
			$review_source_id,
			$components
		);

		return $review;
	}

	/**
	 * Gets platform ID from post terms.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Post $post Post object.
	 * @return string Platform ID.
	 */
	protected function get_platform( $post ) {
		$term_list = wp_get_post_terms(
			$post->ID,
			'wpbr_platform',
			array(
				'fields' => 'slugs',
			)
		);

		return isset( $term_list[0] ) ? $term_list[0] : '';
	}
}
