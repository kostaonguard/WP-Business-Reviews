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
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_request' ) );
	}

	/**
	 * Saves multiple reviews from $_POST to the database.
	 *
	 * After save, user is redirected back to the referring page.
	 *
	 * @since 0.1.0
	 */
	public function save_from_post_request() {
		if ( empty( $_POST['wp_business_reviews_reviews'] ) ) {
			$this->redirect();
		}

		// TODO: Verify nonce and permission.
		$posts_array   = array();
		$reviews_json  = wp_unslash( $_POST[ 'wp_business_reviews_reviews' ] );
		$reviews_array = json_decode( $reviews_json, true );

		foreach ( $reviews_array as $review_array ) {
			$posts_array[] = $this->prepare_post_array( $review_array );
		}

		$this->save_multiple( $posts_array );
		$this->redirect();
	}

	/**
	 * Prepares the review data in a ready-to-save format.
	 *
	 * @since 0.1.0
	 *
	 * @param array $review_array Raw, unstructured post data.
	 * @return array Array of elements that make up a post.
	 */
	public function prepare_post_array( array $review_array ) {
		$post_array = array(
			'post_type'   => 'wpbr_review',
			'post_status' => 'publish',
			// 'post_parent' => $post_parent,
			'meta_input'  => array(
				// 'review_source_id' => $review_source_id,
			),
		);

		foreach ( $review_array as $key => $value ) {
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
