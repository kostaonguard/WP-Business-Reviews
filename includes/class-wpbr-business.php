<?php

/**
 * Defines the WPBR_Business class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Implements the WPBR_Business object.
 *
 * This class checks for an existing business in the database, and if it does
 * not exist, an API call is generated to request the business data remotely.
 *
 * @since 1.0.0
 */
class WPBR_Business {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * ID of the business post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $post_id;

	/**
	 * Slug of the business post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $post_slug;

	/**
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_name;

	/**
	 * URL of the business page on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $page_url;

	/**
	 * URL of the business image.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $image_url;

	/**
	 * Average numerical rating of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var float
	 */
	protected $rating;

	/**
	 * Total number of ratings of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $rating_count;

	/**
	 * Formatted phone number of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $phone;

	/**
	 * Street address where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $street_address;

	/**
	 * City where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $city;

	/**
	 * State or province where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $state_province;

	/**
	 * Postal code where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $postal_code;

	/**
	 * Country where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $country;

	/**
	 * Latitude of the business location.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $latitude;

	/**
	 * Longitude of the business location.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $longitude;

	/**
	 * Constructor.
	 *
	 * If business post exists in database, then properties are set from post.
	 * Otherwise properties are set from platform API.
	 *
	 * @param string $business_id ID of the business.
	 * @param string $platform    Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id, $platform ) {
		$this->business_id = $business_id;
		$this->platform    = $platform;
		$this->post_slug   = $this->build_post_slug();

		// Attempt to retrieve post from database using the post slug.
		$post = get_page_by_path( $this->post_slug, OBJECT, 'wpbr_business' );

		if ( ! empty( $post ) ) {
			$this->set_properties_from_post( $post->ID );
		} else {
			$this->set_properties_from_api();
		}
	}

	/**
	 * Builds unique post slug by concatenating platform and business ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Slug of the business post in the database.
	 */
	protected function build_post_slug() {
		$post_slug = $this->platform . '-' . $this->business_id;
		$post_slug = str_replace( '_', '-', strtolower( $post_slug ) );

		return sanitize_title( $post_slug );
	}

	/**
	 * Inserts wpbr_business post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {
		// Define array of post elements.
		$postarr = array(
			'post_type'   => 'wpbr_business',
			'post_title'  => $this->business_name,
			'post_name'   => $this->post_slug,
			'post_status' => 'publish',
			'meta_input'  => array(
				'wpbr_business_id'    => $this->business_id,
				'wpbr_page_url'       => $this->page_url,
				'wpbr_image_url'      => $this->image_url,
				'wpbr_rating'         => $this->rating,
				'wpbr_rating_count'   => $this->rating_count,
				'wpbr_phone'          => $this->phone,
				'wpbr_latitude'       => $this->latitude,
				'wpbr_longitude'      => $this->longitude,
				'wpbr_street_address' => $this->street_address,
				'wpbr_city'           => $this->city,
				'wpbr_state_province' => $this->state_province,
				'wpbr_postal_code'    => $this->postal_code,
				'wpbr_country'        => $this->country,
			),
			'tax_input'   => array(
				'wpbr_platform' => $this->platform,
			),
		);

		// If post ID exists, update existing post.
		if ( ! empty( $this->post_id ) ) {

			$postarr['ID'] = $this->post_id;

		}

		// Insert or update post in database.
		wp_insert_post( $postarr );
	}

	/**
	 * Sets properties from array of key-value pairs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	protected function set_properties( array $properties ) {
		foreach ( $properties as $property => $value ) {
			$this->$property = $value;
		}
	}

	/**
	 * Sets properties from existing post in database.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	protected function set_properties_from_post( $post_id ) {
		$properties['post_id']       = $post_id;
		$properties['business_name'] = get_the_title( $post_id );

		// Define properties to set from post meta.
		// TODO: Add property for all meta fields, set in constructor, and add filter.
		$post_meta_properties = array(
			'page_url',
			'image_url',
			'rating',
			'rating_count',
			'phone',
			'street_address',
			'city',
			'state_province',
			'postal_code',
			'country',
			'latitude',
			'longitude',
		);

		foreach ( $post_meta_properties as $property ) {
			$properties[$property] = get_post_meta( $post_id, "wpbr_{$property}", true);
		}

		$this->set_properties( $properties );
	}

	/**
	 * Sets properties from remote API.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {
		$request    = WPBR_Request_Factory::create( $this->business_id, $this->platform );
		$response   = $request->request_business();

		if ( ! is_wp_error( $response ) ) {
			// Standardize API response data to match class properties.
			$properties = $request->standardize_business( $response );

			$this->set_properties( $properties );
		}
	}
}
