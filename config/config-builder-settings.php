<?php
/**
 * Defines the reviews builder config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'business' => array(
		'name'   => __( 'Business', 'wp-business-reviews' ),
		'fields' => array(
			'business_search_terms' => array(
				'name'        => __( 'Search Terms', 'wp-business-reviews' ),
				'type'        => 'text',
				'tooltip'     => __( 'Defines the terms used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'Business Name or Type', 'wp-business-reviews' ),
			),
			'business_search_location' => array(
				'name'        => __( 'Location', 'wp-business-reviews' ),
				'type'        => 'text',
				'tooltip'     => __( 'Defines the location used when searching for a business.', 'wp-business-reviews' ),
				'placeholder' => __( 'City, State, or Postal Code', 'wp-business-reviews' ),
			),
			'business_search_button' => array(
				'type'        => 'button',
				'button_text' => __( 'Find Business', 'wp-business-reviews' ),
			),
		),
	),
	'presentation' => array(
		'name'   => __( 'Presentation', 'wp-business-reviews' ),
		'fields' => array(
			'format' => array(
				'name'    => __( 'Format', 'wp-business-reviews' ),
				'type'    => 'select',
				'tooltip' => __( 'Defines the format in which reviews are displayed.', 'wp-business-reviews' ),
				'default' => 'gallery',
				'options' => array(
					'review-gallery'  => __( 'Review Gallery', 'wp-business-reviews' ),
					'review-list'     => __( 'Review List', 'wp-business-reviews' ),
					'review-carousel' => __( 'Review Carousel', 'wp-business-reviews' ),
					'business-badge'  => __( 'Business Badge', 'wp-business-reviews' ),
				),
			),
			'max_columns' => array(
				'name'     => __( 'Maximum Columns', 'wp-business-reviews' ),
				'type'     => 'select',
				'tooltip'  => __( 'Sets the maximum number of columns in the responsive gallery. Fewer columns may be shown based on available width.', 'wp-business-reviews' ),
				'default'  => 3,
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
