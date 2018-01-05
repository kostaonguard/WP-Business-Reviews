<?php
/**
 * Defines the Platform_Search class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Request\Request_Factory;

/**
 * Searches a remote reviews platform.
 *
 * @since 0.1.0
 */
class Platform_Search {
	/**
	 * Instantiates the Platform_Search object.
	 *
	 * @param Request_Factory $request_factory Factory that creates requests
	 *                                         based on platform ID.
	 */
	public function __construct( Request_Factory $request_factory ) {
		$this->request_factory = $request_factory;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wp_ajax_wpbr_platform_search', array( $this, 'ajax_search' ) );
	}

	/**
	 * Searches a remote reviews platform using arguments from Ajax request.
	 *
	 * @since 0.1.0
	 */
	public function ajax_search() {

	}

	/**
	 * Searches a remote reviews platform using provided arguments.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The review platform ID.
	 * @param string $terms    The search terms.
	 * @param string $location The search location.
	 * @return array Associative array containing the response body.
	 */
	public function search( $platform, $terms, $location ) {
		error_log( print_r( $_REQUEST, true ) );
		wp_die();
	}
}
