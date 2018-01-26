<?php
/**
 * Defines the Review_Serializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Serializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Serializer;

/**
 * Saves reviews to the database.
 *
 * @since 0.1.0
 */
class Review_Serializer extends Post_Serializer {
	/**
	 * @inheritDoc
	 */
	protected $post_type = 'wpbr_review';

	/**
	 * @inheritDoc
	 */
	protected $post_parent = 0;

	/**
	 * @inheritDoc
	 */
	protected $post_key = 'wp_business_reviews_reviews';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_save_wpbr_review_source_from_builder', array( $this, 'set_post_parent' ) );
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_request' ) );
	}

	/**
	 * Sets the post parent.
	 *
	 * @since 0.1.0
	 *
	 * @param int $post_id The post parent ID.
	 */
	public function set_post_parent( $post_id ) {
		$this->post_parent = $post_id;
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
				case 'content':
					$post_array['post_content'] = $this->clean( $value );
					break;
				case 'platform':
					$post_array['tax_input']['wpbr_platform'] = $this->clean( $value );
					break;
				case 'review_source_id':
				case 'reviewer':
				case 'reviewer_image':
				case 'rating':
				case 'timestamp':
				case 'content':
					$post_array['meta_input'][ $this->prefix . $key ] = $this->clean( $value );
					break;
			}
		}

		if (
			! isset( $post_array['post_title'] )
			&& isset( $post_array['post_content'] )
		) {
			$post_array['post_title'] = $this->generateTitleFromContent(
				$post_array['post_content']
			);
		}

		return $post_array;
	}

	/**
	 * Generates a truncated title from a string of content.
	 *
	 * @since 0.1.0
	 *
	 * @param string  $content The review content to trim.
	 * @param integer $num_words Number of words in title.
	 * @return string The truncated title.
	 */
	function generateTitleFromContent( $content, $num_words = 7 ) {
		$title = wp_trim_words( $content, $num_words, '...' );

		return $title;
	}
}
