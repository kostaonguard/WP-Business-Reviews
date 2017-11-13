<?php
/**
 * Defines the Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Fields\Field_Factory;
use WP_Business_Reviews\Includes\Fields\Field_Group;
use WP_Business_Reviews\Includes\Fields\Field_Config_Processor;

/**
 * Provides the interface for building review sets.
 *
 * @since 1.0.0
 */
class Reviews_Builder {
	/**
	 * Config object containing sections and fields.
	 *
	 * @since  1.0.0
	 * @var    Config
	 * @access private
	 */
	private $config;

	/**
	 * Multidimensional array of field objects.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $field_hierarchy;

	/**
	 * Instantiates a Reviews_Builder object.
	 *
	 * @since 1.0.0
	 *
	 * @param string|Config $config Path to config or Config object.
	 */
	public function __construct( $config ) {
		$config_object = is_string( $config ) ? new Config( $config ) : $config;
		$this->config  = $config_object;

		// TODO: Use an actual Review_SET
		$this->review_set = array(
			'format' => 'reviews-list',
		);
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 1.0.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'init' ) );
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'render' ) );
	}

	/**
	 * Initializes processes that prepare the class for use.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		// Process the config to create field objects.
		$this->field_hierarchy = $this->process_config( $this->config );
	}

	/**
	 * Converts config to array of field objects.
	 *
	 * @since  1.0.0
	 *
	 * @param Config $config Config object.
	 * @return array Array of field objects.
	 */
	private function process_config( Config $config ) {
		if ( empty( $config ) ) {
			return array();
		}

		$field_hierarchy = array();

		foreach ( $config as $section ) {
			if ( ! isset( $section['id'], $section['name'] ) ) {
				// Skip if field group ID or name is not set.
				continue;
			}

			$field_objects = array();

			// Populate the section with individual field objects.
			if ( isset( $section['fields'] ) ) {
				foreach ( $section['fields'] as $field_atts ) {
					if ( ! isset( $field_atts['id'] ) ) {
						continue;
					}

					// TODO: Update value if set.
					$field_value = null;

					// Add field object to array.
					$field_objects[] = Field_Factory::create_field( $field_atts, $field_value );
				}
			}

			// Add section to field hierarchy.
			$field_hierarchy[ $section['id'] ] = array(
				'id'   => $section['id'],
				'name' => $section['name'],
				'fields' => $field_objects,
			);
		}

		return $field_hierarchy;
	}

	/**
	 * Renders the reviews builder.
	 *
	 * @since  1.0.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-main.php' );
		$view_object->render( $this->field_hierarchy );
	}
}
