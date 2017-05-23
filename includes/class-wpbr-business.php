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
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_name;


	/**
	 * ID of the business on the platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

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
	 * Array of metadata associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $meta;

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

		// Set metadata defaults stored as post meta in the database.
		$this->meta = array(
			'page_url'       => null,
			'image_url'      => null,
			'rating'         => null,
			'rating_count'   => null,
			'phone'          => null,
			'street_address' => null,
			'city'           => null,
			'state_province' => null,
			'postal_code'    => null,
			'country'        => null,
			'latitude'       => null,
			'longitude'      => null,
		);

		// Build a unique slug to identify post in the database.
		$this->post_slug = $this->build_post_slug();

		// Attempt to retrieve post from database using the post slug.
		$post = get_page_by_path( $this->post_slug, OBJECT, 'wpbr_business' );

		// Set properties from post if available, or else from remote API.
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
			'ID'          => $this->post_id,
			'post_type'   => 'wpbr_business',
			'post_title'  => $this->business_name,
			'post_name'   => $this->post_slug,
			'post_status' => 'publish',
			'meta_input'  => $meta_input,
			'tax_input'   => $tax_input,
		);

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
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	protected function set_properties_from_post( $post_id ) {
		$properties['post_id']       = $post_id;
		$properties['business_name'] = get_the_title( $post_id );

		// Define properties to set from post meta.
		$properties['meta'] = $this->meta;

		// Loop through and populate metadata.
		foreach ( $properties['meta'] as $key => $value ) {
			$properties['meta'][$key] = get_post_meta( $post_id, "wpbr_$key", true);
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

		if ( is_wp_error( $response ) ) {
			echo $response->get_error_message();
			return;
		} else {
			// Standardize API response data to match class properties.
			$business = $request->standardize_business( $response );

			if ( is_wp_error( $business ) ) {
				echo $business->get_error_message();
				return;
			}

			$this->set_properties( $business );
		}
	}

	/**
	 * Inserts or updates existing business post based on remote API response.
	 *
	 * @since 1.0.0
	 */
	public function update_reviews_from_api() {
		$this->set_properties_from_api();
		$this->insert_post();
	}
}
