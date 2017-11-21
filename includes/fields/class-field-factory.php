<?php

/**
 * Defines the Field_Factory class
 *
 * @package WP_Business_Reviews\Includes\Request
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Fields;

/**
 * Determines the appropriate Field subclass based on type.
 *
 * @since 0.1.0
 * @see   Request
 */
class Field_Factory {
	/**
	 * Field attributes.
	 *
	 * @since 0.1.0
	 * @access private
	 * @var array
	 */
	protected $atts;

	/**
	 * Creates a new instance of the Field subclass.
	 *
	 * @since 0.1.0
	 * @see Field
	 *
	 * @param array $atts Field attributes.
	 *
	 * @return Field|boolean Instance of Field class or false.
	 */
	public static function create_field( array $atts = array() ) {
		// Set default attributes applicable to all field types.
		$defaults = array(
			'id'            => '',
			'name'          => '',
			'type'          => 'text',
			'placeholder'   => '',
			'default'       => '',
			'value'         => '',
			'tooltip'       => '',
			'description'   => '',
			'wrapper_class' => '',
			'name_element'  => 'span',
		);

		// Use label element for certain field types.
		switch ( $atts['type'] ) {
			case 'input':
			case 'search':
			case 'select':
				$defaults['name_element'] = 'label';
				break;
		}

		// Merge provided field attributes with default attributes.
		$atts = wp_parse_args( $atts, $defaults );

		return new Field( $atts );
	}
}
