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
 * Creates the admin banner for the plugin.
 *
 * @since 1.0.0
 */
class Reviews_Builder {
	/**
	 * Reviews Builder config containing field groups and fields.
	 *
	 * @since  1.0.0
	 * @var    Config
	 * @access private
	 */
	private $config;

	/**
	 * Array of field group objects that populates the Reviews Builder controls.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $field_groups;

	public function __construct( Config $config ) {
		$this->config       = $config;
		$this->field_groups = $this->process_config( $config );

		// TODO: Use an actual Review_SET
		$this->review_set = array(
			'format' => 'reviews-list',
		);
	}

	public function register() {
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'render_view' ) );
	}

	/**
	 * Converts config to array of field group objects.
	 *
	 * @since  1.0.0
	 *
	 * @param Config $config Reviews Builder config.
	 * @return array Array of field objects.
	 */
	private function process_config( Config $config ) {
		if ( empty( $config ) ) {
			return array();
		}

		$field_groups = array();

		foreach ( $config as $field_group ) {
			if ( ! isset( $field_group['id'], $field_group['name'] ) ) {
				// Skip if field group ID or name is not set.
				continue;
			}

			// Create new field group based on the config item.
			$field_group_obj = new Field_Group( $field_group['id'], $field_group['name'] );

			// Populate the field group with individual fields.
			if ( isset( $field_group['fields'] ) ) {
				foreach ( $field_group['fields'] as $field ) {
					// Check if the field ID is set.
					if ( ! isset( $field['id'] ) ) {
						// Skip if field ID is not set.
						continue;
					}

					// Create new field.
					$field_obj = Field_Factory::create_field( $field );

					// TODO: Update value if set.

					$field_group_obj->add_field( $field_obj );
				}
			}

			// Add field object to field group.
			$field_groups[ $field_group['id'] ] = $field_group_obj;
		}

		return $field_groups;
	}

	/**
	 * Render the Reviews Builder view.
	 *
	 * @since 1.0.0
	 *
	 * @param string|View $view    View to render. Can be a path to a view file
	 *                             or an instance of a View object.
	 * @param array|null  $context Optional. Context variables for use in view.
	 */
	public function render_view() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-main.php' );
		$view_object->render( $this->field_groups );
	}
}
