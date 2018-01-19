<?php
/**
 * Defines the Facebook section of the Builder.
 *
 * @package WP_Business_Reviews\Config
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Config;

$config = array(
	'review_source' => array(
		'name'   => __( 'Facebook', 'wp-business-reviews' ),
		'fields' => array(
			'facebook_pages_select' => array(
				'name'    => __( 'Facebook Page', 'wp-business-reviews' ),
				'type'    => 'facebook_pages_select',
				'tooltip' => 'Defines the Facebook page from which reviews are sourced.'
			),
		),
	),
);

return $config;
