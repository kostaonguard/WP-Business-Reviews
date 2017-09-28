<?php

/**
 * Defines the Post_Types class
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
 * Registers custom post types and taxonomies.
 *
 * @since 1.0.0
 */
class Post_Types {
	/**
	 * Hooks functionality responsible for registering post types and taxonomies.
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	/**
	 * Registers all custom post types.
	 *
	 * @since 1.0.0
	 */
	public function register_post_types() {
		$this->register_business_post_type();
		$this->register_review_post_type();
	}

	/**
	 * Registers all custom taxonomies.
	 *
	 * @since 1.0.0
	 */
	public function register_taxonomies() {
		$this->register_platform_taxonomy();
	}

	/**
	 * Insert default terms.
	 *
	 * @since 1.0.0
	 */
	public function insert_terms() {
		$platforms = array(
			'google_places' => 'Google Places',
			'facebook'      => 'Facebook',
			'yelp'          => 'Yelp',
			'yp'            => 'Yellow Pages',
			'wp_org'        => 'WordPress.org',
		);

		foreach ( $platforms as $slug => $term ) {
			if ( ! term_exists( $slug ) ) {
				$args = array(
					'slug' => $slug,
				);

				wp_insert_term( $term, 'wpbr_platform', $args );
			}
		}
	}

