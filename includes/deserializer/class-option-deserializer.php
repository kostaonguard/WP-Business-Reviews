<?php
/**
 * Defines the Option_Deserializer class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Deserializer
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Deserializer;

/**
 * Retrieves options from the database.
 *
 * @since 0.1.0
 */
class Option_Deserializer extends Deserializer_Abstract {
	/**
	 * @since 0.1.0
	 */
	public function get( $key, $default = false ) {
		return get_option( $this->prefix . $key, $default );
	}
}
