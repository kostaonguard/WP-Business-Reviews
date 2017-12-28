<?php
/**
 * Defines the Plugin_Settings_Field_Parser class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field\Parser
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field\Parser;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Deserializer\Option_Deserializer;
use WP_Business_Reviews\Includes\Field\Field_Factory;

/**
 * Recursively parses fields from a settings config.
 *
 * This parser specifically caters to hierarchical settings configs made up of
 * sections and fields.
 *
 * @since 0.1.0
 */
class Plugin_Settings_Field_Parser extends Field_Parser_Abstract {
	/**
	* Settings retriever.
	*
	* @since 0.1.0
	* @var string $deserializer
	*/
	private $deserializer;

	/**
	 * Instantiates a Plugin_Settings_Field_Parser object.
	 *
	 * @since 0.1.0
	 *
	 * @param Field_Factory        $field_factory Creator of field objects.
	 * @param Option_Deserializer  $deserializer  Settings retriever.
	 */
	public function __construct(
		Field_Factory $field_factory,
		Option_Deserializer $deserializer
	) {
		$this->field_factory = $field_factory;
		$this->deserializer  = $deserializer;
	}

	/**
	 * @inheritDoc
	 */
	public function parse_fields( $config ) {
		$field_objects = array();
		$config = is_string( $config ) ? new Config( $config ): $config;

		// Convert config to array for processing.
		$config_array = $config->getArrayCopy();

		foreach ( $config_array as $key => $value ) {
			foreach ( $value['sections'] as $section ) {
				foreach ( $section['fields'] as $field_id => $field_args ) {
					// Create the field object from the field definition.
					$field_object = $this->field_factory->create( $field_id, $field_args );

					if ( $field_object ) {
						// Attempt to retrieve the field value.
						$field_value = $this->deserializer->get( $field_id );

						if ( null === $field_value ) {
							// Get the default value.
							$field_value = $field_object->get_arg( 'default' );
						}

						// Set the field value.
						$field_object->set_value( $field_value );

						// Add the field object to array of parsed fields.
						$field_objects[ $field_id ] = $field_object;
					}

				}
			}
		}

		return $field_objects;
	}
}
