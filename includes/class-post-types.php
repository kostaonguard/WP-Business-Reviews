<?php

/**
 * Defines the Post_Types class
 *
 * @package WP_Business_Reviews\Includes
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers custom post types and taxonomies.
 *
 * @since 0.1.0
 */
class Post_Types {
	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
	}

	/**
	 * Registers all custom post types.
	 *
	 * @since 0.1.0
	 */
	public function register_post_types() {
		$this->register_review_post_type();
		$this->register_review_source_post_type();
		$this->register_blueprint_post_type();
	}

	/**
	 * Registers all custom taxonomies.
	 *
	 * @since 0.1.0
	 */
	public function register_taxonomies() {
		$this->register_platform_taxonomy();
	}

	/**
	 * Insert default terms.
	 *
	 * @since 0.1.0
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
	 * Registers the wpbr_review post type.
	 *
	 * @since 0.1.0
	 */
	public function register_review_post_type() {

		$labels = array(
			'name'                  => _x( 'Reviews', 'Post Type General Name', 'wp-business-reviews' ),
			'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'wp-business-reviews' ),
			'menu_name'             => __( 'Reviews', 'wp-business-reviews' ),
			'name_admin_bar'        => __( 'Review', 'wp-business-reviews' ),
			'archives'              => __( 'Review Archives', 'wp-business-reviews' ),
			'attributes'            => __( 'Review Attributes', 'wp-business-reviews' ),
			'parent_item_colon'     => __( 'Parent Review:', 'wp-business-reviews' ),
			'all_items'             => __( 'All Reviews', 'wp-business-reviews' ),
			'add_new_item'          => __( 'Add New Review', 'wp-business-reviews' ),
			'add_new'               => __( 'Add Review', 'wp-business-reviews' ),
			'new_item'              => __( 'New Review', 'wp-business-reviews' ),
			'edit_item'             => __( 'Edit Review', 'wp-business-reviews' ),
			'update_item'           => __( 'Update Review', 'wp-business-reviews' ),
			'view_item'             => __( 'View Review', 'wp-business-reviews' ),
			'view_items'            => __( 'View Reviews', 'wp-business-reviews' ),
			'search_items'          => __( 'Search Review', 'wp-business-reviews' ),
			'not_found'             => __( 'Not found', 'wp-business-reviews' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-business-reviews' ),
			'featured_image'        => __( 'Featured Image', 'wp-business-reviews' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-business-reviews' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-business-reviews' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-business-reviews' ),
			'insert_into_item'      => __( 'Insert into item', 'wp-business-reviews' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-business-reviews' ),
			'items_list'            => __( 'Reviews list', 'wp-business-reviews' ),
			'items_list_navigation' => __( 'Reviews list navigation', 'wp-business-reviews' ),
			'filter_items_list'     => __( 'Filter items list', 'wp-business-reviews' ),
		);

		$rewrite = array(
			'slug' => 'wpbr-reviews',
		);

		$args = array(
			'label'               => __( 'Review', 'wp-business-reviews' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'           => 'reviews',
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => WPBR_ASSETS_URL . 'images/wpbr-menu-icon-white.png',
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
	 * Registers the wpbr_review_source post type.
	 *
	 * @since 0.1.0
	 */
	public function register_review_source_post_type() {
		$labels = array(
			'name'                  => _x( 'Review Sources', 'Post Type General Name', 'wp-business-reviews' ),
			'singular_name'         => _x( 'Review Source', 'Post Type Singular Name', 'wp-business-reviews' ),
			'menu_name'             => __( 'Review Sources', 'wp-business-reviews' ),
			'name_admin_bar'        => __( 'Review Source', 'wp-business-reviews' ),
			'archives'              => __( 'Review Source Archives', 'wp-business-reviews' ),
			'attributes'            => __( 'Review Source Attributes', 'wp-business-reviews' ),
			'parent_item_colon'     => __( 'Parent Review Source:', 'wp-business-reviews' ),
			'all_items'             => __( 'All Review Sources', 'wp-business-reviews' ),
			'add_new_item'          => __( 'Add New Review Source', 'wp-business-reviews' ),
			'add_new'               => __( 'Add Review Source', 'wp-business-reviews' ),
			'new_item'              => __( 'New Review Source', 'wp-business-reviews' ),
			'edit_item'             => __( 'Edit Review Source', 'wp-business-reviews' ),
			'update_item'           => __( 'Update Review Source', 'wp-business-reviews' ),
			'view_item'             => __( 'View Review Source', 'wp-business-reviews' ),
			'view_items'            => __( 'View Review Sources', 'wp-business-reviews' ),
			'search_items'          => __( 'Search Review Sources', 'wp-business-reviews' ),
			'not_found'             => __( 'Not found', 'wp-business-reviews' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-business-reviews' ),
			'featured_image'        => __( 'Featured Image', 'wp-business-reviews' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-business-reviews' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-business-reviews' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-business-reviews' ),
			'insert_into_item'      => __( 'Insert into item', 'wp-business-reviews' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-business-reviews' ),
			'items_list'            => __( 'Review Sources list', 'wp-business-reviews' ),
			'items_list_navigation' => __( 'Review Sources list navigation', 'wp-business-reviews' ),
			'filter_items_list'     => __( 'Filter items list', 'wp-business-reviews' ),
		);

		$rewrite = array(
			'slug' => 'wpbr-review-sources',
		);

		$args = array(
			'label'               => __( 'Review Source', 'wp-business-reviews' ),
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

		register_post_type( 'wpbr_review_source', $args );
	}

	/**
	 * Registers the wpbr_blueprint post type.
	 *
	 * @since 0.1.0
	 */
	public function register_blueprint_post_type() {

		$labels = array(
			'name'                  => _x( 'Blueprints', 'Post Type General Name', 'wp-business-reviews' ),
			'singular_name'         => _x( 'Blueprint', 'Post Type Singular Name', 'wp-business-reviews' ),
			'menu_name'             => __( 'Blueprints', 'wp-business-reviews' ),
			'name_admin_bar'        => __( 'Blueprint', 'wp-business-reviews' ),
			'archives'              => __( 'Blueprint Archives', 'wp-business-reviews' ),
			'attributes'            => __( 'Blueprint Attributes', 'wp-business-reviews' ),
			'parent_item_colon'     => __( 'Parent Blueprint:', 'wp-business-reviews' ),
			'all_items'             => __( 'All Blueprints', 'wp-business-reviews' ),
			'add_new_item'          => __( 'Add New Blueprint', 'wp-business-reviews' ),
			'add_new'               => __( 'Add Blueprint', 'wp-business-reviews' ),
			'new_item'              => __( 'New Blueprint', 'wp-business-reviews' ),
			'edit_item'             => __( 'Edit Blueprint', 'wp-business-reviews' ),
			'update_item'           => __( 'Update Blueprint', 'wp-business-reviews' ),
			'view_item'             => __( 'View Blueprint', 'wp-business-reviews' ),
			'view_items'            => __( 'View Blueprints', 'wp-business-reviews' ),
			'search_items'          => __( 'Search Blueprint', 'wp-business-reviews' ),
			'not_found'             => __( 'Not found', 'wp-business-reviews' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'wp-business-reviews' ),
			'featured_image'        => __( 'Featured Image', 'wp-business-reviews' ),
			'set_featured_image'    => __( 'Set featured image', 'wp-business-reviews' ),
			'remove_featured_image' => __( 'Remove featured image', 'wp-business-reviews' ),
			'use_featured_image'    => __( 'Use as featured image', 'wp-business-reviews' ),
			'insert_into_item'      => __( 'Insert into item', 'wp-business-reviews' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'wp-business-reviews' ),
			'items_list'            => __( 'Blueprints list', 'wp-business-reviews' ),
			'items_list_navigation' => __( 'Blueprints list navigation', 'wp-business-reviews' ),
			'filter_items_list'     => __( 'Filter items list', 'wp-business-reviews' ),
		);

		$rewrite = array(
			'slug' => 'wpbr-blueprints',
		);

		$args = array(
			'label'               => __( 'Blueprint', 'wp-business-reviews' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_in_rest'        => true,
			'rest_base'          => 'blueprints',
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-layout',
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

		register_post_type( 'wpbr_blueprint', $args );
	}

	/**
	 * Registers the wpbr_platform taxonomy.
	 *
	 * @since 0.1.0
	 */
	public function register_platform_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Platforms', 'Taxonomy General Name', 'wp-business-reviews' ),
			'singular_name'              => _x( 'Platform', 'Taxonomy Singular Name', 'wp-business-reviews' ),
			'menu_name'                  => __( 'Platforms', 'wp-business-reviews' ),
			'all_items'                  => __( 'All Platforms', 'wp-business-reviews' ),
			'parent_item'                => __( 'Parent Platform', 'wp-business-reviews' ),
			'parent_item_colon'          => __( 'Parent Platform:', 'wp-business-reviews' ),
			'new_item_name'              => __( 'New Platform Name', 'wp-business-reviews' ),
			'add_new_item'               => __( 'Add New Platform', 'wp-business-reviews' ),
			'edit_item'                  => __( 'Edit Platform', 'wp-business-reviews' ),
			'update_item'                => __( 'Update Platform', 'wp-business-reviews' ),
			'view_item'                  => __( 'View Platform', 'wp-business-reviews' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'wp-business-reviews' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'wp-business-reviews' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wp-business-reviews' ),
			'popular_items'              => __( 'Popular Platforms', 'wp-business-reviews' ),
			'search_items'               => __( 'Search Platforms', 'wp-business-reviews' ),
			'not_found'                  => __( 'Not Found', 'wp-business-reviews' ),
			'no_terms'                   => __( 'No items', 'wp-business-reviews' ),
			'items_list'                 => __( 'Platforms list', 'wp-business-reviews' ),
			'items_list_navigation'      => __( 'Platforms list navigation', 'wp-business-reviews' ),
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
