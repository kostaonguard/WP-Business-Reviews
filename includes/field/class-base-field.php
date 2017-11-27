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
 * Implements a basic field based on provided arguments.
 *
 * @since 0.1.0
 */
class Base_Field {
	/**
	 * Unique identifier of the field.
	 *
	 * @since 0.1.0
	 * @var string $id
	 */
	protected $id;

	/**
	 * Field arguments used to define field elements and their attributes.
	 *
	 * @since 0.1.0
	 * @var string $args
	 */
	protected $args;

	/**
	 * Field value.
	 *
	 * @since 0.1.0
	 * @var string $value
	 */
	protected $value;

	/**
	 * Instantiates a Base_Field object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $id Unique identifier of the field.
	 * @param array  $args {
	 *     Field arguments.
	 *
	 *     @type string $name           Optional. Field name also used as label.
	 *     @type string $type           Optional. Field type that determines which control is used.
	 *     @type string $default        Optional. Default value used if field value is not set.
	 *     @type string $tooltip        Optional. Tooltip that clarifies field purpose.
	 *     @type string $description    Optional. Description that clarifies field usage.
	 *     @type string $wrapper_class  Optional. CSS class assigned to the field wrapper.
	 *     @type string $name_element   Optional. Field name element. Accepts 'span' or 'label'.
	 *     @type string $placeholder    Optional. Placeholder text for input controls.
	 *     @type array  $options        Optional. Field options for select/radios/checkboxes.
	 * }
	 */
	public function __construct( $id, array $args ) {
		$this->id   = $id;
		$this->default_args = array(
			'name'          => '',
			'type'          => 'text',
			'default'       => '',
			'value'         => null,
			'tooltip'       => '',
			'description'   => '',
			'wrapper_class' => '',
			'name_element'  => 'span',
			'placeholder'   => '',
			'options'       => array(),
		);
		$this->args = wp_parse_args( $args, $this->default_args );
		$this->set_value();
	}

	/**
	 * Gets field ID.
	 *
	 * @since 0.1.0
	 *
	 * @return string Field ID.
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Gets field arguments.
	 *
	 * @since 0.1.0
	 *
	 * @return array Field arguments.
	 */
	public function get_args() {
		return $this->args;
	}

	/**
	 * Gets field value.
	 *
	 * @since 0.1.0
	 *
	 * @return mixed $value Field value.
	 */
	public function get_value() {
		return $this->value;
	}

	/**
	 * Sets field value.
	 *
	 * Field value is set to the passed value. If a value is not passed, then
	 * the field will attempt to set a default value.
	 *
	 * @since 0.1.0
	 *
	 * @param mixed $value Field value.
	 */
	public function set_value( $value = null ) {
		if ( null === $value ) {
			// No value passed, so set value to default.
			$this->value = isset( $this->args['default'] ) ? $this->args['default'] : '';
		} else {
			$this->value = $value;
		}
	}

	/**
	 * Renders a given view.
	 *
	 * @since 0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/field/field-main.php' );
		$view_object->render(
			array(
				'id'    => $this->get_id(),
				'args'  => $this->get_args(),
				'value' => $this->get_value(),
			)
		);
	}
}
