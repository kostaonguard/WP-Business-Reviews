<?php
/**
 * Defines the Google Places section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'review_source' => array(
		'name'   => __( 'Review Source', 'wp-business-reviews' ),
		'fields' => array(
			'platform_search' => array(
				'type'  => 'platform_search',
				'subfields' => array(
					'platform' => array(
						'type'        => 'hidden',
						'value'       => 'google_places',
					),
					'platform_search_terms' => array(
						'name'        => __( 'Search Terms', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'coffee',
						'tooltip'     => __( 'Defines the terms used when searching the Google Places API.', 'wp-business-reviews' ),
						'placeholder' => __( 'Business name or type', 'wp-business-reviews' ),
					),
					'platform_search_location' => array(
						'name'        => __( 'Location', 'wp-business-reviews' ),
						'type'        => 'text',
						'value'       => 'Pittsburgh, PA',
						'tooltip'     => __( 'Defines the location used when searching the Google Places API.', 'wp-business-reviews' ),
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
