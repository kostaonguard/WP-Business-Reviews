<?php
/**
 * Defines the Blank_Slate class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Admin;

use \WP_Query;
use WP_Business_Reviews\Includes\View;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blank_Slate {
	/**
	 * The current screen ID.
	 *
	 * @since  0.1.0
	 * @var string
	 * @access public
	 */
	public $screen_id = '';

	/**
	 * Whether at least one reviews platform is connected.
	 *
	 * @since  0.1.0
	 * @var bool
	 * @access private
	 */
	private $is_connected = false;

	/**
	 * The content of the blank slate panel.
	 *
	 * @since  0.1.0
	 * @var array
	 * @access private
	 */
	private $content = array();

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'current_screen', array( $this, 'init' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * The blank slate is only initialized on the appropriate screen when no
	 * posts exist.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		$screen_id = get_current_screen()->id;
		if ( 'edit-wpbr_review' === $screen_id && ! $this->post_exists( 'wpbr_review' ) ) {
			// Get content to display in the blank slate.
			add_action( 'admin_head', array( $this, 'hide_ui' ) );
			add_action( 'manage_posts_extra_tablenav', array( $this, 'render' ) );
		}
	}

	/**
	 * Hides non-essential UI elements when blank slate content is on screen.
	 *
	 * @since 0.1.0
	 */
	public function hide_ui() {
		echo '<style type="text/css">.wpbr-admin .page-title-action, .wpbr-admin .subsubsub, .wpbr-admin .wp-list-table, .wpbr-admin .tablenav.top {display: none; }</style>';
	}

	/**
	 * Determines if at least one post of a given post type exists.
	 *
	 * @since 0.1.0
	 *
	 * @param string $post_type Post type used in the query.
	 * @return bool True if post exists, otherwise false.
	 */
	private function post_exists( $post_type ) {
		// Attempt to get a single post of the post type.
		$query = new WP_Query( array(
			'post_type'              => $post_type,
			'posts_per_page'         => 1,
			'no_found_rows'          => false,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
			'fields'                 => 'ids',
			'post_status'            => array( 'any', 'trash' ),
		) );

		return $query->have_posts();
	}

	/**
	 * Gets the content of a blank slate message based on provided context.
	 *
	 * @since 0.1.0
	 *
	 * @return array Blank slate content.
	 */
	private function get_content() {
		$content = array();

		// Define default content.
		$defaults = array(
			'image_url' => WPBR_ASSETS_URL . 'images/wpbr-icon-color.png',
			'image_alt' => __( 'WP Business Reviews Icon', 'wp-business-reviews' ),
			'heading'   => __( 'Welcome to WP Business Reviews!', 'wp-business-reviews' ),
			'message'   => __( 'Let\'s begin by connecting to at least one reviews platform.', 'wp-business-reviews' ),
			'cta_text'  => __( 'Get Connected', 'wp-business-reviews' ),
			'cta_link'  => admin_url( 'edit.php?post_type=wpbr_review&page=settings' ),
		);

		// TODO: Add logic to check for connected platform.
		if ( $this->is_connected ) {
			// No reviews exist but at least one platform is connected.
			$content = array(
				'heading'   => __( 'No reviews found.', 'wp-business-reviews' ),
				'message'   => __( 'Now that you\'re connected to a reviews platform, let\'s build your first set of reviews.', 'wp-business-reviews' ),
				'cta_text'  => __( 'Build Reviews', 'wp-business-reviews' ),
				'cta_link'  => admin_url( 'edit.php?post_type=wpbr_review&page=reviews_builder' ),
			);
		}

		// Merge contextual content with defaults.
		$content = wp_parse_args( $content, $defaults );

		/**
		 * Filters the content of the blank slate.
		 *
		 * @since 0.1.0
		 *
		 * @param array $content {
		 *    Array of blank slate content.
		 *
		 *    @type string $image_url URL of the blank slate image.
		 *    @type string $image_alt Image alt text.
		 *    @type string $heading   Heading text.
		 *    @type string $message   Body copy.
		 *    @type string $cta_text  Call to action text.
		 *    @type string $cta_link  Call to action URL.
		 *    @type string $help_text Help text, may contain a link to docs.
		 * }
		 *
		 * @param string $screen The current screen ID.
		 */
		return apply_filters( 'wpbr_blank_slate_content', $content, $this->screen_id );
	}

	/**
	 * Renders the blank slate.
	 *
	 * @since  0.1.0
	 *
	 * @param string $which The location of the list table hook: 'top' or 'bottom'.
	 */
	public function render( $which = 'bottom' ) {
		if ( 'bottom' === $which ) {
			$view_object = new View( WPBR_PLUGIN_DIR . 'views/admin/blank-slate.php' );
			$view_object->render( $this->get_content() );
		}
	}
}
