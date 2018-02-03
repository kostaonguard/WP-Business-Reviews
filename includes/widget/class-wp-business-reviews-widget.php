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

use WP_Business_Reviews\Includes\Review\Review_Collection;
use WP_Business_Reviews\Includes\View;

/**
 * Displays review content based on a Blueprint post defined in the Builder.
 *
 * @since 0.1.0
 *
 * @see WP_Widget
 */
class WP_Business_Reviews_Widget extends \WP_Widget {
	/**
	 * Instantiates the WP_Business_Reviews_Widget object.
	 *
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
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'widgets_init', function() {
			register_widget( $this );
		});
	}

	/**
	 * Echoes the widget content.
	 *
	 * @since 0.1.0
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$review_collection = new Review_Collection();

		echo $args['before_widget'];
		$review_collection->render();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @since 0.1.0
	 *
	 * @param array $instance Current settings.
	 * @return string Default return is 'noform'.
	 */
	public function form( $instance ) {
		$blueprint_id = ! empty( $instance['blueprint_id'] ) ? $instance['blueprint_id'] : '';
		$field_id     = $this->get_field_id( 'blueprint_id' );
		$field_name   = $this->get_field_name( 'blueprint_id' );
		$view_object  = new View(
			WPBR_PLUGIN_DIR . 'views/widget/wp-business-reviews-widget-form.php'
		);

		$view_object->render(
			array(
				'blueprint_id' => $blueprint_id,
				'field_id'     => $field_id,
				'field_name'   => $field_name,
			)
		);
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * This function should check that `$new_instance` is set correctly. The newly-calculated
	 * value of `$instance` should be returned. If false is returned, the instance won't be
	 * saved/updated.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array|bool Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance     = array();
		$blueprint_id = ! empty( $new_instance['blueprint_id'] ) ? sanitize_text_field( $new_instance['blueprint_id'] ): '';
		$instance['blueprint_id'] = $blueprint_id;

		return $instance;
	}

	/**
	 * Renders the widget form.
	 *
	 * @since 0.1.0
	 */
	public function render_form() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/review-collection.php' );
		$view_object->render(
			array(
				'blueprint' => $this->blueprint,
				'reviews'   => $this->reviews,
			)
		);
	}
}
