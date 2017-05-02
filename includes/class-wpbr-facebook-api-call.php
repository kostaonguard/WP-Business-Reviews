<?php

/**
 * Defines the WPBR_Facebook_API_Call subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Calls the Facebook Graph API.
 *
 * @since 1.0.0
 * @see WPBR_API_Call
 */
class WPBR_Facebook_API_Call extends WPBR_API_Call {

	/**
	 * Builds the full request URL used in the API request.
	 *
	 * @since 1.0.0
	 *
	 * @return string URL used in the API request.
	 */
	protected function build_request_url() {

		$request_url_base = "https://graph.facebook.com/v2.9/{$this->business_id}/";

		$fields = array(
			'name',
			'overall_star_rating',
			'rating_count',
			'phone',
			'hours',
			'ratings',
		);

		$fields_value = implode( ',', $fields );

		$request_url_parameters = array(

			'fields' => $fields_value,
			'single_line_address',
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN, // Constant is temporary for testing.

		);

		$request_url = add_query_arg( $request_url_parameters, $request_url_base );

		return $request_url;

	}

}
