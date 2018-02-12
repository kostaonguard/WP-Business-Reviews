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
	public function get( $post_id ) {
		$post              = parent::get( $post_id );
		$review_collection = $this->convert_post_to_review_collection( $post );

		return $review_collection;
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
			array(),
			$review_source_post_id,
			$settings
		);

		return $review_collection;
	}
}
