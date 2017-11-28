<?php
/**
 * Defines the settings config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'general' => array(
		'name'     => __( 'Platforms', 'wp-business-reviews' ),
		'sections' => array(
			'platforms' => array(
				'name'        => __( 'Platforms', 'wp-business-reviews' ),
				'heading'     => __( 'Platform Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sWP Business Reviews 101%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'icon'        => 'gears',
				'fields'      => array(
					'active_platforms' => array(
						'name'        => __( 'Active Review Platforms', 'wp-business-reviews' ),
						'type'        => 'checkboxes',
						'description' => __( 'Determines which review platforms are visible throughout the plugin. Only active review platforms appear in Settings and are available for use within shortcodes and widgets.', 'wp-business-reviews' ),
						'default'     => array(
							'google_places',
							'facebook',
							'yelp',
						),
						'options'     => array(
							'google_places' => __( 'Google', 'wp-business-reviews' ),
							'facebook'      => __( 'Facebook', 'wp-business-reviews' ),
							'yelp'          => __( 'Yelp', 'wp-business-reviews' ),
							'yp'            => __( 'YP', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_platforms' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'google_places' => array(
				'name'        => __( 'Google', 'wp-business-reviews' ),
				'heading'     => __( 'Google Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sGoogle Reviews 101%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'platform_status_google_places' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'google_places',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'api_key_google_places' => array(
						'name'         => __( 'Google Places API Key', 'wp-business-reviews' ),
						'type'         => 'input',
						'description'  => sprintf(
							/* translators: link to documentation */
							__( 'Defines the Google Places API Key required to retrieve Google reviews. For step-by-step instructions, see docs on %1$sHow to Generate a Google Places API Key%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_google_places' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'facebook' => array(
				'name'        => __( 'Facebook', 'wp-business-reviews' ),
				'heading'     => __( 'Facebook Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sFacebook Reviews 101%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'platform_status_facebook' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'facebook',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'facebook_pages' => array(
						'name'        => __( 'Facebook Pages', 'wp-business-reviews' ),
						'type'        => 'facebook_pages',
						'description' => __( 'The connected Facebook account must have a role of Admin, Editor, Moderator, Advertiser, or Analyst in order to display reviews from the Page.', 'wbpr' ),
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
			'yelp' => array(
				'name'        => __( 'Yelp', 'wp-business-reviews' ),
				'heading'     => __( 'Yelp Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sYelp Reviews 101%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'platform_status_yelp' => array(
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',

						'default'  => 'disconnected',
						'platform' => 'yelp',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'yelp_client_id' => array(
						'name'         => __( 'Yelp Client ID', 'wp-business-reviews' ),
						'type'         => 'input',
						'description'  => sprintf(
							/* translators: link to documentation */
							__( 'Defines the Yelp Client ID required to retrieve Yelp reviews. For step-by-step instructions, see docs on %1$sHow to Find Your Yelp Client ID%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'yelp_client_secret' => array(
						'name'         => __( 'Yelp Client Secret', 'wp-business-reviews' ),
						'type'         => 'input',
						'description'  => sprintf(
							/* translators: link to documentation */
							__( 'Defines the Yelp Client Secret required to retrieve Yelp reviews. For step-by-step instructions, see docs on %1$sHow to Find Your Yelp Secret Key%2$s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_yelp' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				)
			),
			'yp' => array(
				'name'        => __( 'YP', 'wp-business-reviews' ),
				'heading'     => __( 'YP Review Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sYP Reviews 101%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'icon'        => 'status',
				'fields'      => array(
					'platform_status_yp' => array(
						'id'       => 'platform_status_yp',
						'name'     => __( 'Platform Status', 'wp-business-reviews' ),
						'type'     => 'platform_status',
						'default'  => 'disconnected',
						'platform' => 'yp',
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'api_key_yp'         => array(
						'id'           => 'api_key_yp',
						'name'         => __( 'YP API Key', 'wp-business-reviews' ),
						'type'         => 'input',
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
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
		),
	),
	'advanced' => array(
		'name'     => __( 'Advanced', 'wp-business-reviews' ),
		'sections' => array(
			'advanced' => array(
				'name'        => __( 'Advanced', 'wp-business-reviews' ),
				'heading'     => __( 'Advanced Settings', 'wp-business-reviews' ),
				'description' => sprintf(
					/* translators: link to documentation */
					__( 'Need help? See docs on %1$sAdvanced Settings%2$s.', 'wbpr' ),
					'<a href="https://wpbusinessreviews.com/">',
					'</a>'
				),
				'fields'      => array(
					'plugin_styles' => array(
						'name'          => __( 'Plugin Styles', 'wp-business-reviews' ),
						'type'          => 'radio',
						'description'   => __( 'Outputs CSS that styles the presentation of reviews.', 'wp-business-reviews' ),
						'default'       => 'enabled',
						'options'       => array(
							'enabled'      => __( 'Enabled', 'wp-business-reviews' ),
							'disabled'     => __( 'Disabled', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'nofollow_links' => array(
						'name'        => __( 'Nofollow Links', 'wp-business-reviews' ),
						'type'        => 'radio',
						'description' => sprintf(
							/* translators: anchor attribute to discourage search engines */
							__( 'Adds %s to review links in order to discourage search engines from following them.', 'wbpr' ),
							'<code>rel="nofollow"</code>'
						),
						'default'     => 'disabled',
						'options'     => array(
							'enabled'  => __( 'Enabled', 'wp-business-reviews' ),
							'disabled' => __( 'Disabled', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'link_targeting' => array(
						'name'        => __( 'Link Targeting', 'wp-business-reviews' ),
						'type'        => 'radio',
						'description' => sprintf(
							/* translators: anchor attribute to open links in new tab */
							__( 'Adds %s to review links when set to open in new tab.', 'wbpr' ),
							'<code>target="_blank"</code>'
						),
						'default'     => '_self',
						'options'     => array(
							'_self'  => __( 'Open links in same tab.', 'wp-business-reviews' ),
							'_blank' => __( 'Open links in new tab.', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'uninstall_behavior' => array(
						'name'    => __( 'Uninstall Behavior', 'wp-business-reviews' ),
						'type'    => 'radio',
						'default' => 'keep',
						'options' => array(
							'keep'   => __( 'Keep all plugin settings and reviews data.', 'wp-business-reviews' ),
							'remove' => __( 'Remove all plugin settings and reviews data.', 'wp-business-reviews' ),
						),
						'wrapper_class' => 'wpbr-field--spacious',
					),
					'save_advanced' => array(
						'type'    => 'save',
						'wrapper_class' => 'wpbr-field--spacious',
					),
				),
			),
		),
	),
);

/**
 * Filters the entire plugin settings config.
 *
 * @since 0.1.0
 *
 * @param array $config Array of tabs, sections, and fields.
 */
return apply_filters( 'wpbr_config_settings', $config );
