<?php

/**
 * Defines the WPBR_Business abstract class
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
abstract class WPBR_Business {

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
	 * Slug of the business post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $slug;

	/**
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_name;

	/**
	 * URL of the business page on the reviews platform.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform_url;

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
	 * Constructor.
	 *
	 * @param string $business_id ID of the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
		$this->slug        = $this->create_slug();

		if ( $post_id = $this->post_exists() ) {

			$this->set_properties_from_post( $post_id );

		} else {

			$this->set_properties_from_api();

		}

	}

	/**
	 * Creates unique slug by concatenating platform and business ID.
	 *
	 * @since 1.0.0
	 *
	 * @return string Business post slug.
	 */
	protected function create_slug() {

		$slug = $this->platform . '-' . $this->business_id;
		$slug = str_replace( '_', '-', strtolower( $slug ) );

		return sanitize_title( $slug );

	}

	/**
	 * Checks if business post exists in the database based on post slug.
	 *
	 * @since 1.0.0
	 *
	 * @return int Post ID if post exists, 0 otherwise.
	 */
	public function post_exists() {

		if ( $post = get_page_by_path( $this->slug, OBJECT, 'wpbr_business' ) ) {

			return $post->ID;

		}

		return 0;

	}

	/**
	 * Inserts wpbr_business post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {

		// Define post meta.
		$meta_input = array(

			'wpbr_platform'       => $this->platform,
			'wpbr_business_id'    => $this->business_id,
			'wpbr_platform_url'   => $this->platform_url,
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

		);

		// Define taxonomy terms.
		$tax_input = array(

			'wpbr_platform' => $this->platform,

		);

		// Define array of post elements.
		$postarr = array(

			'post_type'   => 'wpbr_business',
			'post_title'  => $this->business_name,
			'post_name'   => $this->slug,
			'post_status' => 'publish',
			'meta_input'  => $meta_input,
			'tax_input'   => $tax_input,

		);

		// Insert or update post in database.
		wp_insert_post( $postarr );

	}

	/**
	 * Sets properties from existing post in database.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	protected function set_properties_from_post( $post_id ) {

		echo '<br><strong>SET FROM POST</strong>';

		// Set properties from post.
		$this->business_name  = get_the_title( $post_id );
		$this->platform_url   = get_post_meta( $post_id, 'wpbr_platform_url', true );
		$this->image_url      = get_post_meta( $post_id, 'wpbr_image_url', true );
		$this->rating         = get_post_meta( $post_id, 'wpbr_rating', true );
		$this->rating_count   = get_post_meta( $post_id, 'wpbr_rating_count', true );
		$this->phone          = get_post_meta( $post_id, 'wpbr_phone', true );
		$this->latitude       = get_post_meta( $post_id, 'wpbr_latitude', true );
		$this->longitude      = get_post_meta( $post_id, 'wpbr_longitude', true );
		$this->street_address = get_post_meta( $post_id, 'wpbr_street_address', true );
		$this->city           = get_post_meta( $post_id, 'wpbr_city', true );
		$this->state_province = get_post_meta( $post_id, 'wpbr_state_province', true );
		$this->postal_code    = get_post_meta( $post_id, 'wpbr_postal_code', true );
		$this->country        = get_post_meta( $post_id, 'wpbr_country', true );

	}

	/**
	 * Set properties from remote API response.
	 *
	 * @since 1.0.0
	 */
	protected function set_properties_from_api() {

		echo '<br><strong>SET FROM API</strong>';

		// Request business data from API.
		$request = WPBR_Request_Factory::create( $this->business_id, $this->platform );
		$data    = $request->request_business();

		// Standardize data in preparation for setting properties.
		$standardized_data = $this->standardize_response( $data );

		// Set properties.
		foreach ( $standardized_data as $property => $value ) {

			if ( ! empty( $value ) ) {

				// Build function name (e.g. set_business_name_from_api).
				$setter = 'set_' . $property;

				// Set property.
				if ( method_exists( $this, $setter ) ) {

					$this->$setter( $value );

				}

			} else {

				$this->$property = '';

			}

		}

	}

	/**
	 * Standardizes data from the remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	abstract protected function standardize_response( $data );

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_name Name of the business.
	 */
	public function set_business_name( $business_name ) {

		$this->business_name = sanitize_text_field( $business_name );

	}

	/**
	 * Set platform URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $platform_url URL of the business page on the reviews platform.
	 */
	public function set_platform_url( $platform_url ) {

		$this->platform_url = filter_var( $platform_url, FILTER_VALIDATE_URL ) ? $platform_url : '';

	}

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url URL of the business image.
	 */
	public function set_image_url( $image_url ) {

		$this->image_url = filter_var( $image_url, FILTER_VALIDATE_URL ) ? $image_url : '';

	}

	/**
	 * Set rating from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param float $rating Average numerical rating of the business.
	 */
	public function set_rating( $rating ) {

		$this->rating = is_numeric( $rating ) ? $rating : '';

	}

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param int $rating_count Total number of ratings of the business.
	 */
	public function set_rating_count( $rating_count ) {

		$this->rating_count = is_int( $rating_count ) ? $rating_count : '';

	}

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $phone Relevant portion of the API response.
	 */
	public function set_phone( $phone ) {

		$this->phone = sanitize_text_field( $phone );

	}

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param float $latitude Latitude of the business location.
	 */
	public function set_latitude( $latitude ) {

		$this->latitude = is_float( $latitude ) ? $latitude : '';

	}

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param float $longitude Longitude of the business location.
	 */
	public function set_longitude( $longitude ) {

		$this->longitude = is_float( $longitude ) ? $longitude : '';

	}

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $street_address Street address where the business is located.
	 */
	public function set_street_address( $street_address ) {

		$this->street_address = sanitize_text_field( $street_address );

	}

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $city City where the business is located.
	 */
	public function set_city( $city ) {

		$this->city = sanitize_text_field( $city );

	}

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $state_province State or province where the business is located.
	 */
	public function set_state_province( $state_province ) {

		$this->state_province = sanitize_text_field( $state_province );

	}

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $postal_code Postal code where the business is located.
	 */
	public function set_postal_code( $postal_code ) {

		$this->postal_code = sanitize_text_field( $postal_code );

	}

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param string $country Country where the business is located.
	 */
	public function set_country( $country ) {

		$this->country = sanitize_text_field( $country );

	}

}
