<?php
/**
 * Defines the WP_Business_Reviews_Widget class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Widget
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Widget;

/**
 * Displays review content based on a Blueprint post defined in the Builder.
 *
 * @since 0.1.0
 *
 * @see WP_Widget
 */
class WP_Business_Reviews_Widget extends \WP_Widget {
	/**
	 * @since 0.1.0
	 */
	public function __construct() {
		parent::__construct(
			'wp_business_reviews_widget',
			__( 'WP Business Reviews', 'wp-business-reviews' ),
			array(
				'classname'   => 'wp_business_reviews_widget',
				'description' => __(
					'Displays a collection of reviews or review sources according to a user-defined Blueprint.',
					'wp-business-reviews'
				),
			)
		);
	}

	/**
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'widgets_init', function() {
			register_widget( $this );
		});
	}

	/**
	 * @since 0.1.0
	 */
	public function widget( $args, $instance ) {
	}

	/**
	 * @since 0.1.0
	 */
	public function form( $instance ) {
	}

	/**
	 * @since 0.1.0
	 */
	public function update( $new_instance, $old_instance ) {
	}
}
