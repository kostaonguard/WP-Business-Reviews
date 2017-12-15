<?php
/**
 * Defines the Field_Parser class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Settings\Deserializer;

/**
 * Recursively parses fields from a config.
 *
 * The parser is capable of creating `Field` objects from field definitions
 * at various levels of nesting within a `Config`. Any array that does not
 * contain a `fields` key is skipped.
 *
 * @since 0.1.0
 */
class Field_Parser {
	/**
	* Settings retriever.
	*
	* @since 0.1.0
	* @var string $deserializer
	*/
	private $deserializer;

	/**
	 * Instantiates a Field_Parser object.
	 *
	 * @since 0.1.0
	 *
	 * @param Deserializer $deserializer Settings retriever.
	 */
	public function __construct( Deserializer $deserializer ) {
		$this->deserializer = $deserializer;
	}

	/**
	 * Parses the config as an array.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or `Config` object.
	 * @return Fields[] Associative array of `Field` objects.
	 */
	public function parse_config( $config ) {
		$config = is_string( $config ) ? new Config( $config ) : $config;

		return $this->parse_array( $config->getArrayCopy() );
	}

	/**
	 * Recursively parses fields from an array.
	 *
	 * When the parser finds a `fields` key, then each item within that array
	 * is assumed to be a complete field definition. The arguments within the
	 * definition are used to create a new `Field` object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $array Associative array.
	 *
	 * @return Fields[] Array of `Field` objects.
	 */
	protected function parse_array( array $array ) {
		$field_objects = array();

		foreach ( $array as $key => $value ) {
			if ( isset( $value['sections'] ) ) {
				// Assume sections are found within a tab defintion.
				foreach ( $value['sections'] as $section ) {
					foreach ( $section['fields'] as $field_id => $field_args ) {
						$field_objects[ $field_id ] = $this->create_field( $field_id, $field_args );
					}
				}
			} elseif ( isset( $value['fields'] ) ) {
				// Assume fields are found within a section defintiion.
				foreach ( $value['fields'] as $field_id => $field_args ) {
					$field_objects[ $field_id ] = $this->create_field( $field_id, $field_args );
				}
			}
		}

		return $field_objects;
	}

	/**
	 * Creates field object with value from database.
	 *
	 * @param string $id   Unique identifier of the field.
	 * @param array  $args Field arguments.
	 * @return Field|boolean Instance of Field class or false.
	 */
	protected function create_field( $field_id, $field_args ) {
		$field_object = Field_Factory::create( $field_id, $field_args );

		if ( ! $field_object ) {
			return false;
		}

		// Attempt to retrieve value from database.
		$field_value = $this->deserializer->get( $field_id );

		// If database returned no value, use the default field arg.
		if ( empty( $field_value ) ) {
			$field_value = $field_object->get_arg( 'default' );
		}

		$field_object->set_value( $field_value );

		return $field_object;
	}
}
