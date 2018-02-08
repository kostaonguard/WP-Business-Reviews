<?php
/**
 * Defines the Blueprint_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

use WP_Business_Reviews\Includes\Blueprint\Blueprint;

/**
 * Retrieves reviews from the database.
 *
 * @since 0.1.0
 */
class Blueprint_Deserializer extends Post_Deserializer {
	/**
	 * The post type being retrieved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'wpbr_blueprint';

	/**
	 * Gets a single Blueprint object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_id ID of the post to retrieve.
	 * @return Blueprint|false Blueprint object or false if blueprint post not found.
	 */
	public function get( $post_id ) {
		$post = parent::get( $post_id );
		$blueprint = $this->convert_post_to_blueprint( $post );

		return $blueprint;
	}

	/**
	 * Converts WP_Post object into Blueprint object.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Post $post The WP_Post object to be converted.
	 * @return Blueprint The new Blueprint object.
	 */
	protected function convert_post_to_blueprint( $post ) {
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

		$blueprint = new Blueprint(
			$review_source_post_id,
			$settings
		);

		return $blueprint;
	}
}
