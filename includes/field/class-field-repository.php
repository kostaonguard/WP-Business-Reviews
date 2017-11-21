<?php
/**
 * Defines the Field_Repository class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Field
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Field;

/**
 * Stores Field objects.
 *
 * The field repository provides persistent storage for Field objects used
 * throughout the plugin. By housing Field objects in a single location, the
 * fields can be referenced for multiple purposes.
 *
 * @since 0.1.0
 */
class Field_Repository {
	/**
	 * Stored instances.
	 *
	 * @since 0.1.0
	 * @var array $items
	 */
	private $items;

	/**
	 * Instantiates the Field_Repository object.
	 *
	 * @since 0.1.0
	 *
	 * @param Field[] $items Array of Field objects.
	 */
	public function __construct( array $items = array() ) {
		$this->items = $items;
	}
}
