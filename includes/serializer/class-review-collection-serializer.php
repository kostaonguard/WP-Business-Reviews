<?php
/**
 * Defines the Review_Collection_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves Review Collections to the database.
 *
 * @since 0.1.0
 */
class Review_Collection_Serializer extends Post_Serializer {
	/**
	 * @inheritDoc
	 */
	protected $post_type = 'wpbr_collection';

	/**
	 * @inheritDoc
	 */
	protected $post_key = 'wp_business_reviews';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_save_wpbr_review_source_from_builder', array( $this, 'set_post_parent' ) );
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_array' ), 20 );
	}

	/**
	 * Prepares the post data in a ready-to-save format.
	 *
	 * @since 0.1.0
	 *
	 * @param array $raw_data Raw, unstructured post data.
	 * @return array Array of elements that make up a post.
	 */
	public function prepare_post_array( array $raw_data ) {
		$post_array = array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
			'post_parent' => $this->post_parent,
		);

		foreach ( $raw_data as $key => $value ) {
			switch ( $key ) {
				case 'title':
					$post_array['post_title'] = $this->clean( $value );
					break;
				case 'platform':
					$post_array['tax_input']['wpbr_platform'] = $this->clean( $value );
					break;
				case 'theme':
				case 'format':
				case 'max_columns':
				case 'max_characters':
				case 'line_breaks':
				case 'review_components':
					$post_array['meta_input'][ $this->prefix . $key ] = $this->clean( $value );
					break;
			}
		}

		return $post_array;
	}
}
