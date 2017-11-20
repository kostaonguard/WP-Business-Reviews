<?php
/**
 * Defines the reviews builder config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$section_presentation = array(
	'section_id'   => 'presentation',
	'section_name' => __( 'Presentation', 'wp-business-reviews' ),
	'fields'  => array(
		'format' => array(
			'id'      => 'format',
			'name'    => __( 'Format', 'wp-business-reviews' ),
			'control' => 'select',
			'tooltip' => __( 'Defines the format in which reviews are displayed.', 'wp-business-reviews' ),
			'default' => 'gallery',
			'options' => array(
				'reviews-gallery'  => __( 'Reviews Gallery', 'wp-business-reviews' ),
				'reviews-list'     => __( 'Reviews List', 'wp-business-reviews' ),
				'reviews-carousel' => __( 'Reviews Carousel', 'wp-business-reviews' ),
				'business-badge'   => __( 'Business Badge', 'wp-business-reviews' ),
			),
		),
		'max-columns' => array(
			'id'       => 'max_columns',
			'name'     => __( 'Maximum Columns', 'wp-business-reviews' ),
			'control'  => 'input',
			'tooltip'  => __( 'Sets the maximum number of columns in the responsive gallery. Fewer columns may be shown based on available width.', 'wp-business-reviews' ),
			'default'  => '3',
			'control_atts' => array(
				'type' => 'range',
				'min'  => 1,
				'max'  => 6,
				'step' => 1,
			),
			'datalist' => array( 1, 2, 3, 4, 5, 6 ),
		),
		'theme' => array(
			'id'      => 'theme',
			'name'    => __( 'Theme', 'wp-business-reviews' ),
			'control' => 'select',
			'tooltip' => __( 'Styles the appearance of reviews.', 'wp-business-reviews' ),
			'default' => 'card',
			'options' => array(
				'card'           => __( 'Card', 'wp-business-reviews' ),
				'seamless-light' => __( 'Seamless Light', 'wp-business-reviews' ),
				'seamless-dark'  => __( 'Seamless Dark', 'wp-business-reviews' ),
			),
		),
	),
);

$section_business = array(
	'section_id'   => 'business',
	'section_name' => __( 'Business', 'wp-business-reviews' ),
	'fields'  => array(
		'platform' => array(
			'id'      => 'platform',
			'name'    => __( 'Platform', 'wp-business-reviews' ),
			'control' => 'select',
			'tooltip' => __( 'Defines the platform used when searching for a business.', 'wp-business-reviews' ),
			'options' => array(
				'google'   => __( 'Google', 'wp-business-reviews' ),
				'facebook' => __( 'Facebook', 'wp-business-reviews' ),
				'yelp'     => __( 'Yelp', 'wp-business-reviews' ),
				'yp'       => __( 'YP', 'wp-business-reviews' ),
			),
		),
		'business-search' => array(
			'id'         => 'business_search',
			'name'       => __( 'Business', 'wp-business-reviews' ),
			'control'    => 'search',
			'tooltip'    => __( 'Defines the query used when searching for a business.', 'wp-business-reviews' ),
			'control_atts' => array(
				'placeholder' => __( 'Business Name, Location', 'wp-business-reviews' ),
			),
		),
	),
);

$section_reviews = array(
	'section_id'   => 'reviews',
	'section_name' => __( 'Reviews', 'wp-business-reviews' ),
	'fields'  => array(
		'review_components' => array(
			'id'      => 'review_components',
			'name'    => __( 'Review Components', 'wp-business-reviews' ),
			'control' => 'checkboxes',
			'tooltip' => __( 'Defines the visible components of a review.', 'wp-business-reviews' ),
			'options' => array(
				'review_image' => __( 'Review Image', 'wp-business-reviews' ),
				'rating'       => __( 'Star Rating', 'wp-business-reviews' ),
				'timestamp'    => __( 'Timestamp', 'wp-business-reviews' ),
			),
		),
	),
);

/**
 * Filters the Reviews Builder config.
 *
 * @since 0.1.0
 *
 * @param array $config Reviews Builder config containing sections and fields.
 */
$config = apply_filters(
	'wpbr_config_reviews_builder',
	array(
		'presentation' => $section_presentation,
		'business'     => $section_business,
		'reviews'      => $section_reviews,
	)
);

return $config;
