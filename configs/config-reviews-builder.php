<?php
/**
 * Defines the reviews builder config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'presentation' => array(
		'name'   => __( 'Presentation', 'wp-business-reviews' ),
		'fields' => array(
			'format' => array(
				'name'    => __( 'Format', 'wp-business-reviews' ),
				'type'    => 'select',
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
				'name'     => __( 'Maximum Columns', 'wp-business-reviews' ),
				'type'     => 'select',
				'tooltip'  => __( 'Sets the maximum number of columns in the responsive gallery. Fewer columns may be shown based on available width.', 'wp-business-reviews' ),
				'default'  => '3',
				'options'  => array(
					'1' => __( '1 Column', 'wp-business-reviews' ),
					'2' => __( '2 Columns', 'wp-business-reviews' ),
					'3' => __( '3 Columns', 'wp-business-reviews' ),
					'4' => __( '4 Columns', 'wp-business-reviews' ),
					'5' => __( '5 Columns', 'wp-business-reviews' ),
					'6' => __( '6 Columns', 'wp-business-reviews' ),
				),
			),
			'theme' => array(
				'name'    => __( 'Theme', 'wp-business-reviews' ),
				'type'    => 'select',
				'tooltip' => __( 'Styles the appearance of reviews.', 'wp-business-reviews' ),
				'default' => 'card',
				'options' => array(
					'card'           => __( 'Card', 'wp-business-reviews' ),
					'seamless-light' => __( 'Seamless Light', 'wp-business-reviews' ),
					'seamless-dark'  => __( 'Seamless Dark', 'wp-business-reviews' ),
				),
			),
		),
	),
	'business' => array(
		'name'   => __( 'Business', 'wp-business-reviews' ),
		'fields' => array(
			'platform' => array(
				'name'    => __( 'Platform', 'wp-business-reviews' ),
				'type'    => 'select',
				'tooltip' => __( 'Defines the platform used when searching for a business.', 'wp-business-reviews' ),
				'options' => array(
					'google'   => __( 'Google', 'wp-business-reviews' ),
					'facebook' => __( 'Facebook', 'wp-business-reviews' ),
					'yelp'     => __( 'Yelp', 'wp-business-reviews' ),
					'yp'       => __( 'YP', 'wp-business-reviews' ),
				),
			),
			'business-search' => array(
				'name'       => __( 'Business', 'wp-business-reviews' ),
				'type'       => 'search',
				'tooltip'    => __( 'Defines the query used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'Business Name, Location', 'wp-business-reviews' ),
			),
		),
	),
	'reviews' => array(
		'name'   => __( 'Reviews', 'wp-business-reviews' ),
		'fields' => array(
			'review_components' => array(
				'name'    => __( 'Review Components', 'wp-business-reviews' ),
				'type'    => 'checkboxes',
				'tooltip' => __( 'Defines the visible components of a review.', 'wp-business-reviews' ),
				'default' => array(
					'review_image',
					'rating',
					'timestamp',
				),
				'options' => array(
					'review_image' => __( 'Review Image', 'wp-business-reviews' ),
					'rating'       => __( 'Star Rating', 'wp-business-reviews' ),
					'timestamp'    => __( 'Timestamp', 'wp-business-reviews' ),
				),
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
return apply_filters( 'wpbr_config_reviews_builder', $config );
