<?php

/**
 * Defines the Business class
 *
 * @link       https://wordimpress.com
 *
 * @package    WP_Business_Reviews
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

namespace WP_Business_Reviews\Includes\Business;
use WP_Business_Reviews\Includes\Request;

/**
 * Implements the Business object.
 *
 * This class checks for an existing business in the database, and if it does
 * not exist, an API call is generated to request the business data remotely.
 *
 * @since 1.0.0
 */
class Business {
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
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_name;

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
	 * @param string $platform Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id, $platform ) {
		$this->business_id = $business_id;
		$this->platform    = $platform;

		// Build a unique slug to identify post in the database.
		$this->post_slug = $this->build_post_slug();

		// Attempt to retrieve post from database using the post slug.
		$post = get_page_by_path( $this->post_slug, OBJECT, 'wpbr_business' );

		// Set properties from post if available, or else from remote API.
		if ( $post instanceof WP_Post ) {
			$this->set_properties_from_post( $post );
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
	 * @param WP_Post $post Business post object.
	 */
	protected function set_properties_from_post( $post ) {
		echo 'DATA FROM POST';

		$properties['post_id']       = $post->ID;
		$properties['business_name'] = $post->post_title;

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
	 * Sets properties from remote API.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {
		echo 'DATA FROM API';

		$request  = Request\Request_Factory::create( $this->business_id, $this->platform );
		$response = $request->request_business();

		if ( empty( $response ) ) {
			printf( __( 'Business Error: An empty response body was returned.' ) );

			return;
		} elseif ( is_wp_error( $response ) ) {
			/* translators: 1: Error code, 2: Error message. */
			printf( __( 'Business Error: [%1$s] %2$s' ) . '<br>', $response->get_error_code(), $response->get_error_message() );

			return;
		} else {
			// Standardize API response data to match class properties.
			$business = $request->standardize_business( $response );

			if ( is_wp_error( $business ) ) {
				/* translators: 1: Error code, 2: Error message. */
				printf( __( 'Business Error: %1$s' ) . '<br>', $business->get_error_message() );

				return;
			}

			$this->set_properties( $business );
		}
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

		if ( is_array( $this->meta ) ) {
			foreach ( $this->meta as $key => $value ) {
				$meta_input[ $key ] = $value;
			}
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
		$this->post_id = wp_insert_post( $postarr );
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
