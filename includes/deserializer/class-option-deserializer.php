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
 * Retrieves information from the database.
 *
 * @since 0.1.0
 */
class Option_Deserializer {
	/**
	 * Retrieves a value from the database.
	 *
	 * @since 0.1.0
	 *
	 * @param string $setting Name of the setting to retrieve.
	 * @param string $key     Optional. Specific array key for when the
	 *                        setting's value is an array.
	 */
	public function get( $setting, $key = false ) {
		$value = get_option( 'wp_business_reviews_' . $setting );

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
