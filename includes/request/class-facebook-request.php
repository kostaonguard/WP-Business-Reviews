<?php
/**
 * Defines the Facebook_Request class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

use WP_Business_Reviews\Includes\Request\Request_Base;

/**
 * Retrieves data from Facebook Graph API.
 *
 * @since 0.1.0
 */
class Facebook_Request extends Request_Base {
	/**
	 * Instantiates the Facebook_Request object.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		// Pass dependencies to Facebook_Request.
	}

	/**
	 * Tests the connection to the API with a sample request.
	 *
	 * @since 0.1.0
	 *
	 * @return bool True if connection was successful, otherwise false.
	 */
	public function is_connected() {
		// Test connection.
	}

	/**
	 * Retrieves business details based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 */
	public function get_business( $id ) {
		// Get business details.
	}

	/**
	 * Retrieves reviews based on Yelp business ID.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id The Yelp business ID.
	 */
	public function get_reviews( $id ) {
		// Get reviews.
	}
}
