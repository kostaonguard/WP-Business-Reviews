<?php
/**
 * Defines the Assets class
 *
 * @package WP_Business_Reviews\Includes
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads the plugin's assets.
 *
 * Registers and enqueues plugin styles and scripts. Asset versions are based
 * on the current plugin version.
 *
 * All script and style handles should be registered in this class even if they
 * are enqueued dynamically by other classes.
 *
 * @since 1.0.0
 */
class Assets {
	/**
	 * URL of the assets directory.
	 *
	 * @since  1.0.0
	 * @var    string
	 * @access private
	 */
	private $url;

	/**
	 * Plugin version.
	 *
	 * @since  1.0.0
	 * @var    string
	 * @access private
	 */
	private $version;

	/**
	 * Suffix used when loading minified assets.
	 *
	 * @since  1.0.0
	 * @var    string
	 * @access private
	 */
	private $suffix;

	public function __construct( $url, $version ) {
		// Set URL of assets directory.
		$this->url = $url;

		// Set version of assets (usually same as the plugin version).
		$this->version = $version;

		// Set minified suffix unless script debugging is enabled.
		$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	}

	public function init() {
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
		}
	}

	/**
	 * Registers all plugin styles.
	 *
	 * @since 1.0.0
	 */
	public function register_styles() {
		wp_register_style( 'wpbr-admin-main-styles', $this->url . 'css/admin-main' . $this->suffix . '.css', array(), $this->version );
		wp_register_style( 'wpbr-public-main-styles', $this->url . 'css/public-main' . $this->suffix . '.css', array(), $this->version );
	}

	/**
	 * Registers all plugin scripts.
	 *
	 * @since 1.0.0
	 */
	public function register_scripts() {
		wp_register_script( 'wpbr-admin-main-script', $this->url . 'js/admin-main' . $this->suffix . '.js', array(), $this->version, true );
	}

	/**
	 * Enqueues admin styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( 'wpbr-admin-main-styles' );
	}

	/**
	 * Enqueues public styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_public_styles() {
		wp_enqueue_style( 'wpbr-public-main-styles' );
	}

	/**
	 * Enqueues admin scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'wpbr-admin-main-script' );
	}

	/**
	 * Enqueues public scripts.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_public_scripts() {
	}
}