	/**
	 * Registers the wpbr_business post type.
	 *
	 * @since 1.0.0
	 */
	public function register_business_post_type() {
		$labels = array(
			'name'                  => _x( 'Businesses', 'Post Type General Name', 'wpbr' ),
			'singular_name'         => _x( 'Business', 'Post Type Singular Name', 'wpbr' ),
			'menu_name'             => __( 'Businesses', 'wpbr' ),
			'name_admin_bar'        => __( 'Business', 'wpbr' ),
			'archives'              => __( 'Business Archives', 'wpbr' ),
			'attributes'            => __( 'Business Attributes', 'wpbr' ),
			'parent_item_colon'     => __( 'Parent Business:', 'wpbr' ),
			'all_items'             => __( 'All Businesses', 'wpbr' ),
			'add_new_item'          => __( 'Add New Business', 'wpbr' ),
			'add_new'               => __( 'Add Business', 'wpbr' ),
			'new_item'              => __( 'New Business', 'wpbr' ),
			'edit_item'             => __( 'Edit Business', 'wpbr' ),
			'update_item'           => __( 'Update Business', 'wpbr' ),
			'view_item'             => __( 'View Business', 'wpbr' ),
			'view_items'            => __( 'View Businesses', 'wpbr' ),
			'search_items'          => __( 'Search Businesses', 'wpbr' ),
			'not_found'             => __( 'Not found', 'wpbr' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wpbr' ),
			'featured_image'        => __( 'Featured Image', 'wpbr' ),
			'set_featured_image'    => __( 'Set featured image', 'wpbr' ),
			'remove_featured_image' => __( 'Remove featured image', 'wpbr' ),
			'use_featured_image'    => __( 'Use as featured image', 'wpbr' ),
			'insert_into_item'      => __( 'Insert into item', 'wpbr' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpbr' ),
			'items_list'            => __( 'Businesses list', 'wpbr' ),
			'items_list_navigation' => __( 'Businesses list navigation', 'wpbr' ),
			'filter_items_list'     => __( 'Filter items list', 'wpbr' ),
		);

		$rewrite = array(
			'slug' => 'wpbr-businesses',
		);

		$args = array(
			'label'               => __( 'Business', 'wpbr' ),
			'labels'              => $labels,
			'supports'            => array( '' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-store',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);

		register_post_type( 'wpbr_business', $args );
	}

	/**
	 * Registers the wpbr_review post type.
	 *
	 * @since 1.0.0
	 */
	public function register_review_post_type() {

		$labels = array(
			'name'                  => _x( 'Reviews', 'Post Type General Name', 'wpbr' ),
			'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'wpbr' ),
			'menu_name'             => __( 'Reviews', 'wpbr' ),
			'name_admin_bar'        => __( 'Review', 'wpbr' ),
			'archives'              => __( 'Review Archives', 'wpbr' ),
			'attributes'            => __( 'Review Attributes', 'wpbr' ),
			'parent_item_colon'     => __( 'Parent Review:', 'wpbr' ),
			'all_items'             => __( 'All Reviews', 'wpbr' ),
			'add_new_item'          => __( 'Add New Review', 'wpbr' ),
			'add_new'               => __( 'Add Review', 'wpbr' ),
			'new_item'              => __( 'New Review', 'wpbr' ),
			'edit_item'             => __( 'Edit Review', 'wpbr' ),
			'update_item'           => __( 'Update Review', 'wpbr' ),
			'view_item'             => __( 'View Review', 'wpbr' ),
			'view_items'            => __( 'View Reviews', 'wpbr' ),
			'search_items'          => __( 'Search Review', 'wpbr' ),
			'not_found'             => __( 'Not found', 'wpbr' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wpbr' ),
			'featured_image'        => __( 'Featured Image', 'wpbr' ),
			'set_featured_image'    => __( 'Set featured image', 'wpbr' ),
			'remove_featured_image' => __( 'Remove featured image', 'wpbr' ),
			'use_featured_image'    => __( 'Use as featured image', 'wpbr' ),
			'insert_into_item'      => __( 'Insert into item', 'wpbr' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wpbr' ),
			'items_list'            => __( 'Reviews list', 'wpbr' ),
			'items_list_navigation' => __( 'Reviews list navigation', 'wpbr' ),
			'filter_items_list'     => __( 'Filter items list', 'wpbr' ),
		);

		$rewrite = array(
			'slug' => 'wpbr-reviews',
		);

		$args = array(
			'label'               => __( 'Review', 'wpbr' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'          => 'reviews',
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => WPBR_PLUGIN_URL . 'assets/images/wpbr-menu-icon-white.png',
			'show_in_admin_bar'   => false,
			'show_in_nav_menus'   => false,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
			'capabilities'        => array(
				'create_posts' => 'do_not_allow', // Removes support for the "Add New" function.
			),
			'map_meta_cap'        => true, // Allow users to still edit and delete posts.

		);

		register_post_type( 'wpbr_review', $args );
	}

	/**
	 * Registers the wpbr_platform taxonomy.
	 *
	 * @since 1.0.0
	 */
	public function register_platform_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Platforms', 'Taxonomy General Name', 'wpbr' ),
			'singular_name'              => _x( 'Platform', 'Taxonomy Singular Name', 'wpbr' ),
			'menu_name'                  => __( 'Platforms', 'wpbr' ),
			'all_items'                  => __( 'All Platforms', 'wpbr' ),
			'parent_item'                => __( 'Parent Platform', 'wpbr' ),
			'parent_item_colon'          => __( 'Parent Platform:', 'wpbr' ),
			'new_item_name'              => __( 'New Platform Name', 'wpbr' ),
			'add_new_item'               => __( 'Add New Platform', 'wpbr' ),
			'edit_item'                  => __( 'Edit Platform', 'wpbr' ),
			'update_item'                => __( 'Update Platform', 'wpbr' ),
			'view_item'                  => __( 'View Platform', 'wpbr' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'wpbr' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'wpbr' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wpbr' ),
			'popular_items'              => __( 'Popular Platforms', 'wpbr' ),
			'search_items'               => __( 'Search Platforms', 'wpbr' ),
			'not_found'                  => __( 'Not Found', 'wpbr' ),
			'no_terms'                   => __( 'No items', 'wpbr' ),
			'items_list'                 => __( 'Platforms list', 'wpbr' ),
			'items_list_navigation'      => __( 'Platforms list navigation', 'wpbr' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => false,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => true,
			'show_in_rest'      => false,
		);

		register_taxonomy( 'wpbr_platform', array( 'wpbr_business', 'wpbr_review' ), $args );
	}
}
