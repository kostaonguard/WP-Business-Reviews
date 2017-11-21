<?php
/**
 * Defines the Base_Field class
 *
 * @package WP_Business_Reviews\Includes\Field
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Field;

use WP_Business_Reviews\Includes\View;

/**
 * Implements a basic field based on provided attributes.
 *
 * @since 0.1.0
 */
class Base_Field {
	/**
	 * Instantiates a Base_Field object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $atts {
	 *     Field attributes.
	 *
	 *     @type string $id             Field ID. Must be unique.
	 *     @type string $name           Optional. Field name also used as label.
	 *     @type string $type           Optional. Field type that determines which control is used.
	 *     @type string $default        Optional. Default value used if field value is not set.
	 *     @type string $value          Optional. Field value.
	 *     @type string $tooltip        Optional. Tooltip that clarifies field purpose.
	 *     @type string $description    Optional. Description that clarifies field usage.
	 *     @type string $wrapper_class  Optional. CSS class assigned to the field wrapper.
	 *     @type string $name_element   Optional. Field name element. Accepts 'span' or 'label'.
	 *     @type string $placeholder    Optional. Placeholder text for input controls.
	 *     @type array  $options        Optional. Field options for select/radios/checkboxes.
	 * }
	 */
	public function __construct( array $atts ) {
		$this->atts = $atts;
		$this->set_value();
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
	 * Sets field attributes.
	 *
	 * @since 0.1.0
	 *
	 * @param array $atts Associative array of field attributes.
	 */
	public function set_atts( $atts ) {
		$this->atts = $atts;
	}

	/**
	 * Sets field value.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $value Field value.
	 */
	public function set_value( $value = null ) {
		if ( null === $value ) {
			// No value exists, so set value to default.
			$this->set_att( 'value', $this->atts['default'] );
		} else {
			// Value exists, so set it accordingly.
			$this->set_att( 'value', $value );
		}
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
	 * Renders a given view.
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
