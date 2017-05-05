<?php

/**
 * Defines the WPBR_Yelp_Business_API_Call subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Calls the YP API for business details.
 *
 * @since 1.0.0
 * @see WPBR_API_Call
 */
class WPBR_Yelp_Business_API_Call extends WPBR_API_Call {

	/**
	 * Retrieves the JSON-decoded response body from platform API.
	 *
	 * @since 1.0.0
	 *
	 * @return array JSON-decoded response body from platform API.
	 */
	protected function call_api() {

		// Call the platform API.
		$response = wp_remote_get( $this->request_url, array(

			'user-agent' => '',
			'headers' => array(

				'authorization' => 'Bearer ' . YELP_OAUTH_TOKEN,

			)

		) );

		// Return early if error.
		if( is_wp_error( $response ) ) {

			return $response;

		}

		// Get just the body of the response.
		$body = wp_remote_retrieve_body( $response );

		// Return the response in a more manageable format.
		return json_decode( $body, true );

	}

	/**
	 * Builds the full request URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	protected function build_request_url() {

		return "https://api.yelp.com/v3/businesses/{$this->business_id}";

	}

}
