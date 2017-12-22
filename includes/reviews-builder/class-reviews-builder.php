<?php
/**
 * Defines the Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\Reviews_Builder
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Reviews_Builder;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\View;

/**
 * Provides the interface for building review sets.
 *
 * @since 0.1.0
 */
class Reviews_Builder {
	/**
	 * Config object containing section and field definitions.
	 *
	 * @since 0.1.0
	 * @var Config
	 */
	private $config;

	/**
	 * Repository that holds field objects.
	 *
	 * @since 0.1.0
	 * @var Field_Repository
	 */
	private $field_repository;

	/**
	 * Instantiates a Reviews_Builder object.
	 *
	 * @since 0.1.0
	 *
	 * @param Config           $config           Reviews Builder config.
	 * @param Field_Repository $field_repository Repository of `Field` objects.
	 */
	public function __construct( $field_repository ) {
		$this->config              = $config;
		$this->field_repository    = $field_repository;
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
				'config'           => $this->config,
				'field_repository' => $this->field_repository
			)
		);
	}
}
