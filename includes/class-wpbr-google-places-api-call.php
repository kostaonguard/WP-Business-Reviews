<?php

/**
 * Defines the WPBR_Google_Places_API_Call subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/***
 * Calls the Google Places API.
 *
 * @since 1.0.0
 * @see WPBR_API_Call
 */
class WPBR_Google_Places_API_Call extends WPBR_API_Call {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'google_places';

	/**
	 * Builds the full URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	protected function build_request_url() {

		$request_url_base = 'https://maps.googleapis.com/maps/api/place/details/json';

		$request_url_parameters = array(

			'placeid' => $this->business_id,
			'key'     => GOOGLE_PLACES_API_KEY, // Constant is temporary for testing.

		);

		$request_url = add_query_arg( $request_url_parameters, $request_url_base );

		return $request_url;

	}

}
