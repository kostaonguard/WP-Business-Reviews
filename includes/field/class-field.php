<?php
/**
 * Defines the Field class
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
class Field {
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
	 * Instantiates a Field object.
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
		$this->args = wp_parse_args( $args, $this->get_default_args() );
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
	 * Gets default field arguments.
	 *
	 * @since 0.1.0
	 *
	 * @return array Default field arguments.
	 */
	public function get_default_args() {
		return array(
			'name'          => null,
			'type'          => 'text',
			'value'         => null,
			'default'       => null,
			'tooltip'       => null,
			'description'   => null,
			'wrapper_class' => null,
			'name_element'  => 'span',
			'placeholder'   => null,
			'options'       => array(),
			'is_subfield'   => false,
			'subfields'     => array(),
		);
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
	 * Gets a field argument.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the requested arg.
	 * @return mixed|null Value of the requested arg.
	 */
	public function get_arg( $key ) {
		if ( isset( $this->args[ $key ] ) ) {
			return $this->args[ $key ];
		}

		// Invalid key was provided.
		return null;
	}

	/**
	 * Sets a field argument.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the arg being set.
	 * @param mixed  $value Value of the arg being set.
	 * @return bool True if successful, false otherwise.
	 */
	public function set_arg( $key, $value ) {
		if ( isset( $this->args[ $key ] ) ) {
			$this->args[ $key ] = $value;
			return true;
		}

		// Invalid key was provided.
		return false;
	}

	/**
	 * Gets field value.
	 *
	 * @since 0.1.0
	 *
	 * @return mixed $value Field value.
	 */
	public function get_value() {
		/**
		 * Filters the field value being retrieved.
		 *
		 * @since 0.1.0
		 */
		return apply_filters( "wp_business_reviews_get_field_value_{$this->id}", $this->value );
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
		// Determine value if one is not directly passed.
		if ( null === $value ) {
			if ( isset( $this->args['value'] ) ) {
				// Set value as provided via constructor.
				$value = $this->args['value'];
			} elseif ( isset( $this->args['default'] ) ) {
				// Otherwise fall back to default value.
				$value = $this->args['default'];
			}
		}

		/**
		 * Filters the field value being set.
		 *
		 * @since 0.1.0
		 */
		$this->value = apply_filters( "wp_business_reviews_set_field_value_{$this->id}", $value );
	}

	/**
	 * Renders a given view.
	 *
	 * @since 0.1.0
	 */
	public function render() {
		if ( 'internal' === $this->args['type'] ) {
			return;
		}

		$view_object = new View( WPBR_PLUGIN_DIR . 'views/field/field.php' );
		$view_object->render(
			array(
				'id'    => $this->get_id(),
				'args'  => $this->get_args(),
				'value' => $this->get_value(),
			)
		);
	}
}
