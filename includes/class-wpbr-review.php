<?php

/**
 * Defines the WPBR_Review abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Review object which contains normalized review data
 * that has been parsed from a remote API response.
 *
 * @since 1.0.0
 */
class WPBR_Review {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the parent business on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Post ID of the parent business in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_post_id;

	/**
	 * ID of the review post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $post_id;

	/**
	 * Title of the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $review_title;

	/**
	 * Review text submitted by the reviewer.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $review_text;

	/**
	 * URL of the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $review_url;

	/**
	 * Name of the person who submitted the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_name;

	/**
	 * Image URL of the reviewer on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_image_url;

	/**
	 * Numerical rating associated with the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $rating;

	/**
	 * Time at which the review was created on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $time_created;

	/**
	 * Constructor.
	 *
	 * @param string $business_id ID of the parent business on the platform.
	 * @param string $platform    Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id, $platform ) {
		$this->business_id = $business_id;
		$this->platform    = $platform;
	}

	/**
	 * Builds unique post slug by concatenating reviewer name and time created.
	 *
	 * @since 1.0.0
	 *
	 * @return string|null Review post slug.
	 */
	protected function build_post_slug() {
		if ( ! empty( $this->business_id ) && ! empty( $this->time_created ) ) {
			$slug = $business_id . '-' . $time_created;
			$slug = str_replace( '_', '-', strtolower( $slug ) );

			return sanitize_title( $slug );
		} else {
			return null;
		}
	}

	/**
	 * Sets properties from array of key-value pairs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	public function set_properties( array $properties ) {
		foreach ( $properties as $property => $value ) {
			$this->$property = $value;
		}
	}

	/**
	 * Inserts wpbr_review post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {
		// Build post slug that is unique to the review on the platform.
		$post_slug = $this->build_post_slug();

		// Define array of post elements.
		$postarr = array(
			'post_type'   => 'wpbr_review',
			'post_title'  => $this->review_title,
			'post_name'   => $post_slug,
			'post_status' => 'publish',
			// TODO: Get post_parent from $this->business_post_id.
			// 'post_parent' => 999,
			'meta_input'  => array(
				'wpbr_review_id'          => $this->review_id,
				'wpbr_rating'             => $this->rating,
				'wpbr_review_title'       => $this->review_title,
				'wpbr_review_text'        => $this->review_text,
				'wpbr_review_url'         => $this->review_url,
				'wpbr_reviewer_name'      => $this->reviewer_name,
				'wpbr_reviewer_image_url' => $this->reviewer_image_url,
				'wpbr_time_created'       => $this->time_created,
			),
			'tax_input'   => array(
				'wpbr_platform' => $this->platform,
			),
		);

		// Attempt to retrieve post from database using the post slug.
		$post = get_page_by_path( $post_slug, OBJECT, 'wpbr_review' );

		if ( ! empty( $post ) ) {
			$postarr['ID'] = $post->ID;
		}

		// Insert or update post in database.
		wp_insert_post( $postarr );
	}

}
