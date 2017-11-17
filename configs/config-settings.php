<?php
/**
 * Defines the settings config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

/**
 * Filters the entire plugin settings config.
 *
 * @since 0.1.0
 *
 * @param array $config Settings config containing tabs, panels,
 *                      sections, and fields.
 */
$config = apply_filters(
	'wpbr_config_settings',
	array(
		'general'  => array(
			'id'       => 'general',
			'name'     => __( 'General', 'wpbr' ),
			/**
			 * Filters the sections in the General panel.
			 *
			 * @since 0.1.0
			 *
			 * @param array $sections Settings sections.
			 */
			'sections' => apply_filters(
				'wpbr_settings_section_general',
				array(
					'platforms'     => array(
						'id'          => 'platforms',
						'name'        => __( 'Platforms', 'wpbr' ),
						'heading'     => __( 'Platform Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sWP Business Reviews 101%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'icon'        => 'gears',
						/**
						 * Filters the fields in the Platform section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_platforms',
							array(
								'active_platforms' => array(
									'id'          => 'active_platforms',
									'name'        => __( 'Active Review Platforms', 'wpbr' ),
									'control'     => 'checkboxes',
									'description' => __( 'Determines which review platforms are visible throughout the plugin. Only active review platforms appear in Settings and are available for use within shortcodes and widgets.', 'wpbr' ),
									'default'     => array(
										'google_places',
										'facebook',
										'yelp',
									),
									'options'     => array(
										'google_places' => __( 'Google', 'wpbr' ),
										'facebook'      => __( 'Facebook', 'wpbr' ),
										'yelp'          => __( 'Yelp', 'wpbr' ),
										'yp'            => __( 'YP', 'wpbr' ),
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'save_platforms'   => array(
									'id'      => 'save_platforms',
									'control' => 'save',
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
					'google_places' => array(
						'id'          => 'google_places',
						'name'        => __( 'Google', 'wpbr' ),
						'heading'     => __( 'Google Reviews Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sGoogle Reviews 101%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'icon'        => 'status',
						/**
						 * Filters the fields in the Google Places section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_google_places',
							array(
								'platform_status_google_places' => array(
									'id'       => 'platform_status_google_places',
									'name'     => __( 'Platform Status', 'wpbr' ),
									'control'  => 'platform_status',
									'default'  => 'disconnected',
									'platform' => 'google_places',
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'api_key_google_places'         => array(
									'id'           => 'api_key_google_places',
									'name'         => __( 'Google Places API Key', 'wpbr' ),
									'control'      => 'input',
									'description'  => sprintf(
										/* translators: link to documentation */
										__( 'Defines the Google Places API Key required to retrieve Google reviews. For step-by-step instructions, see docs on %1$sHow to Generate a Google Places API Key%2$s.', 'wbpr' ),
										'<a href="https://wpbusinessreviews.com/">',
										'</a>'
									),
									'control_atts' => array(
										'type' => 'text',
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'save_google_places'            => array(
									'id'      => 'save_google_places',
									'control' => 'save',
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
					'facebook'      => array(
						'id'          => 'facebook',
						'name'        => __( 'Facebook', 'wpbr' ),
						'heading'     => __( 'Facebook Reviews Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sFacebook Reviews 101%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'icon'        => 'status',
						'save_button' => false,
						/**
						 * Filters the fields in the Facebook section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_facebook',
							array(
								'platform_status_facebook' => array(
									'id'       => 'platform_status_facebook',
									'name'     => __( 'Platform Status', 'wpbr' ),
									'control'  => 'platform_status',
									'default'  => 'disconnected',
									'platform' => 'facebook',
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'facebook_pages'           => array(
									'id'          => 'facebook_pages',
									'name'        => __( 'Facebook Pages', 'wpbr' ),
									'control'     => 'facebook_pages',
									'description' => __( 'The connected Facebook account must have a role of Admin, Editor, Moderator, Advertiser, or Analyst in order to display reviews from the Page.', 'wbpr' ),
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
					'yelp'          => array(
						'id'          => 'yelp',
						'name'        => __( 'Yelp', 'wpbr' ),
						'heading'     => __( 'Yelp Reviews Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sYelp Reviews 101%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'icon'        => 'status',
						/**
						 * Filters the fields in the Yelp section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_yelp',
							array(
								'platform_status_yelp' => array(
									'id'       => 'platform_status_yelp',
									'name'     => __( 'Platform Status', 'wpbr' ),
									'control'  => 'platform_status',

									'default'  => 'disconnected',
									'platform' => 'yelp',
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'yelp_client_id'       => array(
									'id'           => 'yelp_client_id',
									'name'         => __( 'Yelp Client ID', 'wpbr' ),
									'control'      => 'input',
									'description'  => sprintf(
										/* translators: link to documentation */
										__( 'Defines the Yelp Client ID required to retrieve Yelp reviews. For step-by-step instructions, see docs on %1$sHow to Find Your Yelp Client ID%2$s.', 'wbpr' ),
										'<a href="https://wpbusinessreviews.com/">',
										'</a>'
									),
									'control_atts' => array(
										'type' => 'text',
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'yelp_client_secret'   => array(
									'id'           => 'yelp_client_secret',
									'name'         => __( 'Yelp Client Secret', 'wpbr' ),
									'control'      => 'input',
									'control_atts' => array(
										'type' => 'text',
									),
									'description'  => sprintf(
										/* translators: link to documentation */
										__( 'Defines the Yelp Client Secret required to retrieve Yelp reviews. For step-by-step instructions, see docs on %1$sHow to Find Your Yelp Secret Key%2$s.', 'wbpr' ),
										'<a href="https://wpbusinessreviews.com/">',
										'</a>'
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'save_yelp'            => array(
									'id'      => 'save_yelp',
									'control' => 'save',
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
					'yp'            => array(
						'id'          => 'yp',
						'name'        => __( 'YP', 'wpbr' ),
						'heading'     => __( 'YP Reviews Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sYP Reviews 101%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'icon'        => 'status',
						/**
						 * Filters the fields in the YP section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_yp',
							array(
								'platform_status_yp' => array(
									'id'       => 'platform_status_yp',
									'name'     => __( 'Platform Status', 'wpbr' ),
									'control'  => 'platform_status',
									'default'  => 'disconnected',
									'platform' => 'yp',
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'api_key_yp'         => array(
									'id'           => 'api_key_yp',
									'name'         => __( 'YP API Key', 'wpbr' ),
									'control'      => 'input',
									'control_atts' => array(
										'type' => 'text',
									),
									'description'  => sprintf(
										/* translators: link to documentation */
										__( 'Defines the YP API Key required to retrieve YP reviews. For step-by-step instructions, see docs on %1$sHow to Generate a YP API Key%2$s.', 'wbpr' ),
										'<a href="https://wpbusinessreviews.com/">',
										'</a>'
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'save_yp'            => array(
									'id'      => 'save_yp',
									'control' => 'save',
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
				)
			),
		),
		'advanced' => array(
			'id'       => 'advanced',
			'name'     => __( 'Advanced', 'wpbr' ),
			/**
			 * Filters the sections in the Advanced panel.
			 *
			 * @since 0.1.0
			 *
			 * @param array $sections Settings sections.
			 */
			'sections' => apply_filters(
				'wpbr_settings_section_advanced',
				array(
					'advanced' => array(
						'id'          => 'advanced',
						'name'        => __( 'Advanced', 'wpbr' ),
						'heading'     => __( 'Advanced Settings', 'wpbr' ),
						'description' => sprintf(
							/* translators: link to documentation */
							__( 'Need help? See docs on %1$sAdvanced Settings%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						/**
						 * Filters the fields in the Advanced section.
						 *
						 * @since 0.1.0
						 *
						 * @param array $fields Settings fields.
						 */
						'fields'      => apply_filters(
							'wpbr_settings_fields_advanced',
							array(
								'plugin_styles'      => array(
									'id'          => 'plugin_styles',
									'name'        => __( 'Plugin Styles', 'wpbr' ),
									'control'     => 'radio',
									'description' => __( 'Outputs CSS that styles the presentation of reviews.', 'wpbr' ),
									'default'     => 'enabled',
									'options'     => array(
										'enabled'  => __( 'Enabled', 'wpbr' ),
										'disabled' => __( 'Disabled', 'wpbr' ),
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'nofollow_links'     => array(
									'id'          => 'nofollow_links',
									'name'        => __( 'Nofollow Links', 'wpbr' ),
									'control'     => 'radio',
									'description' => sprintf(
										/* translators: anchor attribute to discourage search engines */
										__( 'Adds %s to review links in order to discourage search engines from following them.', 'wbpr' ),
										'<code>rel="nofollow"</code>'
									),
									'default'     => 'disabled',
									'options'     => array(
										'enabled'  => __( 'Enabled', 'wpbr' ),
										'disabled' => __( 'Disabled', 'wpbr' ),
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'link_targeting'     => array(
									'id'          => 'link_targeting',
									'name'        => __( 'Link Targeting', 'wpbr' ),
									'control'     => 'radio',
									'description' => sprintf(
										/* translators: anchor attribute to open links in new tab */
										__( 'Adds %s to review links when set to open in new tab.', 'wbpr' ),
										'<code>target="_blank"</code>'
									),
									'default'     => '_self',
									'options'     => array(
										'_self'  => __( 'Open links in same tab.', 'wpbr' ),
										'_blank' => __( 'Open links in new tab.', 'wpbr' ),
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'uninstall_behavior' => array(
									'id'      => 'uninstall_behavior',
									'name'    => __( 'Uninstall Behavior', 'wpbr' ),
									'control' => 'radio',
									'default' => 'keep',
									'options' => array(
										'keep'   => __( 'Keep all plugin settings and reviews data.', 'wpbr' ),
										'remove' => __( 'Remove all plugin settings and reviews data.', 'wpbr' ),
									),
									'wrapper_class' => 'wpbr-field--spacious',
								),
								'save_advanced'      => array(
									'id'      => 'save_advanced',
									'control' => 'save',
									'wrapper_class' => 'wpbr-field--spacious',
								),
							)
						),
					),
				)
			),
		),
	)
);

return $config;
