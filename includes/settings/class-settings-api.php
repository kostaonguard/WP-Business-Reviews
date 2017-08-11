<?php
/**
 * Defines the Settings_API class
 *
 * @package WP_Business_Reviews\Includes\Settings
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Settings;

use WP_Business_Reviews\Includes\Admin\Admin_Notices;

// Exit if accessed directly.
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
	 * Active tab.
	 *
	 * @since  1.0.0
	 * @var    string
	 * @access private
	 */
	private $active_tab;

	/**
	 * Active section.
	 *
	 * @since  1.0.0
	 * @var    string
	 * @access private
	 */
	private $active_section;

	/**
	 * Admin notices.
	 *
	 * @since  1.0.0
	 * @var    array
	 * @access private
	 */
	private $notices;

	/**
	 * Sets up the settings framework.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->settings       = get_option( 'wpbr_settings', array() );
		$this->framework      = $this->define_framework();
		$this->field_defaults = $this->define_field_defaults();
		$this->notices        = new Admin_Notices();
		$this->active_tab     = ! empty( $_POST['wpbr_tab'] ) ? sanitize_text_field( $_POST['wpbr_tab'] ) : '';
		$this->active_section = ! empty( $_POST['wpbr_section'] ) ? sanitize_text_field( $_POST['wpbr_section'] ) : '';
	}

	/**
	 * Hooks functionality responsible for handling settings.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		if ( is_admin() ) {
			// Save active section's fields.
			add_action( 'wpbr_review_page_wpbr_settings', array( $this, 'save_section' ) );
			// Display notices under the active section.
			add_action( 'wpbr_settings_notices_' . $this->active_section, array( $this->notices, 'render_notices' ) );
		}
	}

	/**
	 * Gets the settings framework or defines it if necessary.
	 *
	 * The framework array of consists of tabs, panels, sections, and fields
	 * that make up the settings UI rendered by Page_Admin_Settings.
	 *
	 * @since 1.0.0
	 * @see   Page_Admin_Settings
	 *
	 * @return array Plugin settings.
	 */
	public function define_framework() {
		/**
		 * Filters the entire plugin settings framework.
		 *
		 * @since 1.0.0
		 *
		 * @param array $framework Settings structure containing tabs, panels,
		 *                         sections, and fields.
		 */
		$framework = apply_filters(
			'wpbr_settings_framework',
			array(
				'general'      => array(
					'id'       => 'general',
					'name'     => __( 'General', 'wpbr' ),
					/**
					 * Filters the sections in the General panel.
					 *
					 * @since 1.0.0
					 * @param array $sections Settings sections.
					 */
					'sections' => apply_filters(
						'wpbr_settings_sections_general',
						array(
							'platforms' => array(
								'id'      => 'platforms',
								'name'    => __( 'Platforms', 'wpbr' ),
								'heading' => __( 'Platform Settings', 'wpbr' ),
								'desc'    => sprintf(
									__( 'Need help? See docs on %sWP Business Reviews 101%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								/**
								 * Filters the fields in the Platform section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_platforms',
									array(
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
									)
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
								/**
								 * Filters the fields in the Google section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_google',
									array(
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
									)
								),
							),
							'facebook'  => array(
								'id'          => 'facebook',
								'name'        => __( 'Facebook', 'wpbr' ),
								'heading'     => __( 'Facebook Reviews Settings', 'wpbr' ),
								'desc'        => sprintf(
									__( 'Need help? See docs on %sFacebook Reviews 101%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								'save_button' => false,
								/**
								 * Filters the fields in the Facebook section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_facebook',
									array(
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
									)
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
								/**
								 * Filters the fields in the Yelp section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_yelp',
									array(
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
									)
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
								/**
								 * Filters the fields in the YP section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_yp',
									array(
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
									)
								),
							),
						)
					),
				),
				'advanced'     => array(
					'id'       => 'advanced',
					'name'     => __( 'Advanced', 'wpbr' ),
					/**
					 * Filters the sections in the Advanced panel.
					 *
					 * @since 1.0.0
					 *
					 * @param array $sections Settings sections.
					 */
					'sections' => apply_filters(
						'wpbr_settings_sections_advanced',
						array(
							'advanced' => array(
								'id'      => 'advanced',
								'name'    => __( 'Advanced', 'wpbr' ),
								'heading' => __( 'Advanced Settings', 'wpbr' ),
								'desc'    => sprintf(
									__( 'Need help? See docs on %sAdvanced Settings%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								/**
								 * Filters the fields in the Advanced section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_advanced',
									array(
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
										'nofollow_links'     => array(
											'id'      => 'nofollow_links',
											'name'    => __( 'Nofollow Links', 'wpbr' ),
											'desc'    => sprintf(
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
										'link_targeting'     => array(
											'id'      => 'link_targeting',
											'name'    => __( 'Link Targeting', 'wpbr' ),
											'desc'    => sprintf(
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
									)
								),
							),
						)
					),
				),
				'pro_features' => array(
					'id'       => 'pro_features',
					'name'     => __( 'Pro Features', 'wpbr' ),
					/**
					 * Filters the sections in the Pro Features panel.
					 *
					 * @since 1.0.0
					 *
					 * @param array $sections Settings sections.
					 */
					'sections' => apply_filters(
						'wpbr_settings_sections_pro_features',
						array(
							'pro_features' => array(
								'id'          => 'pro_features',
								'name'        => __( 'Pro Features', 'wpbr' ),
								'heading'     => __( 'Pro Features', 'wpbr' ),
								'desc'        => sprintf(
									__( 'Interested in going Pro? See a full %sFeatures Comparison%s.', 'wbpr' ),
									'<a href="https://wpbusinessreviews.com/">',
									'</a>'
								),
								'save_button' => false,
								/**
								 * Filters the fields in the Pro Features section.
								 *
								 * @since 1.0.0
								 *
								 * @param array $fields Settings fields.
								 */
								'fields'  => apply_filters(
									'wpbr_settings_fields_pro_features',
									array(
										'pro_features_gallery' => array(
											'id'   => 'pro_features_gallery',
											'name' => __( 'Pro Features Gallery', 'wpbr' ),
											'type' => 'pro_features_gallery',
										),
									)
								),
							),
						)
					),
				),
			)
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
	 * exist in the database.
	 *
	 * @since 1.0.0
	 */
	private function merge_default_settings() {
		$default_settings = $this->get_default_settings();
		$this->settings = array_merge( $default_settings, $this->settings );
		$this->update_settings_option();
	}

	/**
	 * Saves settings section.
	 *
	 * When user saves changes on the settings page, fields from the active
	 * section are submitted. This validates the incoming nonce value, verifies
	 * user permissions, sanitizes the settings, and updates the option.
	 *
	 * @since 1.0.0
	 */
	public function save_section() {
		// If action is not set appropriately, return false.
		if ( empty( $_POST['action'] ) || 'wpbr_settings_save' !== sanitize_text_field( $_POST['action'] )  ) {
			return false;
		}

		// Validate nonce.
		if ( ! $this->has_valid_nonce() ) {
			$this->notices->add_notice( 'settings_nonce_error', 'error' );
			return false;
		}

		// Verify user has permission.
		if ( ! $this->has_permission() ) {
			$this->notices->add_notice( 'settings_permission_error', 'error' );
			return false;
		}

		// Get active tab and section.
		$active_tab     = $this->active_tab;
		$active_section = $this->active_section;

		// Get the settings posted by the user.
		$posted_settings = ! empty( $_POST['wpbr_settings'] ) ? wp_unslash( $_POST['wpbr_settings'] ) : array();

		/**
		 * Get the relevant fields being saved based on active tab and section.
		 * The framework is used to identify the type of field being saved in
		 * order to validate and sanitize it appropriately.
		 */
		$framework_fields = $this->framework[ $active_tab ]['sections'][ $active_section ]['fields'];

		// Loop through settings and save fields.
		foreach ( $framework_fields as $field => $atts ) {
			if ( ! empty( $posted_settings ) && isset( $posted_settings[ $field ] ) ) {
				$this->settings[ $field ] = $this->sanitize_field( $posted_settings[ $field ] );
			} else {
				$this->settings[ $field ] = '';
			}
		}

		// Update the settings option in the database.
		$this->update_settings_option();
	}

	/**
	 * Sanitize text recursively.
	 *
	 * Arrays are cleaned recursively. Other non-scalar values return empty
	 * string.
	 *
	 * @since 1.0.0
	 *
	 * @param string|array $var String or array.
	 * @return string|array Sanitized string or array.
	 */
	function sanitize_field( $var ) {
		if ( is_array( $var ) ) {
			return array_map( array( $this, 'sanitize_field' ), $var );
		}

		return is_scalar( $var ) ? sanitize_text_field( $var ) : '';
	}

	/**
	 * Updates the settings option in the database.
	 *
	 * @since 1.0.0
	 */
	private function update_settings_option() {
		$updated_option = update_option( 'wpbr_settings', $this->settings );
		$this->notices->add_notice( 'settings_update_success', 'success' );

		// TODO: Remove this error_log() before launch.
		error_log( print_r( get_option( 'wpbr_settings' ), true ) );
	}

	/**
	 * Determines if the nonce is valid.
	 *
	 * @since 1.0.0
	 *
	 * @return boolean False if the field isn't set or the nonce value is
	 *                 invalid; otherwise true.
	 */
	private function has_valid_nonce() {
		// If the nonce field isn't even in the $_POST, then it's invalid.
		if ( ! isset( $_POST['wpbr_settings_nonce'] ) ) { // Input var okay.
			return false;
		}

		$field  = sanitize_text_field( $_POST['wpbr_settings_nonce'] );
		$action = 'wpbr_settings_save';

		return wp_verify_nonce( $field, $action );
	}

	/**
	 * Determines if user has permissions to save settings.
	 *
	 * @since 1.0.0
	 */
	private function has_permission() {
		return current_user_can( 'manage_options' );
	}
}
