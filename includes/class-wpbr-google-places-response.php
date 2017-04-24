<?php

/**
 * Defines the WPBR_Google_Places_Response subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from the Google Places API.
 *
 * This class normalizes the Google Places API response by parsing the data
 * into WPBR_Business and WPBR_Review objects.
 *
 * @since 1.0.0
 * @see WPBR_Response
 */
class WPBR_Google_Places_Response extends WPBR_Response {

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
