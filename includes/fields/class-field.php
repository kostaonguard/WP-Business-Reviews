<?php
/**
 * Defines the Field class
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Fields;

use WP_Business_Reviews\Includes\View;

/**
 * Implements a field based on provided attributes.
 *
 * @since 0.1.0
 */
class Field {
	// TODO: Update $atts DocBlock.

	/**
	 * Instantiates the Field object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $atts {
	 *     Optional. Field attributes.
	 *
	 *     @type string $id           Field ID.
	 *     @type string $name         Field name also used as label.
	 *     @type string $type         Field type to determine Field subclass.
	 *     @type string $default      Default field value.
	 *     @type string $value        Field value.
	 *     @type string $tooltip      Tooltip to clarify field purpose.
	 *     @type string $description  Description to clarify field use.
	 *     @type array  $control_atts Additional attributes for the control element.
	 *     @type array  $options      Field options for select/radios/checkboxes.
	 * }
	 */
	public function __construct( array $atts ) {
		$this->atts  = $atts;
	}

	/**
	 * Gets field attributes.
	 *
	 * @since 0.1.0
	 *
	 * @return array Field attributes.
	 */
	public function get_atts() {
		return $this->atts;
	}

	/**
	 * Set field attributes.
	 *
	 * @since 0.1.0
	 *
	 * @param array $atts Associative array of field attributes.
	 */
	public function set_atts( $atts ) {
		$this->atts = $atts;
	}

	/**
	 * Gets a single field attribute.
	 *
	 * @since 0.1.0
	 *
	 * @param string $att_key Key associated with the field attribute.
	 *
	 * @return string|array Value of the field attribute if it exists.
	 */
	public function get_att( $att_key ) {
		return isset( $this->atts[ $att_key ] )	? $this->atts[ $att_key ] : '';
	}

	/**
	 * Gets a single field attribute.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key   Key associated with the field attribute.
	 * @param string $value Value of the field attribute.
	 */
	public function set_att( $key, $value ) {
		$this->atts[ $key ] = $value;
	}

	/**
	 * Render a given view.
	 *
	 * @since 0.1.0
	 *
	 * @param string|View $view    View to render. Can be a path to a view file
	 *                             or an instance of a View object.
	 * @param array|null  $context Optional. Context variables for use in view.
	 */
	public function render( $view ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;
		$view_object->render(
			$this->get_atts(),
			true
		);
	}
}
