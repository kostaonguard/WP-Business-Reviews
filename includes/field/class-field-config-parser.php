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
	 * @since 0.1.0
	 *
	 * @return Fields[] Array of Field objects.
	 */
	public function parse() {
		$fields = array();

		// Loop through Config and add Field objects to array.

		return $fields;
	}
}
