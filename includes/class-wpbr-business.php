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
	protected $business_url;

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
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
		$this->post_slug   = $this->build_post_slug();

		// Attempt to retrieve post from database using the post slug.
		$post = get_page_by_path( $this->post_slug, OBJECT, 'wpbr_business' );

		if ( ! empty( $post ) ) {

			$this->set_properties_from_post( $post->ID );

		} else {

			// Request business data from API.
			$request  = WPBR_Request_Factory::create( $this->business_id, $this->platform );
			$business_data = $request->request_business();

			if ( ! is_wp_error( $business_data ) ) {

				// Standardize API response data to match class properties.
				$properties = $this->standardize_properties( $business_data );

				// Set properties from array of standardized key-value pairs.
				$this->set_properties_from_array( $properties );

			} else {

				echo '<pre>'; var_dump( $business_data ); echo '</pre>';

			}

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
	 * Standardizes business properties from the remote API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $business_data Relevant portion of the API response.
	 *
	 * @return array Standardized properties and values.
	 */
	abstract protected function standardize_properties( $business_data );

	/**
	 * Inserts wpbr_business post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {

		// Define post meta.
		$meta_input = array(

			'wpbr_business_id'    => $this->business_id,
			'wpbr_business_url'   => $this->business_url,
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
			'post_name'   => $this->post_slug,
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
		$this->post_id        = $post_id;
		$this->business_name  = get_the_title( $post_id );
		$this->business_url   = get_post_meta( $post_id, 'wpbr_business_url', true );
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
	 * Set properties from array of key-value pairs.
	 *
	 * @since 1.0.0
	 *
	 * @param array $properties Key-value pairs corresponding to class properties.
	 */
	protected function set_properties_from_array( $properties ) {

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
	 * Set business name.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_name Name of the business.
	 */
	public function set_business_name( $business_name ) {

		$this->business_name = sanitize_text_field( $business_name );

	}

	/**
	 * Set business URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $business_url URL of the business page on the platform.
	 */
	public function set_business_url( $business_url ) {

		$this->business_url = filter_var( $business_url, FILTER_VALIDATE_URL ) ? $business_url : '';

	}

	/**
	 * Set image URL.
	 *
	 * @since 1.0.0
	 *
	 * @param string $image_url URL of the business image.
	 */
	public function set_image_url( $image_url ) {

		$this->image_url = filter_var( $image_url, FILTER_VALIDATE_URL ) ? $image_url : '';

	}

	/**
	 * Set rating.
	 *
	 * @since 1.0.0
	 *
	 * @param float $rating Average numerical rating of the business.
	 */
	public function set_rating( $rating ) {

		$this->rating = is_numeric( $rating ) ? $rating : '';

	}

	/**
	 * Set rating count.
	 *
	 * @since 1.0.0
	 *
	 * @param int $rating_count Total number of ratings of the business.
	 */
	public function set_rating_count( $rating_count ) {

		$this->rating_count = is_int( $rating_count ) ? $rating_count : '';

	}

	/**
	 * Set phone number.
	 *
	 * @since 1.0.0
	 *
	 * @param string $phone Relevant portion of the API response.
	 */
	public function set_phone( $phone ) {

		$this->phone = sanitize_text_field( $phone );

	}

	/**
	 * Set street address.
	 *
	 * @since 1.0.0
	 *
	 * @param string $street_address Street address where the business is located.
	 */
	public function set_street_address( $street_address ) {

		$this->street_address = sanitize_text_field( $street_address );

	}

	/**
	 * Set city.
	 *
	 * @since 1.0.0
	 *
	 * @param string $city City where the business is located.
	 */
	public function set_city( $city ) {

		$this->city = sanitize_text_field( $city );

	}

	/**
	 * Set state/province.
	 *
	 * @since 1.0.0
	 *
	 * @param string $state_province State or province where the business is located.
	 */
	public function set_state_province( $state_province ) {

		$this->state_province = sanitize_text_field( $state_province );

	}

	/**
	 * Set postal code.
	 *
	 * @since 1.0.0
	 *
	 * @param string $postal_code Postal code where the business is located.
	 */
	public function set_postal_code( $postal_code ) {

		$this->postal_code = sanitize_text_field( $postal_code );

	}

	/**
	 * Set country.
	 *
	 * @since 1.0.0
	 *
	 * @param string $country Country where the business is located.
	 */
	public function set_country( $country ) {

		$this->country = sanitize_text_field( $country );

	}

	/**
	 * Set latitude.
	 *
	 * @since 1.0.0
	 *
	 * @param float $latitude Latitude of the business location.
	 */
	public function set_latitude( $latitude ) {

		$this->latitude = is_float( $latitude ) ? $latitude : '';

	}

	/**
	 * Set longitude.
	 *
	 * @since 1.0.0
	 *
	 * @param float $longitude Longitude of the business location.
	 */
	public function set_longitude( $longitude ) {

		$this->longitude = is_float( $longitude ) ? $longitude : '';

	}

}
