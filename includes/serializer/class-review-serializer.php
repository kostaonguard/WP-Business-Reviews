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
	protected $post_key = 'wp_business_reviews_reviews';

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_business_reviews_save_wpbr_review_source_from_builder', array( $this, 'set_post_parent' ) );
		add_action( 'admin_post_wp_business_reviews_save_builder', array( $this, 'save_from_post_json' ), 30 );
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
		// Define the raw data ($r) from which a post will be created.
		$r = $raw_data;

		// Define the post array ($p) that will hold all post elements.
		$p = array(
			'post_type'   => $this->post_type,
			'post_status' => 'publish',
			'post_parent' => $this->post_parent,
		);

		if ( isset( $r['title'] ) ) {
			$p['post_title'] = $this->clean( $r['title'] );
		}

		if ( isset( $r['components']['content'] ) ) {
			$p['post_content'] = $this->clean( $r['components']['content'] );

			// Unset the content component so it's not saved again as post meta.
			unset( $r['components']['content'] );
		}

		if ( isset( $r['platform'] ) ) {
			$p['tax_input']['wpbr_platform'] = $this->clean( $r['platform'] );
		}

		if ( isset( $r['review_source_id'] ) ) {
			$p['meta_input'][ "{$this->prefix}review_source_id" ] = $this->clean( $r['review_source_id'] );
		}

		if ( isset( $r['components'] ) ) {
			foreach ( $r['components'] as $key => $value ) {
				$p['meta_input'][ "{$this->prefix}{$key}" ] = $this->clean( $value );
			}
		}

		if ( ! isset( $p['post_title'] ) && isset( $p['post_content'] ) ) {
			$p['post_title'] = $this->generateTitleFromContent( $p['post_content'] );
		}

		return $p;
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
