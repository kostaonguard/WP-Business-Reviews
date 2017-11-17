<?php
/**
 * Defines the Settings_UI class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Fields\Field_Factory;
use WP_Business_Reviews\Includes\View;
use WP_Business_Reviews\Includes\Admin\Admin_Notices;

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
	 * Admin notices.
	 *
	 * @since  0.1.0
	 * @var    array
	 * @access private
	 */
	private $notices;

	/**
	 * Multidimensional array of field objects.
	 *
	 * @since  0.1.0
	 * @var    array
	 * @access private
	 */
	private $field_hierarchy;

	/**
	 * Instantiates the Settings_UI object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or Config object.
	 */
	public function __construct( $config ) {
		$config_object = is_string( $config ) ? new Config( $config ) : $config;
		$this->config  = $config_object;
		$this->notices = new Admin_Notices();
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0j
	 */
	public function register() {
		add_action( 'wpbr_review_page_settings', array( $this, 'init' ) );
		add_action( 'wpbr_review_page_settings', array( $this, 'render' ) );
		add_action( 'wpbr_settings_notices_' . $this->active_section, array( $this->notices, 'render_notices' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$this->active_tab     = ! empty( $_POST['wpbr_tab'] ) ? sanitize_text_field( $_POST['wpbr_tab'] ) : '';
		$this->active_section = ! empty( $_POST['wpbr_section'] ) ? sanitize_text_field( $_POST['wpbr_section'] ) : '';

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

		foreach ( $field_hierarchy as $tab_id => $tab_atts ) {
			if ( isset( $tab_atts['sections'] ) ) {
				foreach ( $tab_atts['sections'] as $section_id => $section_atts ) {
					if ( isset( $section_atts['fields'] ) ) {
						$field_objects = array();
						foreach ( $section_atts['fields'] as $field_id => $field_atts ) {
							// Create new field object and add to array.
							$field_objects[] = Field_Factory::create_field( $field_atts );
						}
						// Replace field attributes with field objects.
						$field_hierarchy[ $tab_id ]['sections'][ $section_id ]['fields'] = $field_objects;
					}
				}
			}
		}

		return $field_hierarchy->getArrayCopy();
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
				'field_hierarchy' => $this->field_hierarchy,
			)
		);
	}
}
