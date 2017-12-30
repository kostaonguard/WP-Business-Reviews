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
	 * @inheritDoc
	 */
	public function get( $key, $subkey = false ) {
		$value = get_option( $this->prefix . $key );

		if ( false !== $subkey ) {
			if ( isset( $value[ $subkey ] ) ) {
				return $value[ $subkey ];
			} else {
				return null;
			}
		}

		return $value;
	}
}
