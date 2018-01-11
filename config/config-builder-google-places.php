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
		'name'   => __( 'Google Place', 'wp-business-reviews' ),
		'fields' => array(
			'search_platform' => array(
				'type'        => 'hidden',
				'value'       => 'google_places',
			),
			'search_terms' => array(
				'name'        => __( 'Search Terms', 'wp-business-reviews' ),
				'type'        => 'text',
				'value'       => 'coffee',
				'tooltip'     => __( 'Defines the terms used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'Business Name or Type', 'wp-business-reviews' ),
			),
			'search_location' => array(
				'name'        => __( 'Location', 'wp-business-reviews' ),
				'type'        => 'text',
				'value'       => 'Pittsburgh, PA',
				'tooltip'     => __( 'Defines the location used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'City, State, or Postal Code', 'wp-business-reviews' ),
			),
			'search_button' => array(
				'type'        => 'button',
				'button_text' => __( 'Find Business', 'wp-business-reviews' ),
				'value'       => 'search',
			),
		),
	),
);

return $config;
