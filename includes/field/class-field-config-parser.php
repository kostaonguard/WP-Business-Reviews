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

use WP_Business_Reviews\Includes\Config;

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
	 * Parses the Config as an array.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or Config object.
	 * @return Fields[] Associative array of Field objects.
	 */
	public function parse_config( $config ) {
		$config = is_string( $config ) ? new Config( $config ) : $config;
		return $this->parse_array( $config->getArrayCopy() );
	}

	/**
	 * Recursively parses Field objects from an array.
	 *
	 * When the parser finds a 'fields' key, then each item within that array
	 * is assumed to be a complete field definition. The arguments within the
	 * definition are used to create a new Field object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $array Associative array.
	 *
	 * @return Fields[] Array of Field objects.
	 */
	protected function parse_array( array $array ) {
		$field_objects = array();

		foreach ( $array as $key => $value ) {
			if ( isset( $value['fields'] ) ) {
				foreach ( $value['fields'] as $field_id => $field_args ) {
					$field_objects[ $field_id ] = Field_Factory::create( $field_id, $field_args );
				}
			} else {
				echo 'no';
				if ( is_array( $value ) ) {
					$this->parse_array( $value );
				}
			}
		}

		return $field_objects;
	}
}
