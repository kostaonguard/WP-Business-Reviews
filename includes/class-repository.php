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
 * Holds a collection of values.
 *
 * Repositories provide persistent storage for values that need accessed
 * throughout the plugin. By storing values in a single location, the values
 * can be referenced for many purposes without requiring multiple instances.
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
	 * Values stored in the repository.
	 *
	 * @since 0.1.0
	 * @var array $values
	 */
	protected $values;

	/**
	 * Instantiates the Repository object.
	 *
	 * @since 0.1.0
	 *
	 * @param array $values Array of values.
	 */
	public function __construct( array $values = array() ) {
		$this->values = $values;
	}

	/**
	 * Find an element by its primary key or identifier.
	 *
	 * @since 0.1.0
	 *
	 * @param string $key Key of the element to find.
	 * @return mixed A single element from the repository.
	 */
	public function find( $key ) {
		if ( $this->has( $key ) ) {
			return $this->values[ $key ];
		}
	}

	/**
	 * Finds all values in the repository.
	 *
	 * @since 0.1.0
	 *
	 * @return array All values stored in the repository.
	 */
	public function find_all() {
		return $this->values;
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
			$this->values[ $key ] = $element;
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
			unset( $this->values[ $key ] );
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
		return isset( $this->values[ $key ] );
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
