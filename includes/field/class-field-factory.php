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
	 * The field type is used to set certain arguments, such as `name_element`
	 * that determines the HTML element used to display the field name.
	 *
	 * @since 0.1.0
	 *
	 * @see WP_Business_Reviews\Includes\Field\Field
	 *
	 * @param string $id   Unique identifier of the field.
	 * @param array  $args Field arguments.
	 *
	 * @return Field Instance of Field class or false.
	 */
	public function create( $id, array $args = array() ) {
		return new Field( $id, $args );
	}
}
