<?php

/**
 * Defines the WPBR_Facebook_Response subclass
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Normalizes the response from the Facebook Graph API.
 *
 * This class normalizes the Facebook Graph API response by parsing the data
 * into WPBR_Business and WPBR_Review objects.
 *
 * @since 1.0.0
 * @see WPBR_Response
 */
class WPBR_Facebook_Response extends WPBR_Response {

	/**
	 * Reviews platform associated with the business.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $platform = 'facebook';

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
			'single_line_address',
			'phone',
			'hours',
			'ratings',
		);

		$fields_value = implode( ',', $fields );

		$request_url_parameters = array(

			'fields' => $fields_value,
			'access_token' => FACEBOOK_PAGE_ACCESS_TOKEN, // Constant is temporary for testing.

		);

		$request_url = add_query_arg( $request_url_parameters, $request_url_base );

		return $request_url;

	}

}
