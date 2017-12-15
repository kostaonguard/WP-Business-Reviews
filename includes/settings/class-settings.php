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
use WP_Business_Reviews\Includes\Platform_Manager;

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
	 * Array of active platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $active_platforms
	 */
	private $active_platforms;

	/**
	 * Array of connected platform slugs.
	 *
	 * @since 0.1.0
	 * @var array $connected_platforms
	 */
	private $connected_platforms;

	/**
	 * Instantiates the Settings object.
	 *
	 * @since 0.1.0
	 *
	 * @param Config           $config              Settings config.
	 * @param Field_Repository $field_repository    Repository of `Field` objects.
	 * @param array            $active_platforms    Array of active platform slugs.
	 * @param array            $connected_platforms Array of connected platform slugs.
	 */
	public function __construct(
		Config $config,
		Field_Repository $field_repository,
		array $active_platforms,
		array $connected_platforms
	) {
		$this->config              = $config;
		$this->field_repository    = $field_repository;
		$this->active_platforms    = $active_platforms;
		$this->connected_platforms = $connected_platforms;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'render' ) );
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
		$view_object         = new View( WPBR_PLUGIN_DIR . 'views/settings/settings-main.php' );

		$view_object->render(
			array(
				'config'              => $this->config,
				'field_repository'    => $this->field_repository,
				'active_platforms'    => $this->active_platforms,
				'connected_platforms' => $this->connected_platforms,
			)
		);
	}
}
