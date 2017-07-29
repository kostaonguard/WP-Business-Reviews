<?php
/**
 * Defines the WPBR_Settings_API class
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
 * Provides the custom settings API for the plugin.
 *
 * @since 1.0.0
 */
class WPBR_Settings_API {
	public function render_field( $field ) {
		$view_dir_url = WPBR_PLUGIN_DIR . 'includes/admin/settings/views/';

		switch ( $field['type'] ) {
			case 'checkbox':
			case 'radio':
			case 'platform_status':
			case 'facebook_pages':
			case 'password':
				include $view_dir_url . 'field-password.php';
				break;
			default:
				return null;
		}
	}

	public static function define_settings() {
		$settings = array(
			'general'      => array(
				'id'       => 'general',
				'name'     => __( 'General', 'wpbr' ),
				'sections' => array(
					'platforms' => array(
						'id'      => 'platforms',
						'name'    => __( 'Platforms', 'wpbr' ),
						'heading' => __( 'Platform Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sWP Business Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'active_platforms' => array(
								'id'      => 'active_platforms',
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
						'id'      => 'google',
						'name'    => __( 'Google', 'wpbr' ),
						'heading' => __( 'Google Reviews Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sGoogle Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'platform_status_google' => array(
								'id'       => 'platform_status_google',
								'name'     => __( 'Platform Status', 'wpbr' ),
								'type'     => 'platform_status',
								'platform' => 'google',
							),
							'api_key_google_places'  => array(
								'id'   => 'api_key_google_places',
								'name' => __( 'Google Places API Key', 'wpbr' ),
								'desc' => sprintf(
									__( 'Enter a Google Places API Key required to retrieve business reviews. For step-by-step instructions, see docs on %sHow to Generate a Google Places API Key%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								'type' => 'password',
							),
						),
					),
					'facebook'  => array(
						'id'      => 'facebook',
						'name'    => __( 'Facebook', 'wpbr' ),
						'heading' => __( 'Facebook Reviews Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sFacebook Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'platform_status_facebook' => array(
								'id'       => 'platform_status_facebook',
								'name'     => __( 'Platform Status', 'wpbr' ),
								'type'     => 'platform_status',
								'platform' => 'facebook',
							),
							'facebook_pages'           => array(
								'id'   => 'facebook_pages',
								'name' => __( 'Facebook Pages', 'wpbr' ),
								'desc' => __( 'The connected Facebook account must have a role of Admin, Editor, Moderator, Advertiser, or Analyst in order to display reviews from the Page.', 'wbpr' ),
								'type' => 'facebook_pages',
							),
						),
					),
					'yelp'      => array(
						'id'      => 'yelp',
						'name'    => __( 'Yelp', 'wpbr' ),
						'heading' => __( 'Yelp Reviews Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sYelp Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'platform_status_yelp' => array(
								'id'       => 'platform_status_yelp',
								'name'     => __( 'Platform Status', 'wpbr' ),
								'type'     => 'platform_status',
								'platform' => 'yelp',
							),
							'yelp_client_id'       => array(
								'id'   => 'yelp_client_id',
								'name' => __( 'Yelp Client ID', 'wpbr' ),
								'type' => 'password',
							),
							'yelp_client_secret'   => array(
								'id'   => 'yelp_client_secret',
								'name' => __( 'Yelp Client Secret', 'wpbr' ),
								'type' => 'password',
							),
						),
					),
					'yp'        => array(
						'id'      => 'yp',
						'name'    => __( 'YP', 'wpbr' ),
						'heading' => __( 'YP Reviews Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sYP Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'platform_status_yp' => array(
								'id'       => 'platform_status_yp',
								'name'     => __( 'Platform Status', 'wpbr' ),
								'type'     => 'platform_status',
								'platform' => 'yp',
							),
							'api_key_yp'         => array(
								'id'   => 'api_key_yp',
								'name' => __( 'YP API Key', 'wpbr' ),
								'desc' => sprintf(
									__( 'Enter a Google Places API Key required to retrieve business reviews. For step-by-step instructions, see docs on %sHow to Generate a Google Places API Key%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								'type' => 'password',
							),
						),
					),
				),
			),
			'advanced'     => array(
				'id'       => 'advanced',
				'name'     => __( 'Advanced', 'wpbr' ),
				'sections' => array(
					'advanced' => array(
						'id'      => 'advanced',
						'name'    => __( 'Advanced', 'wpbr' ),
						'heading' => __( 'Advanced Settings', 'wpbr' ),
						'desc'    => sprintf(
							__( 'Need help? See docs on %sGoogle Reviews 101%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'plugin_styles'      => array(
								'id'      => 'plugin_styles',
								'name'    => __( 'Plugin Styles', 'wpbr' ),
								'desc'    => __( 'Decide whether to output CSS that styles the presentation of reviews.', 'wpbr' ),
								'type'    => 'radio',
								'options' => array(
									'enabled'  => __( 'Enabled', 'wpbr' ),
									'disabled' => __( 'Disabled', 'wpbr' ),
								),
							),
							'uninstall_behavior' => array(
								'id'      => 'uninstall_behavior',
								'name'    => __( 'Uninstall Behavior', 'wpbr' ),
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
				'id'       => 'pro_features',
				'name'     => __( 'Pro Features', 'wpbr' ),
				'sections' => array(
					'pro_features' => array(
						'id'      => 'pro_features',
						'name'    => __( 'Pro Features', 'wpbr' ),
						'heading' => __( 'Pro Features', 'wpbr' ),
						'desc'    => sprintf(
							__( 'See a full %sFeatures Comparison%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'pro_features_gallery' => array(
								'id'   => 'pro_features_gallery',
								'name' => __( 'Pro Features Gallery', 'wpbr' ),
								'type' => 'view',
							),
						),
					),
				),
			),
		);

		return $settings;
	}
}
