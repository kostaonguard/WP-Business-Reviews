<?php
/**
 * Defines the YP section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'platform' => array(
		'name'   => __( 'YP', 'wp-business-reviews' ),
		'fields' => array(
			'platform_search' => array(
				'type'  => 'platform_search',
				'subfields' => array(
					'search_platform' => array(
						'type'        => 'hidden',
						'value'       => 'yelp',
					),
					'search_terms' => array(
						'name'        => __( 'Search Terms', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'tacos',
						'tooltip'     => __( 'Defines the terms used when searching the YP API.', 'wp-business-reviews' ),
						'placeholder' => __( 'Business name or type', 'wp-business-reviews' ),
					),
					'search_location' => array(
						'name'        => __( 'Location', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'San Diego, CA',
						'tooltip'     => __( 'Defines the location used when searching the YP API.', 'wp-business-reviews' ),
						'placeholder' => __( 'City, state, or postal code', 'wp-business-reviews' ),
					),
					'search_button' => array(
						'type'        => 'button',
						'button_text' => __( 'Search', 'wp-business-reviews' ),
						'value'       => 'search',
					),
				),
			),
		),
	),
);

return $config;
