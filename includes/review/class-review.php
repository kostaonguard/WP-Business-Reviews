<?php

/**
 * Defines the Review abstract class
 *
 * @package WP_Business_Reviews\Includes\Review
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Review;
use WP_Post;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Implements the Review object which contains normalized review data
 * that has been parsed from a remote API response.
 *
 * @since 0.1.0
 */
class Review {

	/**
	 * ID of the parent business on the platform.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * Post ID of the parent business in the database.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $business_post_id;

	/**
	 * ID of the review post in the database.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var int
	 */
	protected $post_id;

	/**
	 * Slug of the review post in the database.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $post_slug;

	/**
	 * Title of the review.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $review_title = '';

	/**
	 * Review text submitted by the reviewer.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $review_text = '';

	/**
	 * Array of metadata associated with the review.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var array
	 */
	protected $meta;

	/**
	 * Constructor.
	 *
	 * @param string $business_id ID of the parent business on the platform.
	 * @param string $platform    Reviews platform associated with the business.
	 *
	 * @since 0.1.0
	 */
	public function __construct( $business_id, $platform ) {
		$this->business_id = $business_id;
		$this->platform    = $platform;

		// Set metadata defaults stored as post meta in the database.
		$this->meta = array(
			'review_url'         => null,
			'reviewer_name'      => null,
			'reviewer_image_url' => null,
			'rating'             => null,
			'time_created'       => null,
		);
		// TODO: Filter these meta keys.
	}

	/**
	 * Builds unique post slug by concatenating reviewer name and time created.
	 *
	 * @since 0.1.0
	 *
	 * @return string|null Review post slug.
	 */
	protected function build_post_slug() {
		if ( ! empty( $this->business_id ) && ! empty( $this->meta['time_created'] ) ) {
			$slug = $this->business_id . '-' . $this->meta['time_created'];
			$slug = str_replace( '_', '-', strtolower( $slug ) );

			return sanitize_title( $slug );
		} else {
			return null;
		}
	}

	/**
	 * Sets properties from array of key-value pairs.
	 *
	 * @since 0.1.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	public function set_properties( array $properties ) {
		$keys = array_keys( get_object_vars( $this ) );

		foreach ( $keys as $key ) {
			if ( isset( $properties[ $key ] ) ) {
				$this->$key = $properties[ $key ];
			}
		}
	}

	/**
	 * Sets properties from existing post in database.
	 *
	 * @since 0.1.0
	 *
	 * @param int|WP_Post $post Post ID or post object.
	 */
	public function set_properties_from_post( $post ) {
		if ( is_int( $post ) && 0 < $post ) {
			$post = get_post( $post );
		}

		if ( ! $post instanceof WP_Post ) {
			return;
		}

		$properties['post_id']      = $post->ID;
		$properties['review_title'] = $post->post_title;
		$properties['review_text']  = $post->post_content;

		$post_meta = get_post_meta( $post->ID );

		foreach ( $post_meta as $key => $value ) {
			// Do not set if meta key is private.
			if ( '_' != substr( $key, 0, 1 ) ) {
				// TODO: Recondsider this approach and maybe set explicit post meta keys instead.
				$properties['meta'][ $key ] = maybe_unserialize( array_shift( $value ) );
			}
		}

		$this->set_properties( $properties );
	}

	/**
	 * Inserts wpbr_review post into the database.
	 *
	 * @since 0.1.0
	 */
	public function insert_post() {
		// Build slug if it has not been set.
		if ( ! isset( $this->post_slug ) ) {
			$this->post_slug = $this->build_post_slug();
		}

		// Look up post slug to determine if review post already exists.
		if ( ! isset( $this->post_id ) ) {
			$post = get_page_by_path( $this->post_slug, OBJECT, 'wpbr_review' );

			if ( $post instanceof WP_Post ) {
				$this->post_id = $post->ID;
			}
		}

		// Define post meta fields.
		$meta_input = array(
			'wpbr_business_id' => $this->business_id,
		);

		foreach ( $this->meta as $key => $value ) {
			$meta_input["wpbr_$key"] = $value;
		}

		// Define taxonomy terms.
		$tax_input = array(
			'wpbr_platform' => $this->platform,
		);

		// Define array of post elements.
		$postarr = array(
			'ID'           => $this->post_id,
			'post_type'    => 'wpbr_review',
			'post_title'   => $this->review_title,
			'post_content' => $this->review_text,
			'post_name'    => $this->post_slug,
			'post_status'  => 'publish',
			'meta_input'   => $meta_input,
			'tax_input'    => $tax_input,
		);

		// Insert or update post in database.
		wp_insert_post( $postarr );
	}
}
