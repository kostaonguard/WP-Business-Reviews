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
	 * URL of the business image or avatar.
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
	 * Total reviews of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var int
	 */
	protected $review_count;

	/**
	 * Formatted phone number of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $phone;

	/**
	 * Formatted street address of the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $address;

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

			$this->set_properties_from_db;

		} else {

			$this->set_properties_from_api;

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
	 * Sets properties from existing post in database.
	 *
	 * @param string $business_id ID of the business.
	 *
	 * @since 1.0.0
	 */
	public function set_properties_from_db() {

		// TODO: Set properties from wpbr_business post in database.

	}

	/**
	 * Sets properties from remote API call.
	 *
	 * @param string $business_id ID of the business.
	 *
	 * @since 1.0.0
	 */
	public function set_properties_from_api() {

		new WPBR_Google_Places_API_Call( $this->business_id );

		// TODO: Set properties from API call response.

	}

}
