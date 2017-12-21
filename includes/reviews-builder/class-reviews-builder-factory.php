<?php
/**
 * Defines the Reviews_Builder_Factory class
 *
 * @package WP_Business_Reviews\Includes\Reviews_Builder
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Reviews_Builder;

use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Config;

/**
 * Creates a Reviews_Builder object based on provided platform.
 *
 * @since 0.1.0
 *
 * @see WP_Business_Reviews\Includes\Reviews_Builder\Reviews_Builder
 */
class Reviews_Builder_Factory {
	/**
	 * Creates a new instance of a Reviews_Builder object.
	 *
	 * @since 0.1.0
	 *
	 * @param string $platform The platform slug.
	 * @return Field|boolean Instance of Field class or false.
	 */
	public function create( $platform ) {
		$config = $this->get_config( $platform );
		$field_repository = $this->get_field_repository( $config );

		return new Reviews_Builder( $platform, $config, $field_repository );
	}

	/**
	 * Generates a config based on the provided platform.
	 *
	 * @param string $platform The platform slug.
	 * @return Config Reviews Builder config.
	 */
	private function get_config( $platform ) {
		return new Config( WPBR_PLUGIN_DIR . 'configs/config-reviews-builder-{$platform}.php' );
	}

	/**
	 * Generates a field respository based on the provided config.
	 *
	 * @param Config $config Reviews Builder config.
	 * @return Field_Repository Array of field objects.
	 */
	private function get_field_repository( Config $config ) {
		return new Field_Repository( $this->field_parser->parse_config( $config ) );
	}
}
