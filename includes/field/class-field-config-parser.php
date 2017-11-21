<?php
/**
 * Defines the Field_Config_Parser class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field;

/**
 * Recursively parses Field objects from a Config.
 *
 * The parser is capable of creating Field objects from field definitions
 * at various levels of nesting within a Config. Any array within the Config
 * that does not contain a `fields` key is skipped.
 *
 * @since 0.1.0
 */
class Field_Config_Parser {
	/**
	 * Instantiates the Field_Config_Parser object.
	 *
	 * @since 0.1.0
	 * @param string|Config $config Path to config or Config object.
	 */
	public function __construct( $config ) {
		$this->config = is_string( $config ) ? new Config( $config ) : $config;
	}

	/**
	 * Recursively parses Field objects from a Config.
	 *
	 * When the parser finds a 'fields' key, then each item within that array
	 * is considered to be a complete field definition. The arguments within
	 * the definition are used to create a new Field object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $array Associative array.
	 *
	 * @return Fields[] Array of Field objects.
	 */
	public function parse( array $array ) {
		$field_objects = array();

		foreach ( $config as $key => $value ) {
			if ( isset( $key['fields'] ) ) {
				foreach( $key['fields'] as 'field_id' => 'field_args' ) {
					$field_objects[] = Field_Factory::create( $field_id, $field_args );
				}
			} else {
				if ( is_array( $value ) ) {
					$this->parse( $value );
				}
			}
		}

		return $field_objects;
	}
}
