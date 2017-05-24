<?php

/**
 * Defines the core plugin class
 *
 * This class includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since 1.0.0
 */
class WPBR {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPBR_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->plugin_name = 'wpbr';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_registration_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 */
	private function load_dependencies() {
		/**
		 * Class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-loader.php';

		/**
		 * Class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-i18n.php';

		/**
		 * Class responsible for registering custom post types and taxonomies.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-post-types.php';

		/**
		 * Classes responsible for implementing the WPBR_Business object.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-business.php';

		/**
		 * Classes responsible for implementing the WPBR_Review object.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-review.php';

		/**
		 * Classes responsible for requesting and standardizing remote reviews.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-reviews-set.php';

		/**
		 * Classes responsible for API requests to various reviews platforms.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-request-factory.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-google-places-request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-facebook-request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-yelp-request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-yp-request.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wpbr-wp-org-request.php';

		/**
		 * Class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wpbr-admin.php';

		/**
		 * Class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wpbr-public.php';

		$this->loader = new WPBR_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WPBR_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 */
	private function set_locale() {
		$plugin_i18n = new WPBR_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the registration of custom post
	 * types and taxonomies.
	 *
	 * @since    1.0.0
	 */
	private function define_registration_hooks() {
		$post_types = new WPBR_Post_Types();

		$this->loader->add_action( 'init', $post_types, 'register_post_types' );
		$this->loader->add_action( 'init', $post_types, 'register_taxonomies' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_admin_hooks() {
		$plugin_admin = new WPBR_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_options_page' );
		$this->loader->add_action( 'edit_form_after_editor', $plugin_admin, 'display_business' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	private function define_public_hooks() {
		$plugin_public = new WPBR_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPBR_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
}
