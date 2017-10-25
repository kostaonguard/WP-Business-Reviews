<?php

/**
 * Defines the Field_Factory class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Fields;

/**
 * Determines the appropriate Field subclass based on type.
 *
 * @since 1.0.0
 * @see   Request
 */
class Field_Factory {

	/**
	 * Creates a new instance of the Field subclass.
	 *
	 * @since 1.0.0
	 * @see Field
	 *
	 * @param array $atts Field attributes.
	 *
	 * @return Field|boolean Instance of Field class or false.
	 */
	public static function create( array $atts = array() ) {
		if ( ! isset( $atts['type'] ) ) {
			return false;
		}

		switch ( $atts['type'] ) {
			default:
				return new Field( $atts );
		}

	}
}
