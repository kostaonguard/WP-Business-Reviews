<?php
/**
 * Defines the Settings class
 *
 * @package WP_Business_Reviews\Includes\Admin\Settings
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Settings;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Provides the Settings API for the plugin.
 *
 * Note this plugin does not use the WordPress Settings API.
 *
 * @since 1.0.0
 */
class Settings {
	public static function define_settings() {
		$settings = array(
			'tab_one' => array(
				'name' => __( 'Tab One', 'wpbr' ),
				'fields' => apply_filters( 'wpbr_settings_tab_one',
					array(
						'field_one' => array(
							'name' => __( 'Field One', 'wpbr' ),
							'desc' => __( 'The description of Field One.', 'wpbr' ),
							'type' => 'text',
						),
						'field_two' => array(
							'name' => __( 'Field Two', 'wpbr' ),
							'desc' => __( 'The description of Field Two.', 'wpbr' ),
							'type' => 'text',
						),
					)
				),
			),
			'tab_two' => array(
				'name' => __( 'Tab Two', 'wpbr' ),
				'fields' => apply_filters( 'wpbr_settings_tab_one',
					array(
						'field_three' => array(
							'name' => __( 'Field Three', 'wpbr' ),
							'desc' => __( 'The description of Field Three.', 'wpbr' ),
							'type' => 'text',
						),
						'field_Four' => array(
							'name' => __( 'Field Four', 'wpbr' ),
							'desc' => __( 'The description of Field Four.', 'wpbr' ),
							'type' => 'text',
						),
					)
				),
			),
		);

		return $settings;
	}
}
