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
	 * Field attributes.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var array
	 */
	protected $atts;

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
	public static function create_field( array $atts = array() ) {
		// Set default attributes applicable to all field types.
		$defaults = array(
			'id'            => '',
			'name'          => '',
			'control'       => '',
			'default'       => '',
			'value'         => '',
			'tooltip'       => '',
			'description'   => '',
			'wrapper_class' => '',
			'name_element'  => 'label',
		);

		// Set additional defaults for certain field types.
		switch ( $atts['control'] ) {
			case 'input':
			case 'search':
				$defaults['input_atts'] = array();
				$defaults['datalist'] = array();
				break;
			case 'select':
				$defaults['options'] = array();
				break;
			case 'checkboxes':
			case 'radio':
				$defaults['name_element'] = 'span';
				$defaults['options'] = array();
				break;
		}

		// Merge provided field attributes with default attributes.
		$atts = wp_parse_args( $atts, $defaults );

		// Create new field object based on control type.
		switch ( $atts['control'] ) {
			default:
				return new Field( $atts );
		}
	}
}
