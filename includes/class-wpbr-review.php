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
	 * ID of the review on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $review_id;

	/**
	 * ID of the review post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $post_id;

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
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;

	}

	/**
	 * Builds unique post slug by concatenating reviewer name and time created.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the parent business on the platform.
	 * @param string $time_created Time at which the review was created.
	 *
	 * @return string Review post slug.
	 */
	protected function build_post_slug( $business_id, $time_created ) {

		if ( empty( $business_id ) || empty( $time_created ) ) {

			return '';

		}

		$slug = $business_id . '-' . $time_created;
		$slug = str_replace( '_', '-', strtolower( $slug ) );
		$slug = sanitize_title( $slug );

		return $slug;

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
	 * Sets properties from array of key-value pairs.
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

		// Build post slug that is unique to the review on the platform.
		$post_slug = $this->build_post_slug( $this->business_id, $this->time_created );

		// Define array of post elements.
		$postarr = array(

			'post_type'   => 'wpbr_review',
			'post_title'  => $this->review_title,
			'post_name'   => $post_slug,
			'post_status' => 'publish',
			'post_parent' => 999,
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

		// Insert or update post in database.
		wp_insert_post( $postarr );

	}

	/**
	 * Sets review ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_platform_id ID of the review.
	 */
	protected function set_review_platform_id( $review_platform_id ) {

		$this->review_platform_id = sanitize_text_field( $review_platform_id );

	}

	/**
	 * Sets review ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_id ID of the review.
	 */
	protected function set_reviewer_id( $reviewer_id ) {

		$this->reviewer_id = sanitize_text_field( $reviewer_id );

	}

	/**
	 * Sets reviewer name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_name Name of the person who submitted the review.
	 */
	protected function set_reviewer_name( $reviewer_name ) {

		$this->reviewer_name = sanitize_text_field( ucwords( $reviewer_name ) );

	}

	/**
	 * Sets rating.
	 *
	 * @since 1.0.0
	 *
	 * @param float $rating Numerical rating associated with the review.
	 */
	protected function set_rating( $rating ) {

		$this->rating = is_numeric( $rating ) ? $rating : '';

	}


	/**
	 * Sets review title.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_title Review title submitted by the reviewer.
	 */
	protected function set_review_title( $review_title ) {

		if ( ! empty( $review_title ) ) {

			$this->review_title = sanitize_text_field( $review_title );

		} else {

			$platform_term = get_term_by( 'slug', $this->platform, 'wpbr_platform' );
			$platform_name = $platform_term->name;

			$this->review_title = sanitize_text_field( $platform_name . ' Review' );

		}

	}

	/**
	 * Sets review text.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_text Review text submitted by the reviewer.
	 */
	protected function set_review_text( $review_text ) {

		$this->review_text = sanitize_text_field( $review_text );

	}

	/**
	 * Sets review URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $review_url URL of the review.
	 */
	protected function set_review_url( $review_url ) {

		$this->review_url = filter_var( $review_url, FILTER_VALIDATE_URL ) ? $review_url : '';

	}


	/**
	 * Sets reviewer URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_url URL of the reviewer's page on the platform.
	 */
	protected function set_reviewer_url( $reviewer_url ) {

		$this->reviewer_url = filter_var( $reviewer_url, FILTER_VALIDATE_URL ) ? $reviewer_url : '';

	}

	/**
	 * Sets reviewer image URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $reviewer_image_url Image URL of the reviewer on the platform.
	 */
	protected function set_reviewer_image_url( $reviewer_image_url ) {

		$this->reviewer_image_url = filter_var( $reviewer_image_url, FILTER_VALIDATE_URL ) ? $reviewer_image_url : '';

	}

	/**
	 * Sets time created.
	 *
	 * @since 1.0.0
	 *
	 * @param string $time_created Time at which the review was created on the platform.
	 */
	protected function set_time_created( $time_created ) {

		$this->time_created = sanitize_text_field( $time_created );

	}

}
