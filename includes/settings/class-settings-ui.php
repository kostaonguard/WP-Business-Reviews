<?php
/**
 * Defines the Settings_UI class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Field\Field_Parser;
use WP_Business_Reviews\Includes\View;

/**
 * Provides the interface for the plugin's settings.
 *
 * The Settings UI depends upon a Config object which defines the structure of
 * tabs, panels, sections, and fields along with default values.
 *
 * @since 0.1.0
 */
class Settings_UI {
	/**
	 * Config object containing tabs, panels, sections, and fields.
	 *
	 * @since  0.1.0
	 * @var    Config
	 * @access private
	 */
	private $config;

	/**
	 * Active tab.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $active_tab;

	/**
	 * Active section.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $active_section;

	/**
	 * Repository that holds field objects.
	 *
	 * @since 0.1.0
	 * @var Field_Repository
	 */
	private $field_repository;

	/**
	 * Instantiates the Settings_UI object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config       Path to config or Config object.
	 * @param Field_Parser  $field_parser Parser to extract field definitions from config.
	 */
	public function __construct( $config, Field_Parser $field_parser ) {
		$this->config       = is_string( $config ) ? new Config( $config ): $config;
		$this->field_parser = $field_parser;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_settings', array( $this, 'init' ) );
		add_action( 'wpbr_review_page_settings', array( $this, 'render' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->active_tab       = ! empty( $_POST['wpbr_tab'] ) ? sanitize_text_field( $_POST['wpbr_tab'] )        : '';
		$this->active_section   = ! empty( $_POST['wpbr_section'] ) ? sanitize_text_field( $_POST['wpbr_section'] ): '';
		$this->field_repository = new Field_Repository( $this->field_parser->parse_config( $this->config ) );
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
				'field_repository' => $this->field_repository
			)
		);
	}
}
