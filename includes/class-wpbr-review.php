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
abstract class WPBR_Review {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * ID of the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $review_id;

	/**
	 * Slug of the review post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $slug;

	/**
	 * ID of the reviewer.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_id;

	/**
	 * Name of the person who submitted the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_name;

	/**
	 * Numerical rating associated with the review.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $rating;

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
	 * URL of the reviewer's page on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_url;

	/**
	 * Image URL of the reviewer on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $reviewer_image_url;

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
	 * @param string $business_id ID of the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
//		$this->slug        = $this->create_slug();
//
//		if ( $this->review_exists() ) {
//
//			$this->set_properties_from_post();
//
//		} else {
//
//			$this->set_properties_from_api();
//
//		}

//		$this->set_properties_from_api();

	}

	/**
	 * Creates unique slug by concatenating reviewer name and time created.
	 *
	 * @since 1.0.0
	 *
	 * @return string Business post slug.
	 */
	protected function create_slug() {

		$slug = $this->reviewer_name . '-' . $this->time_created;
		$slug = str_replace( '_', '-', strtolower( $slug ) );

		return sanitize_title( $slug );

	}

	/**
	 * Standardizes review data for a single review.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	abstract public function standardize_properties( $data );

	/**
	 * Sets properties from existing post in database.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	public function set_properties_from_post( $post_id ) {

	}

	/**
	 * Set properties from array of key-value pairs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	public function set_properties_from_array( $properties ) {

		foreach ( $properties as $property => $value ) {

			// Build function name (e.g. set_business_name_from_api).
			$setter = 'set_' . $property;

			// Set property.
			if ( method_exists( $this, $setter ) ) {

				$this->$setter( $value );

			}

		}

	}

	/**
	 * Inserts wpbr_review post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {

		// Define post meta.
		$meta_input = array(

			'wpbr_review_id'          => $this->review_id,
			'wpbr_reviewer_id'        => $this->reviewer_id,
			'wpbr_reviewer_name'      => $this->reviewer_name,
			'wpbr_rating'             => $this->rating,
			'wpbr_review_title'       => $this->review_title,
			'wpbr_review_text'        => $this->review_text,
			'wpbr_review_url'         => $this->review_url,
			'wpbr_reviewer_url'       => $this->reviewer_url,
			'wpbr_reviewer_image_url' => $this->reviewer_image_url,
			'wpbr_time_created'       => $this->time_created,


		);

		// Define taxonomy terms.
		$tax_input = array(

			'wpbr_platform' => $this->platform,

		);

		// Define array of post elements.
		$postarr = array(

			'post_type'   => 'wpbr_review',
			'post_title'  => $this->review_title,
			'post_name'   => $this->slug,
			'post_status' => 'publish',
			'post_parent' => 111,
			'meta_input'  => $meta_input,
			'tax_input'   => $tax_input,

		);

		// Insert or update post in database.
		wp_insert_post( $postarr );

	}

	/**
	 * Set review ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_id ID of the review.
	 */
	protected function set_review_id( $review_id ) {

		$this->review_id = sanitize_text_field( $review_id );

	}

	/**
	 * Set review ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_id ID of the review.
	 */
	protected function set_reviewer_id( $reviewer_id ) {

		$this->reviewer_id = sanitize_text_field( $reviewer_id );

	}

	/**
	 * Set reviewer name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_name Name of the person who submitted the review.
	 */
	protected function set_reviewer_name( $reviewer_name ) {

		$this->reviewer_name = sanitize_text_field( ucwords( $reviewer_name ) );

	}

	/**
	 * Set rating.
	 *
	 * @since 1.0.0
	 *
	 * @param float $rating Numerical rating associated with the review.
	 */
	protected function set_rating( $rating ) {

		$this->rating = is_numeric( $rating ) ? $rating : '';

	}


	/**
	 * Set review title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_title Review title submitted by the reviewer.
	 */
	protected function set_review_title( $review_title ) {

		if ( ! empty( $review_title ) ) {

			$this->review_title = sanitize_text_field( $review_title );

		} else {

			$this->review_title = sanitize_text_field( 'Review by ' . $this->reviewer_name );

		}

	}

	/**
	 * Set review text.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_text Review text submitted by the reviewer.
	 */
	protected function set_review_text( $review_text ) {

		$this->review_text = sanitize_text_field( $review_text );

	}

	/**
	 * Set review URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_url URL of the review.
	 */
	protected function set_review_url( $review_url ) {

		$this->review_url = filter_var( $review_url, FILTER_VALIDATE_URL ) ? $review_url : '';

	}


	/**
	 * Set reviewer URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_url URL of the reviewer's page on the platform.
	 */
	protected function set_reviewer_url( $reviewer_url ) {

		$this->reviewer_url = filter_var( $reviewer_url, FILTER_VALIDATE_URL ) ? $reviewer_url : '';

	}

	/**
	 * Set reviewer image URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_image_url Image URL of the reviewer on the platform.
	 */
	protected function set_reviewer_image_url( $reviewer_image_url ) {

		$this->reviewer_image_url = filter_var( $reviewer_image_url, FILTER_VALIDATE_URL ) ? $reviewer_image_url : '';

	}

	/**
	 * Set time created.
	 *
	 * @since 1.0.0
	 *
	 * @param string $time_created Time at which the review was created on the platform.
	 */
	protected function set_time_created( $time_created ) {

		$this->time_created = sanitize_text_field( $time_created );

	}

}
