<?php
/**
 * Defines the reviews builder config.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$section_presentation = array(
	'id'   => 'presentation',
	'name' => __( 'Presentation', 'wpbr' ),
	/**
	* Filters the fields in the Presentation section of the Reviews Builder.
	*
	* @since 0.1.0
	*
	* @param array $fields Reviews Builder fields.
	*/
	'fields'  => apply_filters(
		'wpbr_reviews_builder_fields_presentation',
		array(
			'format' => array(
				'id'      => 'format',
				'name'    => __( 'Format', 'wpbr' ),
				'control' => 'select',
				'tooltip' => __( 'Defines the format in which reviews are displayed.', 'wpbr' ),
				'default' => 'gallery',
				'options' => array(
					'reviews-gallery'  => __( 'Reviews Gallery', 'wpbr' ),
					'reviews-list'     => __( 'Reviews List', 'wpbr' ),
					'reviews-carousel' => __( 'Reviews Carousel', 'wpbr' ),
					'business-badge'   => __( 'Business Badge', 'wpbr' ),
				),
			),
			'max-columns' => array(
				'id'       => 'max_columns',
				'name'     => __( 'Maximum Columns', 'wpbr' ),
				'control'  => 'input',
				'tooltip'  => __( 'Sets the maximum number of columns in the responsive gallery. Fewer columns may be shown based on available width.', 'wpbr' ),
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
				'name'    => __( 'Theme', 'wpbr' ),
				'control' => 'select',
				'tooltip' => __( 'Styles the appearance of reviews.', 'wpbr' ),
				'default' => 'card',
				'options' => array(
					'card'           => __( 'Card', 'wpbr' ),
					'seamless-light' => __( 'Seamless Light', 'wpbr' ),
					'seamless-dark'  => __( 'Seamless Dark', 'wpbr' ),
				),
			),
		)
	),
);

$section_business = array(
	'id'   => 'business',
	'name' => __( 'Business', 'wpbr' ),
	/**
	* Filters the fields in the Business section of the Reviews Builder.
	*
	* @since 0.1.0
	*
	* @param array $fields Reviews Builder fields.
	*/
	'fields'  => apply_filters(
		'wpbr_reviews_builder_fields_business',
		array(
			'platform' => array(
				'id'      => 'platform',
				'name'    => __( 'Platform', 'wpbr' ),
				'control' => 'select',
				'tooltip' => __( 'Defines the platform used when searching for a business.', 'wpbr' ),
				'options' => array(
					'google'   => __( 'Google', 'wpbr' ),
					'facebook' => __( 'Facebook', 'wpbr' ),
					'yelp'     => __( 'Yelp', 'wpbr' ),
					'yp'       => __( 'YP', 'wpbr' ),
				),
			),
			'business-search' => array(
				'id'         => 'business_search',
				'name'       => __( 'Business', 'wpbr' ),
				'control'    => 'search',
				'tooltip'    => __( 'Defines the query used when searching for a business.', 'wpbr' ),
				'control_atts' => array(
					'placeholder' => __( 'Business Name, Location', 'wpbr' ),
				),
			),
		)
	),
);

$section_reviews = array(
	'id'   => 'reviews',
	'name' => __( 'Reviews', 'wpbr' ),
	/**
	* Filters the fields in the Reviews section of the Reviews Builder.
	*
	* @since 0.1.0
	*
	* @param array $fields Reviews Builder fields.
	*/
	'fields'  => apply_filters(
		'wpbr_reviews_builder_fields_reviews',
		array(
			// 'review_order' => array(
			// 	'id'      => 'review_order',
			// 	'name'    => __( 'Review Order', 'wpbr' ),
			// 	'control' => 'select',
			// 	'tooltip' => __( 'Defines the order in which reviews are displayed.', 'wpbr' ),
			// 	'options' => array(
			// 		'DESC' => __( 'Newest to Oldest', 'wpbr' ),
			// 		'ASC'  => __( 'Oldest to Newest', 'wpbr' ),
			// 	),
			// ),
			'review_components' => array(
				'id'      => 'review_components',
				'name'    => __( 'Review Components', 'wpbr' ),
				'control' => 'checkboxes',
				'tooltip' => __( 'Defines the visible components of a review.', 'wpbr' ),
				'options' => array(
					'review_image' => __( 'Review Image', 'wpbr' ),
					'rating'       => __( 'Star Rating', 'wpbr' ),
					'timestamp'    => __( 'Timestamp', 'wpbr' ),
				),
			),
		)
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