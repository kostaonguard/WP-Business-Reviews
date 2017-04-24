<?php

/**
 * Defines the WPBR_Response abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from one of the supported reviews APIs.
 *
 * Each reviews platform API returns a response with a unique structure. This
 * class normalizes that response by parsing the data into WPBR_Business and
 * WPBR_Review objects.
 *
 * @since 1.0.0
 */
abstract class WPBR_Response {

	/**
	 * Reviews platform associated with the business.
	 *
	 * e.g. 'google_places', 'facebook', 'yelp', 'yp'
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform;

	/**
	 * ID of the business used in the request URL.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $business_id;

	/**
	 * URL called in the API request.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $request_url;

	/**
	 * JSON-decoded response body from platform API.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $body;

	/**
	 * Constructor.
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 *
	 * @since 1.0.0
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
		$this->request_url = $this->build_request_url();
		$this->body        = $this->get_response();

	}

	/**
	 * Get JSON-decoded response body from platform API.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON-decoded response body from platform API.
	 */
	protected function get_response() {

		// Get response from platform API.
		$response = wp_remote_get( $request_url );

		// Return early if error.
		if( is_wp_error( $response ) ) {
			return false;
		}

		// Get just the body of the response.
		$body = wp_remote_retrieve_body( $response );

		// Return the response in a more manageable format.
		return json_decode( $body, true )

	}

	/**
	 * Builds the full URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	abstract protected function build_request_url();

}
