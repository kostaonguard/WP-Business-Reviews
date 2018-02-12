<?php
/**
 * Defines the Review_Collection_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

use WP_Business_Reviews\Includes\Review\Review_Collection;

/**
 * Retrieves Review Collections from the database.
 *
 * @since 0.1.0
 */
class Review_Collection_Deserializer extends Post_Deserializer {
	/**
	 * The post type being retrieved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'wpbr_collection';

	/**
	 * Gets a single Review_Collection object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_id ID of the post to retrieve.
	 * @return Review_Collection|false Review_Collection object or false if not found.
	 */
	public function get_review_collection( $post_id ) {
		$post = $this->get_post( $post_id );

		if ( false === $post ) {
			return false;
		}

		$review_collection = $this->convert_post_to_review_collection( $post );

		return $review_collection;
	}

	/**
	 * Queries Review_Collection objects.
	 *
	 * @since 0.1.0
	 *
	 * @param string|array $args URL query string or array of vars.
	 * @return Review_Collection[]|false Array of Review_Collection objects or false
	 *                                   if no posts found.
	 */
	public function query_review_collections( $args ) {
		$review_collections = array();
		$posts              = $this->query_posts( $args );

		foreach ( $posts as $post ) {
			$review_collections[] = $this->convert_post_to_review_collection( $post );
		}

		return $review_collections;
	}

	/**
	 * Converts WP_Post object into Review_Collection object.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Post $post The WP_Post object to be converted.
	 * @return Review_Collection The new Review_Collection object.
	 */
	protected function convert_post_to_review_collection( $post ) {
		$post_id               = $post->ID;
		$title                 = $post->post_title;
		$review_source_post_id = $post->post_parent;
		$settings              = array();
		$meta_keys             = array(
			'theme',
			'format',
			'max_columns',
			'max_characters',
			'line_breaks',
			'review_components',
		);

		// Map meta keys to settings.
		foreach ( $meta_keys as $key ) {
			$settings[ $key ] = $this->get_meta( $post_id, $key );
		}

		$review_collection = new Review_Collection(
			$title,
			array(),
			$review_source_post_id,
			$settings
		);

		return $review_collection;
	}
}
