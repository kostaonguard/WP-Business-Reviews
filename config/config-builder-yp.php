<?php
/**
 * Defines the YP section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'yp_jsearch' => array(
		'name'   => __( 'YP Search', 'wp-business-reviews' ),
		'fields' => array(
			'yp_search_terms' => array(
				'name'        => __( 'Search Terms', 'wp-business-reviews' ),
				'type'        => 'text',
				'tooltip'     => __( 'Defines the terms used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'Business Name or Type', 'wp-business-reviews' ),
			),
			'yp_search_location' => array(
				'name'        => __( 'Location', 'wp-business-reviews' ),
				'type'        => 'text',
				'tooltip'     => __( 'Defines the location used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'City, State, or Postal Code', 'wp-business-reviews' ),
			),
			'yp_search_button' => array(
				'type'        => 'button',
				'button_text' => __( 'Find Business', 'wp-business-reviews' ),
			),
		),
	),
);

return $config;
