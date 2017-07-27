<?php
/**
 * Defines the WPBR_Settings class
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
 * Provides the custom Settings API for the plugin.
 *
 * @since 1.0.0
 */
class WPBR_Settings {
	public static function define_settings() {
		$settings = array(
			'general'  => array(
				'name'     => __( 'General', 'wpbr' ),
				'sections' => array(
					'platforms' => array(
						'name'    => __( 'Platforms', 'wpbr' ),
						'heading' => __( 'Platform Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sWP Business Reviews 101%s', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/documentation/">',
							'</a>'
						),
						'fields'  => array(
							'active_platforms' => array(
								'name'    => __( 'Active Review Platforms', 'wpbr' ),
								'desc'    => __( 'Uncheck any review platform that is not in use to keep the plugin interface as clean as possible. Only active review platforms appear in Settings and are available for use within shortcodes and widgets.', 'wpbr' ),
								'type'    => 'checkbox',
								'options' => array(
									'google'   => __( 'Google', 'wpbr' ),
									'facebook' => __( 'Facebook', 'wpbr' ),
									'yelp'     => __( 'Yelp', 'wpbr' ),
									'yp'       => __( 'YP', 'wpbr' ),
								),
							),
						),
					),
					'google'    => array(
						'name'    => __( 'Google', 'wpbr' ),
						'heading' => __( 'Google Reviews Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sGoogle Reviews 101%s', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/documentation/">',
							'</a>'
						),
						'fields'  => array(
							'platform_status_google' => array(
								'name'     => __( 'Platform Status', 'wpbr' ),
								'type'     => 'platform_status',
								'platform' => 'google',
							),
							'api_key_google_places'  => array(
								'name' => __( 'Google Places API Key', 'wpbr' ),
								'desc' => sprintf(
									__( 'Enter a Google Places API Key required to retrieve business reviews. For step-by-step instructions, see docs on %sHow to Generate a Google Places API Key%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/documentation/">',
									'</a>'
								),
								'type' => 'api_key',
							),
						),
					),
					// TODO: Add other platforms here.
				),
			),
			'advanced' => array(
				'name'   => __( 'Advanced', 'wpbr' ),
				'sections' => array(
					'advanced' => array(
						'name'    => __( 'Advanced', 'wpbr' ),
						'heading' => __( 'Advanced Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sGoogle Reviews 101%s', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/documentation/">',
							'</a>'
						),
						'fields' => array(
							'plugin_styles'      => array(
								'name'    => __( 'Plugin Styles', 'wpbr' ),
								'desc'    => __( 'Decide whether to output CSS that styles the presentation of reviews.', 'wpbr' ),
								'type'    => 'radio',
								'options' => array(
									'enabled'  => __( 'Enabled', 'wpbr' ),
									'disabled' => __( 'Disabled', 'wpbr' ),
								),
							),
							'uninstall_behavior' => array(
								'name'    => __( 'Uninstall Behavior', 'wpbr' ),
								'desc'    => __( 'Decide whether to output CSS that styles the presentation of reviews.', 'wpbr' ),
								'type'    => 'radio',
								'options' => array(
									'keep'   => __( 'Keep all plugin settings and reviews data if this plugin is uninstalled.', 'wpbr' ),
									'remove' => __( 'Remove all plugin settings and reviews data if this plugin is uninstalled.', 'wpbr' ),
								),
							),
						),
					),
				),
			),
			'pro_features' => array(
				'name'   => __( 'Pro Features', 'wpbr' ),
				'sections' => array(
					'pro_features' => array(
						'name'    => __( 'Pro Features', 'wpbr' ),
						'heading' => __( 'Pro Features', 'wpbr' ),
						'desc'    => sprintf(
							__( 'See a full %sFeatures Comparison%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields' => array(
							'pro_features_gallery'      => array(
								'name'    => __( 'Pro Features Gallery', 'wpbr' ),
								'type'    => 'view',
							),
						),
					),
				),
			),
		);

		return $settings;
	}
}
