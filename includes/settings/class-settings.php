<?php
/**
 * Defines the Settings class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\View;
use WP_Business_Reviews\Includes\Settings\Serializer;
use WP_Business_Reviews\Includes\Settings\Deserializer;
use WP_Business_Reviews\Includes\Config;

/**
 * Retrieves and displays the plugin's settings.
 *
 * @since 0.1.0
 */
class Settings {
	/**
	 * The settings config.
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
	 * Retriever of information from the database.
	 *
	 * @since 0.1.0
	 * @var Deserializer $deserializer
	 */
	private $deserializer;

	/**
	 * Instantiates the Settings object.
	 *
	 * @since 0.1.0
	 *
	 * @param Config           $config           The Settings config.
	 * @param Field_Repository $field_repository A repository of `Field` objects.
	 * @param Deserializer     $deserializer     Retriever of information from the database.
	 */
	public function __construct(
		Config $config,
		Field_Repository $field_repository,
		Deserializer $deserializer
	) {
		$this->config           = $config;
		$this->field_repository = $field_repository;
		$this->deserializer     = $deserializer;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'set_field_values' ) );
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'render' ) );
	}

	/**
	 * Sets field values from the database.
	 *
	 * If a field value does not exist in the database, the default value as
	 * defined in the `Field` object will be used instead.
	 *
	 * @since 0.1.0
	 */
	public function set_field_values() {
		// Get all field objects from the repository.
		$field_objects = $this->field_repository->get_all();

		foreach ( $field_objects as $field_id => $field_object ) {
			$field_value = $this->deserializer->get( $field_id );

			if ( null === $field_value ) {
				$field_value = $field_object->get_arg( 'default' );
			}

			// Update the value of the field in the field repository.
			$this->field_repository->get( $field_id )->set_value( $field_value );
		}
	}

	/**
	 * Gets the active platforms.
	 *
	 * @since 0.1.0
	 *
	 * @return array Array of active platform slugs.
	 */
	public function get_active_platforms() {
		$active_platforms = $this->deserializer->get( 'active_platforms') ?: array();

		return $active_platforms;
	}

	/**
	 * Gets the currently connected platforms.
	 *
	 * @since 0.1.0
	 *
	 * @param array $platforms Array of platforms.
	 * @return array Array of connected platform slugs.
	 */
	public function get_connected_platforms( $platforms ) {
		$connected_platforms = array();

		foreach ( $platforms as $platform ) {
			$status = $this->deserializer->get( "{$platform}_platform_status", 'status' );
			if ( 'connected' === $status ) {
				$connected_platforms[] = $platform;
			}
		}

		return $connected_platforms;
	}

	/**
	 * Renders the settings UI.
	 *
	 * Active and connected platforms are used to determine platform visibility
	 * as well as connection status.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$active_platforms    = $this->get_active_platforms();
		$connected_platforms = $this->get_connected_platforms( $active_platforms );
		$view_object         = new View( WPBR_PLUGIN_DIR . 'views/settings/settings-main.php' );

		$view_object->render(
			array(
				'config'              => $this->config,
				'field_repository'    => $this->field_repository,
				'active_platforms'    => $active_platforms,
				'connected_platforms' => $connected_platforms,
			)
		);
	}
}
