<?php
/**
 * Defines the Builder_Field_Parser class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field\Parser
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field\Parser;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Factory;

/**
 * Recursively parses fields from a settings config.
 *
 * This parser specifically caters to hierarchical settings configs made up of
 * sections and fields.
 *
 * @since 0.1.0
 */
class Builder_Field_Parser extends Field_Parser_Abstract {
	/**
	* Settings retriever.
	*
	* @since 0.1.0
	* @var string $deserializer
	*/
	private $deserializer;

	/**
	 * Instantiates a Builder_Field_Parser object.
	 *
	 * @since 0.1.0
	 *
	 * @param Field_Factory $field_factory Creator of field objects.
	 */
	public function __construct(
		Field_Factory $field_factory
	) {
		$this->field_factory = $field_factory;
	}

	/**
	 * @inheritDoc
	 */
	public function parse_fields( $config ) {
		$field_objects = array();
		$config = is_string( $config ) ? new Config( $config ): $config;

		// Convert config to array for processing.
		$config_array = $config->getArrayCopy();

		foreach ( $config_array as $section ) {
			foreach ( $section['fields'] as $field_id => $field_args ) {
				// Create the field object from the field definition.
				$field_object = $this->field_factory->create( $field_id, $field_args );

				if ( $field_object ) {
					// TODO: Attempt to retrieve the field value.

					// Add the field object to array of parsed fields.
					$field_objects[ $field_id ] = $field_object;
				}

			}
		}

		return $field_objects;
	}
}
