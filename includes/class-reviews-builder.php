<?php
/**
 * Defines the Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Fields\Field_Factory;

/**
 * Provides the interface for building review sets.
 *
 * @since 0.1.0
 */
class Reviews_Builder {
	/**
	 * Config object containing sections and fields.
	 *
	 * @since  0.1.0
	 * @var    Config
	 * @access private
	 */
	private $config;

	/**
	 * Multidimensional array of field objects.
	 *
	 * @since  0.1.0
	 * @var    array
	 * @access private
	 */
	private $field_hierarchy;

	/**
	 * Instantiates a Reviews_Builder object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or Config object.
	 */
	public function __construct( $config ) {
		$config_object = is_string( $config ) ? new Config( $config ) : $config;
		$this->config  = $config_object;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'init' ) );
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'render' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		// Process the config to create field objects.
		$this->field_hierarchy = $this->process_config( $this->config );
	}

	/**
	 * Converts config to array of field objects.
	 *
	 * @since  0.1.0
	 *
	 * @param Config $config Config object.
	 * @return array Array of field objects.
	 */
	private function process_config( Config $config ) {
		if ( empty( $config ) ) {
			return array();
		}

		$field_hierarchy = $config;

		foreach ( $field_hierarchy as $section_id => $section_atts ) {
			if ( isset( $section_atts['fields'] ) ) {
				$field_objects = array();

				foreach ( $section_atts['fields'] as $field_id => $field_atts ) {
					// Create new field object and add to array.
					$field_objects[] = Field_Factory::create_field( $field_atts );
				}

				// Replace field attributes with field objects.
				$field_hierarchy[ $section_id ]['fields'] = $field_objects;
			}
		}

		return $field_hierarchy->getArrayCopy();
	}

	/**
	 * Renders the reviews builder.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-main.php' );
		$view_object->render(
			array(
				'field_hierarchy' => $this->field_hierarchy,
			)
		);
	}
}
