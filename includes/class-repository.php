<?php
/**
 * Defines the Repository class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes;

/**
 * Holds a collection of objects.
 *
 * @since 0.1.0
 */
abstract class Repository {
	/**
	 * Allowed properties.
	 *
	 * @since 0.1.0
	 * @var array $properties
	 */
	protected $properties;

	/**
	 * Elements stored in the repository.
	 *
	 * @since 0.1.0
	 * @var array $elements
	 */
	protected $elements;

	/**
	 * Instantiates the Repository object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $elements Array of elements.
	 */
	public function __construct( array $elements = array() ) {
		$this->items = $items;
	}

	/**
	 * Find an element by its primary key or identifier.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the element to find.
	 */
	public function find( $key ) {

	}

	/**
	 * Finds all elements in the repository.
	 *
	 * @since 0.1.0
	 */
	public function find_all() {

	}

	/**
	 * Adds element to repository.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key     Key of the element to add.
	 * @param mixed  $element Element to add to the repository.
	 */
	public function add( $key, $element ) {
		if ( $this->is_allowed( $key ) ) {
			$this->elements[ $key ] = $element;
		}
	}

	/**
	 * Removes element from repository.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the element to remove.
	 */
	public function remove( $key ) {
		if ( $this->has( $key ) ) {
			unset( $this->elements[ $key ] );
		}
	}

	/**
	 * Checks if an element is in the repository.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the element to check.
	 * @return boolean True if element is set, false otherwise.
	 */
	public function has( $key ) {
		return isset( $this->elements[ $key ] );
	}

	/**
	 * Checks if an element is allowed to be set.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the element to check.
	 * @return boolean True if element is allowed to be set, false otherwise.
	 */
	public function is_allowed( $key ) {
		return isset( $this->properties[ $key ] );
	}
}
