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
		$this->load_field_values();
	}

	/**
	 * Loads field values from the database.
	 *
	 * If a field value does not exist in the database, the default value as
	 * defined in the `Field` object will be used instead.
	 *
	 * @since 0.1.0
	 */
	private function load_field_values() {
		// Get all field objects from the repository.
		$field_objects = $this->field_repository->get_all();

		foreach ( $field_objects as $field_id => $field_object ) {
			$field_default = $field_object->get_arg( 'default' );

			// Attempt to retrieve database value for each field, or fall back to default.
			$field_value = $this->deserializer->get_value( $field_id, $field_default );

			// Update the value of the field in the field repository.
			$this->field_repository->get( $field_id )->set_value( $field_value );
		}
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_settings', array( $this, 'render' ) );
	}

	/**
	 * Renders the settings UI.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/settings/settings-main.php' );
		$view_object->render(
			array(
				'config'           => $this->config,
				'field_repository' => $this->field_repository,
			)
		);
	}
}
