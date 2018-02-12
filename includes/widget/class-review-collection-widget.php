<?php
/**
 * Defines the Review_Collection_Widget class
 *
 * @link https://wpbusinessreviews.com
 *
 * @package WP_Business_Reviews\Includes\Widget
 * @since 0.1.0
 */

namespace WP_Business_Reviews\Includes\Widget;

use WP_Business_Reviews\Includes\Deserializer\Review_Collection_Deserializer;
use WP_Business_Reviews\Includes\Review\Review_Collection;
use WP_Business_Reviews\Includes\Deserializer\Review_Deserializer;
use WP_Business_Reviews\Includes\View;

/**
 * Displays review content based on a Review Collection post defined in the Builder.
 *
 * @since 0.1.0
 *
 * @see WP_Widget
 */
class Review_Collection_Widget extends \WP_Widget {
	/**
	 * Review Collection deserializer.
	 *
	 * @since 0.1.0
	 * @var Review_Collection_Deserializer $collection_deserializer
	 */
	private $collection_deserializer;

	/**
	 * Review deserializer.
	 *
	 * @since 0.1.0
	 * @var string $review_deserializer
	 */
	private $review_deserializer;

	/**
	 * Instantiates the Review_Collection_Widget object.
	 *
	 * @since 0.1.0
	 *
	 * @param Review_Collection_Deserializer $collection_deserializer Retriever of Review Collections.
	 * @param Review_Deserializer            $review_deserializer     Retriever of Reviews.
	 */
	public function __construct(
		Review_Collection_Deserializer $collection_deserializer,
		Review_Deserializer $review_deserializer
	) {
		$this->collection_deserializer = $collection_deserializer;
		$this->review_deserializer     = $review_deserializer;

		parent::__construct(
			'review_collection_widget',
			__( 'WPBR Review Collection', 'wp-business-reviews' ),
			array(
				'classname'   => 'review_collection_widget',
				'description' => __(
					'Displays a collection of Reviews.',
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
		add_action(
			'widgets_init', function() {
				register_widget( $this );
			}
		);
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
		if ( ! isset( $instance['collection_id'] ) ) {
			return null;
		}

		$collection = $this->collection_deserializer->get_review_collection(
			$instance['collection_id']
		);

		if ( ! $collection ) {
			return null;
		}

		$reviews = $this->review_deserializer->query_reviews(
			array(
				'post_parent' => $collection->get_review_source_post_id(),
			)
		);

		// Pass the Review Collection to the front end as a JS object.
		$collection->set_reviews( $reviews );
		$collection->print_js_object();

		$view_object = new View(
			WPBR_PLUGIN_DIR . 'views/widget/review-collection-widget.php'
		);

		$view_object->render(
			array(
				'instance'   => $instance,
				'args'       => $args,
				'collection' => $collection,
			)
		);
	}

	/**
	 * Outputs the settings update form.
	 *
	 * @since 0.1.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'title'         => '',
				'collection_id' => 0,
			)
		);

		// Get all Posts of type `wpbr_collection` for use in widget form selection.
		$collection_posts = $this->collection_deserializer->query_posts(
			array(
				'posts_per_page' => 100,
				'no_found_rows'  => true,
			)
		);

		$view_object = new View(
			WPBR_PLUGIN_DIR . 'views/widget/review-collection-widget-form.php'
		);

		$view_object->render(
			array(
				'instance'         => $instance,
				'collection_posts' => $collection_posts,
				'fields'           => array(
					'title' => array(
						'field_id'   => $this->get_field_id( 'title' ),
						'field_name' => $this->get_field_name( 'title' ),
					),
					'collection_id' => array(
						'field_id'   => $this->get_field_id( 'collection_id' ),
						'field_name' => $this->get_field_name( 'collection_id' ),
					),
				),
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
		$instance                  = $old_instance;
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['collection_id'] = sanitize_text_field(
			$new_instance['collection_id']
		);

		return $instance;
	}
}
