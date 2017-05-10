<?php

/**
 * Defines the WPBR_Post_Types class
 *
 * @link       https://wordimpress.com
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 * @since      1.0.0
 */

/**
 * Registers custom post types and taxonomies.
 *
 * @since 1.0.0
 */
class WPBR_Post_Types {


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
			'add_new'               => __( 'Add New', 'wpbr' ),
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

		$args = array(

			'label'                 => __( 'Business', 'wpbr' ),
			'labels'                => $labels,
			'supports'              => array( 'title', ),
			'taxonomies'            => array(),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-store',
			'show_in_admin_bar'     => false,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => false,
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',

		);

		register_post_type( 'wpbr_business', $args );

	}

}
