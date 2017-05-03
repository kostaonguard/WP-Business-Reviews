<?php

/**
 * Defines the WPBR_API_Call abstract class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Calls one of the supported reviews APIs.
 *
 * Each reviews platform API requires a unique request URL. This class
 * builds the request URL and initiates the call. The response body is
 * JSON-decoded for easier manipulation within WordPress.
 *
 * @since 1.0.0
 */
abstract class WPBR_API_Call {

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
	 * @since 1.0.0
	 *
	 * @param string $business_id ID of the business passed in the API request.
	 */
	public function __construct( $business_id ) {

		$this->business_id = $business_id;
		$this->request_url = $this->build_request_url();
		$this->body        = $this->call_api();

	}

	/**
	 * Builds the full URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	abstract protected function build_request_url();

	/**
	 * Retrieves the JSON-decoded response body from platform API.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON-decoded response body from platform API.
	 */
	protected function call_api() {

		// Call the platform API.
		$response = wp_remote_get( $this->request_url );

		// Return early if error.
		if( is_wp_error( $response ) ) {
			return false;
		}

		// Get just the body of the response.
		$body = wp_remote_retrieve_body( $response );

		// Return the response in a more manageable format.
		return json_decode( $body, true );

	}

	/**
	 * Gets the response body of the remote API call.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON-decoded response body.
	 */
	public function get_response_body() {

		return $this->body;

	}

}