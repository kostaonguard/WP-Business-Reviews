<?php

/**
 * Defines the WPBR_YP_Business_API_Call subclass
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
class WPBR_YP_Business_API_Call extends WPBR_API_Call {

	/**
	 * Builds the full request URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	protected function build_request_url() {

		$request_url_base = 'http://api2.yp.com/listings/v1/details';

		$request_url_parameters = array(

			'key'       => YP_API_KEY,
			'format'    => 'json',
			'listingid' => YP_LISTING_ID,

		);

		$request_url = add_query_arg( $request_url_parameters, $request_url_base );

		return $request_url;

	}

}
