<?php
/**
 * Defines the Field class
 *
 * @package WP_Business_Reviews\Includes
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Fields;

use WP_Business_Reviews\Includes\View;

/**
 * Implements a field based on provided attributes.
 *
 * @since 1.0.0
 */
class Field {

	/**
	 * Default view used to render the field.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	const DEFAULT_VIEW = 'views/fields/field.php';

	/**
	 * Default view used to render the field.
	 *
	 * @since 1.0.0
	 * @access public
	 * @var string
	 */
	const DEFAULT_CONTROL_VIEW = 'views/fields/field.php';

	/**
	 * Instantiates the Field object.
	 *
	 * @since 1.0.0
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
	 *     @type string $view         View used to render the field.
	 * }
	 */
	public function __construct( array $atts, $value = null ) {
		if ( ! isset( $atts['id'], $atts['name'], $atts['control'] ) ) {
			return false;
		}

		$this->atts  = $atts;
		$this->value = $value;
	}

	/**
	 * Gets the field value.
	 *
	 * @since 1.0.0
	 *
	 * @return string Value of the field.
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Sets the field value.
	 *
	 * If a value is not provided, the default field attribute is used instead.
	 *
	 * @since 1.0.0
	 */
	public function set_value( $value = '' ) {
		$this->value = ! empty( $value ) ? $value : $this->atts['default'];
	}

	/**
	 * Gets field attributes.
	 *
	 * @since 1.0.0
	 *
	 * @return array Field attributes.
	 */
	public function get_atts() {
		return $this->atts;
	}

	/**
	 * Set field attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $atts Associative array of field attributes.
	 */
	public function set_atts( $atts ) {
		$this->atts = $atts;
	}

	/**
	 * Gets a single field attribute.
	 *
	 * @since 1.0.0
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
	 * @since 1.0.0
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
	 * @since 1.0.0
	 *
	 * @param string|View $view    View to render. Can be a path to a view file
	 *                             or an instance of a View object.
	 * @param array|null  $context Optional. Context variables for use in view.
	 */
	public function render_view( $view ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;
		$view_object->render(
			array(
				'atts'  => $this->get_atts(),
				'value' => $this->get_value(),
			)
		);
	}
}
