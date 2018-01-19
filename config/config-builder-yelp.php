<?php
/**
 * Defines the Yelp section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'platform' => array(
		'name'   => __( 'Yelp', 'wp-business-reviews' ),
		'fields' => array(
			'platform_search' => array(
				'type'  => 'platform_search',
				'subfields' => array(
					'platform_search_platform' => array(
						'type'        => 'hidden',
						'value'       => 'yelp',
					),
					'platform_search_terms' => array(
						'name'        => __( 'Search Terms', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'tacos',
						'tooltip'     => __( 'Defines the terms used when searching the Yelp API.', 'wp-business-reviews' ),
						'placeholder' => __( 'Business name or type', 'wp-business-reviews' ),
					),
					'platform_search_location' => array(
						'name'        => __( 'Location', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'San Diego, CA',
						'tooltip'     => __( 'Defines the location used when searching the Yelp API.', 'wp-business-reviews' ),
						'placeholder' => __( 'City, state, or postal code', 'wp-business-reviews' ),
					),
					'platform_search_button' => array(
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
