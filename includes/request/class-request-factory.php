<?php
/**
 * Defines the Request_Factory class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Request;

use WP_Business_Reviews\Includes\Request\Request_Base;

/**
 * Creates new requests based on platform, business, and type.
 *
 * @since 0.1.0
 */
class Request_Factory {
	/**
	 * Instantiates a new request.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform Name of the review platform.
	 * @return Request_Base Request object.
	 */
	public function create( $platform ) {
		switch ( $platform ) {
			case 'google_places' :
				// TODO: Get key from settings.
				$url = add_query_arg(
					array(
						'query' => '',
						'key'   => '',
					),
					'https://maps.googleapis.com/maps/api/place/textsearch/json'
				);
				$request = new Request_Base( $url );
				break;
			case 'facebook' :
				break;
			case 'yelp' :
				// TODO: Get key from settings.
				$yelp_access_token = '';
				$url = add_query_arg(
					array(
						'term'     => '',
						'location' => '',
					),
					'https://api.yelp.com/v3/businesses/search'
				);
				$args = array(
					'user-agent' => '',
					'headers' => array(
						'authorization' => 'Bearer ' . $yelp_access_token,
					),
				);
				$request = new Request_Base( $url, $args );
				break;
			case 'yp' :
				$url = add_query_arg(
					array(
						'term' => '',
						'key'  => '',
					),
					'http://api2.yp.com/listings/v1/search'
				);
				$request = new Request_Base( $url );
				break;
			case 'wp_org' :
				break;
		}

		return $request;
	}
}
