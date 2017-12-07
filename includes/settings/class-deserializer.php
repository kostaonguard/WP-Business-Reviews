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
	 * Retrieves a value from the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option Name of the option to retrieve.
	 * @param string $key    Optional. Specific array key for when the option
	 *                       is an array.
	 */
	public function get( $option, $key = false ) {
		$value = get_option( 'wp_business_reviews_' . $option );

		if ( false !== $key ) {
			if ( isset( $value[ $key ] ) ) {
				return $value[ $key ];
			} else {
				return null;
			}
		}

		return $value;
	}
}
