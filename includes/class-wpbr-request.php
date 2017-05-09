<?php

/**
 * Defines the WPBR_Request abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Requests data from remote API.
 *
 * Each reviews platform API requires a unique request. While the specific
 * requests are unique, functionality to request business and reviews data from
 * the API must be provided.
 *
 * @since 1.0.0
 */
abstract class WPBR_Request {

	/**
	 * ID of the business used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * Request business data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Business data or WP_Error on failure.
	 */
	abstract protected function request_business();

	/**
	 * Request reviews data from remote API.
	 *
	 * @since 1.0.0
	 *
	 * @return WP_Error|array Reviews data or WP_Error on failure.
	 */
	abstract protected function request_reviews();

}
