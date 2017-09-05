<?php
/**
 * Defines the Builder_Controls class
 *
 * @package WP_Business_Reviews\Includes\Admin\Builder
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin\Builder;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$builder_settings = array(
	'format' => array(
		'id'   => 'format',
		'name' => __( 'Format', 'wpbr' ),
		'type' => 'select',
		'options' => array(
			'reviews_list' => _( 'Reviews List', 'wpbr' ),
			'reviews_gallery' => _( 'Reviews Gallery', 'wpbr' ),
			'reviews_carousel' => _( 'Reviews Carousel', 'wpbr' ),
			'business_badge' => _( 'Business Badge', 'wpbr' ),
		),
	),
);
