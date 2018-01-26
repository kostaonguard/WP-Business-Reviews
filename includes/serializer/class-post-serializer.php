<?php
/**
 * Defines the Post_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves posts to the database.
 *
 * @since 0.1.0
 */
class Post_Serializer extends Serializer_Abstract {
	/**
	 * Saves a single review to the database.
	 *
	 * @since 0.1.0
	 *
	 * @param array $post_array Array of elements that make up a post.
	 * @return boolean True if value saved successfully, false otherwise.
	 */
	function save( array $post_array ) {
		return wp_insert_post( $post_array );
	}

	/**
	 * Saves multiple posts to the database.
	 *
	 * @since 0.1.0
	 *
	 * @param array $posts_array Array of post arrays.
	 */
	public function save_multiple( array $posts_array ) {
		foreach ( $posts_array as $post_array ) {
			$this->save( $post_array );
		}
	}

	/**
	 * Saves multiple WordPress posts from $_POST data to the database.
	 *
	 * After save, user is redirected back to the referring page.
	 *
	 * @since 0.1.0
	 */
	public function save_from_post_request() {
		if ( empty( $_POST[ $this->post_key ] ) ) {
			$this->redirect();
		}

		// TODO: Verify nonce and permission.
		$posts_array     = array();
		$raw_posts_json  = wp_unslash( $_POST[ $this->post_key ] );
		$raw_posts_array = json_decode( $raw_posts_json, true );

		foreach ( $raw_posts_array as $raw_post_array ) {
			$posts_array[] = $this->prepare_post_array( $raw_post_array );
		}

		$this->save_multiple( $posts_array );
		$this->redirect();
	}
}
