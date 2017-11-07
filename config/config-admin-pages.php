<?php
/**
 * Defines the admin pages config.
 *
 * @package WP_Business_Reviews\Config
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Config;

/**
 * Filters the admin pages config.
 *
 * @since 1.0.0
 *
 * @param array $config Admin pages config containing menu and submenu pages.
 */
$config = apply_filters(
	'wpbr_config_admin_pages',
	array(
		'reviews_builder' => array(
			'page_title' => __( 'Reviews Builder', 'wpbr' ),
			'menu_title' => __( 'Reviews Builder', 'wpbr' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'reviews_builder',
			'view'       => '',
		),
		'settings' => array(
			'page_title' => __( 'Settings', 'wpbr' ),
			'menu_title' => __( 'Settings', 'wpbr' ),
			'capability' => 'manage_options',
			'menu_slug'  => 'settings',
			'view'       => '',
		),
	)
);

return $config;
