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
class Option_Deserializer {
	/**
	 * Retrieves a value from the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $option  Name of the option to retrieve.
	 * @param string $key     Optional. Specific array key for when the
	 *                        option's value is an array.
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
