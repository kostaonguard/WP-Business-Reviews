<?php
/**
 * Defines the Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

/**
 * Retrieves information from the database.
 *
 * @since 0.1.0
 */
class Deserializer {
	/**
	 * Retrieves value that matches the specified key.
	 *
	 * @since 0.1.0
	 */
	public function get( $key, $default ) {
		return get_option( 'wp_business_reviews_' . $key, $default );
	}
}
