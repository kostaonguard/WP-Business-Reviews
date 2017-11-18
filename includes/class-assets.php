<?php
/**
 * Defines the Assets class
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

/**
 * Loads the plugin's assets.
 *
 * Registers and enqueues plugin styles and scripts. Asset versions are based
 * on the current plugin version.
 *
 * All script and style handles should be registered in this class even if they
 * are enqueued dynamically by other classes.
 *
 * @since 0.1.0
 */
class Assets {
	/**
	 * URL of the assets directory.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $url;

	/**
	 * Assets version.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $version;

	/**
	 * Suffix used when loading minified assets.
	 *
	 * @since  0.1.0
	 * @var    string
	 * @access private
	 */
	private $suffix;

	/**
	 * Instantiates the Assets class.
	 *
	 * @since 0.1.0
	 *
	 * @param $string $url     Path to the assets directory.
	 * @param $string $version Assets version, usually same as plugin version.
	 */
	public function __construct( $url, $version ) {
		$this->url     = $url;
		$this->version = $version;
		$this->suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '': '.min';
	}

	/**
	 * Registers assets via WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, 'register_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_scripts' ) );

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );
		} else {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_styles' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_public_scripts' ) );
		}
	}

	/**
	 * Registers all plugin styles.
	 *
	 * @since 0.1.0
	 */
	public function register_styles() {
		wp_register_style( 'wpbr-admin-main-styles', $this->url . 'css/admin-main' . $this->suffix . '.css', array(), $this->version );
		wp_register_style( 'wpbr-public-main-styles', $this->url . 'css/public-main' . $this->suffix . '.css', array(), $this->version );
	}

	/**
	 * Registers all plugin scripts.
	 *
	 * @since 0.1.0
	 */
	public function register_scripts() {
		wp_register_script( 'wpbr-admin-main-script', $this->url . 'js/admin-main' . $this->suffix . '.js', array( 'wpbr-google-places-library' ), $this->version, true );
		wp_register_script( 'wpbr-google-places-library', 'https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_PLACES_API_KEY . '&libraries=places', array(), $this->version, true );
	}

	/**
	 * Enqueues admin styles.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_admin_styles() {
		wp_enqueue_style( 'wpbr-admin-main-styles' );
	}

	/**
	 * Enqueues public styles.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_public_styles() {
		wp_enqueue_style( 'wpbr-public-main-styles' );
	}

	/**
	 * Enqueues admin scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_admin_scripts() {
		wp_enqueue_script( 'wpbr-admin-main-script' );
		wp_enqueue_script( 'wpbr-google-places-library' );
	}

	/**
	 * Enqueues public scripts.
	 *
	 * @since 0.1.0
	 */
	public function enqueue_public_scripts() {
	}
}
