<?php
/**
 * Defines the Field_Parser_Abstract class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field\Parser
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field\Parser;

/**
 * Recursively parses fields from a config.
 *
 * While the basic field parsing functionality can be reused across multiple
 * types of settings, the method to retrieve the field's value must be defined
 * in the concrete classes.
 *
 * @since 0.1.0
 */
abstract class Field_Parser_Abstract {
	/**
	* Creator of field objects.
	*
	* @since 0.1.0
	* @var string $field_factory
	*/
	protected $field_factory;

	/**
	 * Recursively parses fields from a config.
	 *
	 * When the parser finds a `fields` key, then each item within that array
	 * is assumed to be a complete field definition. The arguments within the
	 * definition are used to create a new `Field` object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or `Config` object.
	 * @return Fields[] Array of `Field` objects.
	 */
	abstract public function parse_fields( $config );
}
