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
	const DEFAULT_VIEW = 'views/field.php';

	/**
	 * Field attributes.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $atts;

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
	 *     @type string $tooltip      Tooltip to clarify field purpose.
	 *     @type string $description  Description to clarify field use.
	 *     @type string $default      Default field value.
	 *     @type string $value        Field value.
	 *     @type array  $control_atts Additional attributes for the control element.
	 *     @type array  $options      Field options for select/radios/checkboxes.
	 *     @type string $view         View used to render the field.
	 * }
	 */
	public function __construct( array $atts = array() ) {
		$this->atts = $this->prepare_atts( $atts );
	}

	/**
	 * Gets field attributes.
	 *
	 * @return array Field attributes.
	 */
	public function get_atts() {
		return $this->atts;
	}

	/**
	 * Gets a single field attribute.
	 *
	 * @param string $att Key associated with an attribute.
	 *
	 * @return string|array Value of the field attribute if it exists.
	 */
	public function get_att( $key ) {
		return isset( $this->atts[ $key ] )	? $this->atts[ $key ] : '';
	}

	/**
	 * Merges default field attributes with provided attributes.
	 *
	 * @param array $atts Field attributes.
	 *
	 * @return array Fully populated field attributes.
	 */
	protected function prepare_atts( array $atts ) {
		$defaults = array(
			'id'           => '',
			'name'         => '',
			'tooltip'      => '',
			'type'         => '',
			'default'      => '',
			'value'        => '',
			'control_atts' => array(),
			'description'  => '',
			'options'      => array(),
			'view'         => self::DEFAULT_VIEW,
		);

		return wp_parse_args( $atts, $defaults );
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
		$view_object->render( $this->get_atts() );
	}
}
