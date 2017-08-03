<?php
/**
 * Defines the Settings_API class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Settings;

// Exit if accessed directly.
use WP_Business_Reviews\Includes\WP_Business_Reviews;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles the custom Settings API for the plugin.
 *
 * The Settings API is built atop the settings framework which defines the
 * structure of tabs, panels, sections, and fields along with default values.
 * This framework determines the default settings for the plugin as well as the
 * user interface that appears in WP Admin.
 *
 * Adding a new tab, panel, section, or field is as easy as manipulating the
 * framework array. Any field present in the framework array will be visible
 * in the settings UI and saved to the database.
 *
 * When settings are saved, the plugin stores its settings in a single option
 * named `wpbr_settings`. This option holds an associative array of all plugin
 * settings from which single settings can be retrieved.
 *
 * @since 1.0.0
 */
class Settings_API {
	/**
	 * Associative array of field IDs and saved values from the database.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $settings;

	/**
	 * Settings structure containing tabs, panels, sections, and fields.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $framework;

	/**
	 * Associative array of field attributes and default values.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $field_defaults;

	/**
	 * Sets up the settings framework.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->settings       = get_option( 'wpbr_settings', array() );
		$this->framework      = $this->define_framework();
		$this->field_defaults = $this->define_field_defaults();
	}

	/**
	 * Hooks functionality responsible for handling settings.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'admin_post_wpbr_settings_save', array( $this, 'save' ) );
	}

	/**
	 * Gets the settings framework or defines it if necessary.
	 *
	 * The framework array of consists of tabs, panels, sections, and fields
	 * that make up the settings UI rendered by Page_Admin_Settings.
	 *
	 * @return array Plugin settings.
	 *
	 * @since 1.0.0
	 * @see   Page_Admin_Settings
	 */
	public function define_framework() {
		$framework = array(
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
								'desc'    => __( 'Determines which review platforms are visible throughout the plugin. Only active review platforms appear in Settings and are available for use within shortcodes and widgets.', 'wpbr' ),
								'type'    => 'checkbox',
								'default' => array(
									'google',
									'facebook',
									'yelp',
								),
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
								'default'  => 'disconnected',
								'platform' => 'google',
							),
							'api_key_google_places'  => array(
								'id'   => 'api_key_google_places',
								'name' => __( 'Google Places API Key', 'wpbr' ),
								'desc' => sprintf(
									__( 'Defines the Google Places API Key required to retrieve Google reviews. For step-by-step instructions, see docs on %sHow to Generate a Google Places API Key%s.', 'wbpr' ),
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
								'default'  => 'disconnected',
								'platform' => 'facebook',
							),
							'facebook_pages'           => array(
								'id'   => 'facebook_pages',
								'name' => __( 'Facebook Pages', 'wpbr' ),
								'desc' => __( 'Defines the Facebook Pages from which reviews may be displayed. The connected Facebook account must have a role of Admin, Editor, Moderator, Advertiser, or Analyst in order to display reviews from the Page.', 'wbpr' ),
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
								'default'  => 'disconnected',
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
								'default'  => 'disconnected',
								'platform' => 'yp',
							),
							'api_key_yp'         => array(
								'id'   => 'api_key_yp',
								'name' => __( 'YP API Key', 'wpbr' ),
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
							__( 'Need help? See docs on %sAdvanced Settings%s.', 'wbpr' ),
							'<a href="https://wpbusinessreviews.com/">',
							'</a>'
						),
						'fields'  => array(
							'plugin_styles'      => array(
								'id'      => 'plugin_styles',
								'name'    => __( 'Plugin Styles', 'wpbr' ),
								'desc'    => __( 'Outputs CSS that styles the presentation of reviews.', 'wpbr' ),
								'type'    => 'radio',
								'default' => 'enabled',
								'options' => array(
									'enabled'  => __( 'Enabled', 'wpbr' ),
									'disabled' => __( 'Disabled', 'wpbr' ),
								),
							),
							'nofollow_links' => array(
								'id'      => 'nofollow_links',
								'name'    => __( 'Nofollow Links', 'wpbr' ),
								'desc' => sprintf(
									__( 'Adds %s to review links in order to discourage search engines from following them.', 'wbpr' ),
									'<code>rel="nofollow"</code>'
								),
								'type'    => 'radio',
								'default' => 'disabled',
								'options' => array(
									'enabled'  => __( 'Enabled', 'wpbr' ),
									'disabled' => __( 'Disabled', 'wpbr' ),
								),
							),
							'link_targeting' => array(
								'id'      => 'link_targeting',
								'name'    => __( 'Link Targeting', 'wpbr' ),
								'desc' => sprintf(
									__( 'Adds %s to review links when set to open in new tab.', 'wbpr' ),
									'<code>target="_blank"</code>'
								),
								'type'    => 'radio',
								'default' => '_self',
								'options' => array(
									'_self'  => __( 'Open links in same tab.', 'wpbr' ),
									'_blank' => __( 'Open links in new tab.', 'wpbr' ),
								),
							),
							'uninstall_behavior' => array(
								'id'      => 'uninstall_behavior',
								'name'    => __( 'Uninstall Behavior', 'wpbr' ),
								'type'    => 'radio',
								'default' => 'keep',
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

		return $framework;
	}

	/**
	 * Define default values of settings field.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of field attributes and values.
	 */
	private function define_field_defaults() {
		$field_defaults = array(
			'id' => '',
			'name' => '',
			'desc' => '',
			'type' => 'text',
			'default' => '',
			'options' => array(),

		);

		return $field_defaults;
	}

	/**
	 * Get values of default settings from framework.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of field IDs and default values.
	 */
	public function get_framework() {
		return $this->framework;
	}

	/**
	 * Gets all settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of field IDs and saved values.
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * Gets the value of a single setting.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $setting The array key associated with the setting.
	 * @return mixed The value of the setting or null if unavailable.
	 */
	public function get_setting( $setting ) {
		if ( ! empty( $this->settings ) && isset( $this->settings[ $setting ] ) ) {
			return $this->settings[ $setting ];
		}

		return null;
	}

	/**
	 * Gets default settings from framework.
	 *
	 * @since 1.0.0
	 *
	 * @return array Associative array of field IDs and default values.
	 */
	public function get_default_settings() {
		$default_settings = array();

		// Parse framework to retrieve default value of each field.
		foreach ( $this->framework as $tab ) {
			foreach ( $tab['sections'] as $section ) {
				foreach ( $section['fields'] as $field ) {
					if ( ! empty( $field['id'] ) ) {
						$field_id                      = $field['id'];
						$field_default                 = ! empty( $field['default'] ) ? $field['default'] : '';
						$default_settings[ $field_id ] = $field_default;
					}
				}
			}
		}

		return $default_settings;
	}

	/**
	 * Merges default settings with existing settings.
	 *
	 * This method is useful during plugin activation when settings do not yet
	 * exist in the database. It is also useful when new settings are added
	 * during plugin updates. Default values are added to the database without
	 * affecting existing values.
	 *
	 * @since 1.0.0
	 */
	private function merge_default_settings() {
		$default_settings = $this->get_default_settings();
		$current_settings = $this->get_settings();
		$updated_settings = array_merge( $default_settings, $current_settings );

		update_option( 'wpbr_settings', $updated_settings );
	}

	/**
	 * Validates the incoming nonce value, verifies the current user has
	 * permission to save the value from the options page and saves the
	 * option to the database.
	 */
	public function save() {
		// If settings, tab, or section are empty, return early.
		if ( empty( $_POST['wpbr_settings'] ) || empty( $_POST['wpbr_tab'] ) || empty( $_POST['wpbr_section'] ) ) {
			return false;
		}

		// Validate the nonce and verify the user as permission to save.
		if ( ! ( $this->has_valid_nonce() && current_user_can( 'manage_options' ) ) ) {
			// TODO: Display an error message.
			error_log('not validated!!!');
			return false;
		}

		// Settings option retrieved from the database prior to saving.
		$old_option = get_option( 'wpbr_settings', array() );

		// Get the active tab and section from hidden fields in settings form.
		$tab = ! empty( $_POST['wpbr_tab'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_tab'] ) ) : '';
		$section = ! empty( $_POST['wpbr_section'] ) ? sanitize_text_field( wp_unslash( $_POST['wpbr_section'] ) ) : '';

		// Get the settings posted by the user.
		$post_settings = wp_unslash( $_POST['wpbr_settings'] );

		// Get the relevant fields being saved based on active tab and section.
		$fields = $this->framework[ $tab ]['sections'][ $section ]['fields'];

		$new_option = array_merge( $old_option, $post_settings );

		update_option( 'wpbr_settings', $new_option );

		$this->redirect();
	}

	/**
	 * Determines if the nonce variable associated with the options page is set
	 * and is valid.
	 *
	 * @access private
	 *
	 * @return boolean False if the field isn't set or the nonce value is invalid;
	 *                 otherwise, true.
	 */
	private function has_valid_nonce() {
		// If the field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['wpbr_settings_nonce'] ) ) { // Input var okay.
			return false;
		}

		$field  = wp_unslash( $_POST['wpbr_settings_nonce'] );
		$action = 'wpbr_settings_save';

		return wp_verify_nonce( $field, $action );
	}

	/**
	 * Redirect to page and section from which settings were saved. If referer
	 * is not set, redirect to login page.
	 *
	 * @since 1.0.0
	 */
	private function redirect() {
		// Redirect to login if referer not provided.
		if ( ! isset( $_POST['_wp_http_referer'] ) ) {
			wp_safe_redirect( wp_login_url() );
		}

		// Sanitize referer URL.
		$url = sanitize_text_field( wp_unslash( $_POST['_wp_http_referer'] ) );

		// Add section hash so user is redirected to the correct section of settings page.
		if ( isset( $_POST['wpbr_section'] ) ) {
			$section_hash = sanitize_text_field( $_POST['wpbr_section'] );
			$url .= '#wpbr-section-' . $section_hash;
		}

		wp_safe_redirect( urldecode( $url ) );

		// TODO: Remove this error_log() before launch.
		error_log( print_r( get_option( 'wpbr_settings' ), true ) );

		exit;
	}
}
