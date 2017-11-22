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
		$this->args = wp_parse_args( $args, $this->default_args() );
		$this->set_value();
	}

	/**
	 * Retrieves the default field arguments.
	 *
	 * @since 0.1.0
	 *
	 * @return array Default field arguments.
	 */
	protected function default_args() {
		// Set default attributes applicable to all field types.
		$defaults = array(
			'name'          => '',
			'type'          => 'text',
			'default'       => '',
			'value'         => '',
			'tooltip'       => '',
			'description'   => '',
			'wrapper_class' => '',
			'name_element'  => 'span',
			'placeholder'   => '',
			'options'       => array(),
		);

		// Use type to determine if label is appropriate for accessibility.
		if ( isset( $this->args['type'] ) ) {
			switch ( $this->args['type'] ) {
				case 'input':
				case 'search':
				case 'select':
					$defaults['name_element'] = 'label';
					break;
			}
		}

		return $defaults;
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
		return $this->value();
	}

	/**
	 * Sets field value.
	 *
	 * Field value is set to the passed argument. If an argument is not set,
	 * then the field will attempt to set a default value.
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
	 *
	 * @param string|View $view    View to render. Can be a path to a view file
	 *                             or an instance of a View object.
	 * @param array|null  $context Optional. Context variables for use in view.
	 */
	public function render( $view, $context ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;
		$view_object->render(
			$context
		);
	}
}
