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
			'format' => array(
				'name'    => __( 'Format', 'wp-business-reviews' ),
				'type'    => 'select',
				'tooltip' => __( 'Defines the format in which reviews are displayed.', 'wp-business-reviews' ),
				'default' => 'review_gallery',
				'options' => array(
					'review_gallery'  => __( 'Review Gallery', 'wp-business-reviews' ),
					'review_list'     => __( 'Review List', 'wp-business-reviews' ),
					'review_carousel' => __( 'Review Carousel', 'wp-business-reviews' ),
					'business_badge'  => __( 'Business Badge', 'wp-business-reviews' ),
				),
			),
			'max_columns' => array(
				'name'     => __( 'Maximum Columns', 'wp-business-reviews' ),
				'type'     => 'select',
				'tooltip'  => __( 'Sets the maximum number of columns in the responsive gallery. Fewer columns may be shown based on available width.', 'wp-business-reviews' ),
				'default'  => 2,
				'options'  => array(
					'1' => __( '1 Column', 'wp-business-reviews' ),
					'2' => __( '2 Columns', 'wp-business-reviews' ),
					'3' => __( '3 Columns', 'wp-business-reviews' ),
					'4' => __( '4 Columns', 'wp-business-reviews' ),
					'5' => __( '5 Columns', 'wp-business-reviews' ),
					'6' => __( '6 Columns', 'wp-business-reviews' ),
				),
			),
			'max_characters' => array(
				'name'    => __( 'Maximum Characters', 'wp-business-reviews' ),
				'type'    => 'number',
				'tooltip' => __( 'Sets the maximum character limit before the review is truncated. An empty or 0 value will cause the full review to always display.', 'wp-business-reviews' ),
				'default' => 280,
				'placeholder' => __( 'Unlimited', 'wp-business-reviews' ),
			),
			'review_components' => array(
				'name'    => __( 'Review Components', 'wp-business-reviews' ),
				'type'    => 'checkboxes',
				'tooltip' => __( 'Defines the visible components of a review.', 'wp-business-reviews' ),
				'default' => array(
					'review_image',
					'review_rating',
					'review_timestamp',
					'review_content',
				),
				'options' => array(
					'review_image'     => __( 'Review Image', 'wp-business-reviews' ),
					'review_rating'    => __( 'Star Rating', 'wp-business-reviews' ),
					'review_timestamp' => __( 'Timestamp', 'wp-business-reviews' ),
					'review_content'   => __( 'Review Content', 'wp-business-reviews' ),
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
