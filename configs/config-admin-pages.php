<?php
/**
 * Defines the admin pages config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

/**
 * Filters the admin pages config.
 *
 * @since 0.1.0
 *
 * @param array $config Admin pages config containing menu and submenu pages.
 */
$config = apply_filters(
	'wpbr_config_admin_pages',
	array(
		'reviews_builder' => array(
			'page_parent' => 'edit.php?post_type=wpbr_review',
			'page_title' => __( 'Reviews Builder', 'wp-business-reviews' ),
			'menu_title' => __( 'Reviews Builder', 'wp-business-reviews' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'wpbr_reviews_builder',
		),
		'settings' => array(
			'page_parent' => 'edit.php?post_type=wpbr_review',
			'page_title' => __( 'Settings', 'wp-business-reviews' ),
			'menu_title' => __( 'Settings', 'wp-business-reviews' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'wpbr_settings',
		),
		'pro_features' => array(
			'page_parent' => 'edit.php?post_type=wpbr_review',
			'page_title' => __( 'WP Business Reviews Pro', 'wp-business-reviews' ),
			'menu_title' => __( 'Go Pro!', 'wp-business-reviews' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'wpbr_pro',
		),
	)
);

return $config;
