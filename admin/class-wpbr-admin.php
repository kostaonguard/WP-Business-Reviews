<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WPBR
 * @subpackage WPBR/admin
 * @author     WordImpress, LLC <info@wordimpress.com>
 */
class WPBR_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WPBR_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WPBR_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wpbr-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WPBR_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WPBR_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wpbr-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add an options page under the Settings submenu.
	 *
	 * @since  1.0.0
	 */
	public function add_options_page() {

		add_options_page(
			__( 'WP Business Reviews Settings', 'wpbr' ),
			__( 'Business Reviews', 'wpbr' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);

	}

	/**
	 * Render the options page.
	 *
	 * @since  1.0.0
	 */
	public function display_options_page() {

		include_once 'partials/wpbr-admin-display.php';

	}

	/**
	 * Render a business object from a post.
	 *
	 * @since  1.0.0
	 */
	public function display_business( $post ) {
		if ( 'wpbr_business' !== $post->post_type ) {
			return;
		}

		$business_id    = get_post_meta( $post->ID, 'wpbr_business_id', true );
		$platform_terms = get_the_terms( $post->ID, 'wpbr_platform' );
		$platform       = $platform_terms[0]->slug;
		$business       = new WPBR_Business( $business_id, $platform );

		echo '<pre class="postbox" style="overflow-x: scroll; padding: 12px ;">';
		esc_html_e( print_r( $business, true ) );
		echo '</pre>';
	}

	/**
	 * Render a business object from a post.
	 *
	 * @since  1.0.0
	 */
	public function display_review( $post ) {
		if ( 'wpbr_review' !== $post->post_type ) {
			return;
		}

		$business_id    = get_post_meta( $post->ID, 'wpbr_business_id', true );
		$platform_terms = get_the_terms( $post->ID, 'wpbr_platform' );
		$platform       = $platform_terms[0]->slug;
		$review         = new WPBR_Review( $business_id, $platform );

		$review->set_properties_from_post( $post );

		echo '<pre class="postbox" style="overflow-x: scroll; padding: 12px ;">';
		esc_html_e( print_r( $review, true ) );
		echo '</pre>';
	}

}
