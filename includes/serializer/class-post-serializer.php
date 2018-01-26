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
	 * The post type being saved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'post';

	/**
	 * The parent post ID of the post being saved.
	 *
	 * @since 0.1.0
	 * @var string $post_parent
	 */
	protected $post_parent = 0;

	/**
	 * The $_POST key to which data is posted.
	 *
	 * @since 0.1.0
	 * @var string $post_key
	 */
	protected $post_key;

	/**
	 * Saves a single review to the database.
	 *
	 * @since 0.1.0
	 *
	 * @param array $post_array Array of elements that make up a post.
	 * @return boolean|WP_Error The post ID on success. The value 0 or WP_Error
	 *                          on failure.
	 */
	function save( array $post_array ) {
		$post_id = wp_insert_post( $post_array );

		if (
			0 < $post_id
			&& 'admin_post_wp_business_reviews_save_builder' === current_action()
		) {
			do_action(
				"wp_business_reviews_save_{$this->post_type}_from_builder",
				$post_id
			);
		}

		return $post_id;
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
		$raw_data_json  = wp_unslash( $_POST[ $this->post_key ] );
		$raw_data_array = json_decode( $raw_data_json, true );

		error_log( print_r( current($raw_data_array), true ) );

		if ( is_array( current( $raw_data_array ) ) ) {

			$posts_array = array();

			foreach ( $raw_data_array as $data ) {
				$posts_array[] = $this->prepare_post_array( $data );
			}

			$this->save_multiple( $posts_array );

		} else {

			$post_array = $this->prepare_post_array( $raw_data_array );
			$this->save( $post_array );

		}
	}
}
