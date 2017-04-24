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
 * Implements the WPBR_Business object which contains normalized business data
 * that has been parsed from a remote API response.
 *
 * @since 1.0.0
 */
abstract class WPBR_Business {

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



}
