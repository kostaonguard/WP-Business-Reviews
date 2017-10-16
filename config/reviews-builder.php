<?php
/**
 * Defines the reviews builder config.
 *
 * @package WP_Business_Reviews\Config
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Config;

// Define sections.
$section_presentation = array(
	'id'   => 'presentation',
	'name' => __( 'Presentation', 'wpbr' ),
	/**
	* Filters the fields in the Presentation section of the Reviews Builder.
	*
	* @since 1.0.0
	*
	* @param array $fields Reviews Builder fields.
	*/
	'fields'  => apply_filters(
		'wpbr_fields_reviews_builder_presentation',
		array(
			'format' => array(
				'id'          => 'format',
				'name'        => __( 'Format', 'wpbr' ),
				'type'        => 'select',
				'tooltip'     => __( 'Defines the format in which reviews are displayed.', 'wpbr' ),
				'default'     => 'gallery',
				'options'     => array(
					'reviews-gallery'  => __( 'Reviews Gallery', 'wpbr' ),
					'reviews-list'     => __( 'Reviews List', 'wpbr' ),
					'reviews-carousel' => __( 'Reviews Carousel', 'wpbr' ),
					'business-badge'   => __( 'Business Badge', 'wpbr' ),
				),
				'view' => 'views/field-select.php',
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
	* @since 1.0.0
	*
	* @param array $fields Reviews Builder fields.
	*/
	'fields'  => apply_filters(
		'wpbr_fields_reviews_builder_business',
		array(
			'platform' => array(
				'id'          => 'platform',
				'name'        => __( 'Platform', 'wpbr' ),
				'type'        => 'select',
				'tooltip'     => __( 'Defines the platform used when searching for a business.', 'wpbr' ),
				'description' => __( 'This is a test description.', 'wpbr' ),
				'options'     => array(
					'google'   => __( 'Google', 'wpbr' ),
					'facebook' => __( 'Facebook', 'wpbr' ),
					'yelp'     => __( 'Yelp', 'wpbr' ),
					'yp'       => __( 'YP', 'wpbr' ),
				),
				'view' => 'views/field-select.php',
			),
		)
	),
);

// Define config.
/**
 * Filters the Reviews Builder config.
 *
 * @since 1.0.0
 *
 * @param array $config Reviews Builder config containing sections and fields.
 */
$config = apply_filters(
	'wpbr_config_reviews_builder',
	array(
		'presentation' => $section_presentation,
		'business'     => $section_business,
	)
);

return $config;
