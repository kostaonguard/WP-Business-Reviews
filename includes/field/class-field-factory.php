<?php
/**
 * Defines the Field_Factory class
 *
 * @package WP_Business_Reviews\Includes\Field
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Field;

/**
 * Creates a Field object based on provided arguments.
 *
 * @since 0.1.0
 *
 * @see Field
 */
class Field_Factory {
	/**
	 * Creates a new instance of a Field object.
	 *
	 * @since 0.1.0
	 *
	 * @see WP_Business_Reviews\Includes\Field\Base_Field
	 *
	 * @param string $id   Unique identifier of the field.
	 * @param array  $args Field arguments.
	 *
	 * @return Field|boolean Instance of Field class or false.
	 */
	public static function create( $id, array $args = array() ) {
		// TODO: Add logic to return different field subclasses based on type.
		return new Base_Field( $id, $args );
	}
}
