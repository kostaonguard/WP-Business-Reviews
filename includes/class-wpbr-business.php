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
	 * The post slug is a concatenation of the platform and business ID,
	 * resulting in a unique
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $slug;

	/**
	 * Post ID of the business post in the database.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $post_id;

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
	 * @param string $platform Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id, $platform ) {

		$this->platform    = $platform;
		$this->business_id = $business_id;
		$this->slug        = $this->generate_slug();

		if ( $post_id = $this->post_exists( $this->slug ) ) {

			$this->post_id = $post_id;
			$this->set_properties_from_post( $this->post_id );

		} else {

			$this->set_properties_from_api( $this->business_id );
			$this->insert_post();

		}

	}

	/**
	 * Generates unique slug by combining platform and business ID.
	 *
	 * @since 1.0.0
	 *
	 * @param string $platform    Business platform.
	 * @param string $business_id Business ID.
	 * @return string Business post slug.
	 */
	protected function generate_slug( $platform, $business_id ) {

		$slug = $this->platform . '-' . $this->business_id;
		$slug = str_replace( '_', '-', strtolower( $slug ) );

		return sanitize_title( $slug );

	}

	/**
	 * Checks if business post exists in the database based on post slug.
	 *
	 * @since 1.0.0
	 *
	 * @param string $slug Business post slug.
	 * @return int Post ID if post exists, 0 otherwise.
	 */
	public function post_exists( $slug ) {

		if ( $post = get_page_by_path( $slug, OBJECT, 'wpbr_business' ) ) {

			return $post->ID;

		} else {

			return 0;

		}

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

		// Define post elements.
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

		echo 'Set from post.';

		// Set properties from post.
		$this->set_business_name_from_post( $post_id );
		$this->set_platform_url_from_post( $post_id );
		$this->set_image_url_from_post( $post_id );
		$this->set_rating_from_post( $post_id );
		$this->set_rating_count_from_post( $post_id );
		$this->set_phone_from_post( $post_id );
		$this->set_latitude_from_post( $post_id );
		$this->set_longitude_from_post( $post_id );
		$this->set_street_address_from_post( $post_id );
		$this->set_city_from_post( $post_id );
		$this->set_state_province_from_post( $post_id );
		$this->set_country_from_post( $post_id );
		$this->set_postal_code_from_post( $post_id );

	}

	/**
	 * Set business name from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_business_name_from_post( $post_id ) {

		$this->business_name = get_the_title( $post_id );

	}

	/**
	 * Set platform URL from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_platform_url_from_post( $post_id ) {

		$this->platform_url = get_post_meta( $post_id, 'wpbr_platform_url', true );

	}

	/**
	 * Set image URL from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_image_url_from_post( $post_id ) {

		$this->image_url = get_post_meta( $post_id, 'wpbr_image_url', true );

	}

	/**
	 * Set rating from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_rating_from_post( $post_id ) {

		$this->rating = get_post_meta( $post_id, 'wpbr_rating', true );

	}

	/**
	 * Set rating count from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_rating_count_from_post( $post_id ) {

		$this->rating_count = get_post_meta( $post_id, 'wpbr_rating_count', true );

	}

	/**
	 * Set phone number from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_phone_from_post( $post_id ) {

		$this->phone = get_post_meta( $post_id, 'wpbr_phone', true );

	}

	/**
	 * Set latitude from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_latitude_from_post( $post_id ) {

		$this->latitude = get_post_meta( $post_id, 'wpbr_latitude', true );

	}

	/**
	 * Set longitude from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_longitude_from_post( $post_id ) {

		$this->longitude = get_post_meta( $post_id, 'wpbr_longitude', true );

	}

	/**
	 * Set street address from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_street_address_from_post( $post_id ) {

		$this->street_address = get_post_meta( $post_id, 'wpbr_street_address', true );

	}

	/**
	 * Set city from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_city_from_post( $post_id ) {

		$this->city = get_post_meta( $post_id, 'wpbr_city', true );

	}

	/**
	 * Set state/province from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_state_province_from_post( $post_id ) {

		$this->state_province = get_post_meta( $post_id, 'wpbr_state_province', true );

	}

	/**
	 * Set postal code from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_postal_code_from_post( $post_id ) {

		$this->postal_code = get_post_meta( $post_id, 'wpbr_postal_code', true );

	}

	/**
	 * Set country from post.
	 *
	 * @since 1.0.0
	 *
	 * @param int $post_id ID of the business post.
	 */
	protected function set_country_from_post( $post_id ) {

		$this->country = get_post_meta( $post_id, 'wpbr_country', true );

	}

	/**
	 * Set properties based on remote API response.
	 *
	 * @since 1.0.0
	 * 
	 * @param string $business_id ID of the business.
	 */
	abstract protected function set_properties_from_api( $business_id );

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_business_name_from_api( $data );

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_platform_url_from_api( $data );

	/**
	 * Set image URL from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_image_url_from_api( $data );

	/**
	 * Set rating from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_rating_from_api( $data );

	/**
	 * Set rating count from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_rating_count_from_api( $data );

	/**
	 * Set phone number from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_phone_from_api( $data );

	/**
	 * Set latitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_latitude_from_api( $data );

	/**
	 * Set longitude from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_longitude_from_api( $data );

	/**
	 * Set street address from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_street_address_from_api( $data );

	/**
	 * Set city from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_city_from_api( $data );

	/**
	 * Set state/province from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_state_province_from_api( $data );

	/**
	 * Set postal code from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_postal_code_from_api( $data );

	/**
	 * Set country from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_country_from_api( $data );

}
