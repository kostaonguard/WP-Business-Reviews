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
	 * ID of the business.
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
	 * Name of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $name;

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
	 * @var array
	 */
	protected $latitude;

	/**
	 * Longitude of the business location.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $longitude;

	/**
	 * Street address where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $street_address;

	/**
	 * City where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $city;

	/**
	 * State or province where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $state_province;

	/**
	 * Postal code where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $postal_code;

	/**
	 * Country where the business is located.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
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

		$this->business_id = $business_id;
		$this->platform    = $platform;

		if ( $this->business_exists() ) {

			$this->set_properties_from_post();

		} else {

			$this->set_properties_from_api();

		}

	}

	/**
	 * Checks if business exists in the database.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean Whether the business exists in the database.
	 */
	public function business_exists() {

		// TODO: Check database for existing business using $this->business_id.

		return false;

	}

	/**
	 * Inserts wpbr_business post into the database.
	 *
	 * @since 1.0.0
	 */
	public function insert_post() {

		// Define post meta.
		$meta_input = array(

			'wpbr_business_id'    => $this->business_id,
			'wpbr_platform'       => $this->platform,
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
			'post_title'  => $this->name,
			'post_name'   => $this->business_id,
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
	 * @param string $business_id ID of the business.
	 */
	protected function set_properties_from_post() {

		// TODO: Set properties from wpbr_business post in database.

	}

	/**
	 * Set properties based on remote API response.
	 *
	 * @since 1.0.0
	 */
	abstract protected function set_properties_from_api();

	/**
	 * Set business name from API response.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data Relevant portion of the API response.
	 */
	abstract protected function set_name_from_api( $data );

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
