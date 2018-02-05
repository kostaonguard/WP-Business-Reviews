<?php
/**
 * Defines the Post_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

use WP_Business_Reviews\Includes\Review\Review;


/**
 * Retrieves Posts from the database.
 *
 * @since 0.1.0
 */
class Post_Deserializer {
	/**
	 * The prefix prepended to post meta keys.
	 *
	 * @since 0.1.0
	 * @var string $prefix
	 */
	protected $prefix = 'wp_business_reviews_';

	/**
	 * The post type being retrieved.
	 *
	 * @since 0.1.0
	 * @var string $post_type
	 */
	protected $post_type = 'post';

	/**
	 * The WP_Query object used to query Posts.
	 *
	 * @since 0.1.0
	 * @var \WP_Query $wp_query
	 */
	protected $wp_query;

	/**
	 * Instantiates the Post_Deserializer object.
	 *
	 * @since 0.1.0
	 *
	 * @param WP_Query The WP_Query object used to query Posts.
	 */
	public function __construct( \WP_Query $wp_query ) {
		$this->wp_query = $wp_query;
	}

	/**
	 * Gets a single WP Post.
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_id ID of the post to retrieve.
	 * @return WP_Post|false WP_Post object or false if post not found.
	 */
	public function get( $post_id ) {
		$post = null;
		$args = array(
			'post_type'      => $this->post_type,
			'p'              => $post_id,
			'posts_per_page' => 1,
			'no_found_rows'  => true,
		);

		$this->wp_query->query( $args );

		if ( ! $this->wp_query->have_posts() ) {
			return false;
		}

		return $this->wp_query->posts[0];
	}
}
