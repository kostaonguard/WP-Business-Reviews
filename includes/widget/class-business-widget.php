<?php

/**
 * Defines the Business widget
 *
 * @package WP_Business_Reviews\Includes\Business
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Widget;

use WP_Business_Reviews\Includes\Business\Business;
use \WP_Widget;

/**
 * Implements the Business widget.
 *
 * This basic widget displays business details.
 *
 * @since 0.1.0
 */
class Business_Widget extends WP_Widget {
	/**
	 * Sets up the widget.
	 */
	public function __construct() {
		$widget_options = array(
			'classname'   => 'business_widget',
			'description' => __( 'Display business details.'),
		);

		parent::__construct( 'wpbr_business', 'WPBR Business', $widget_options );
	}

	/**
	 * Echoes the widget content.
	 *
	 * {@inheritdoc}
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance The settings for the particular instance of the widget.
	 */
	public function widget( $args, $instance ) {
		$business = new Business( $instance['business_id'], $instance['platform'] );

		ob_start();
		include WPBR_PLUGIN_DIR . 'templates/business-details.php';
		echo ob_get_clean();
	}

	/**
	 * Outputs the settings update form.
	 *
	 * {@inheritdoc}
	 *
	 * @param array $instance Current settings.
	 *
	 * @return string Default return is 'noform'.
	 */
	public function form( $instance ) {
		$business_id = $instance['business_id'];
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'platform' ) ); ?>">
				<?php _e( 'Platform:', 'wpbr' ); ?>
			</label>
			<select
				name="<?php echo esc_attr( $this->get_field_name( 'platform' ) ); ?>"
				id="<?php echo esc_attr( $this->get_field_id( 'platform' ) ); ?>"
				class="widefat">
				<option value="google_places"<?php selected( $instance['platform'], 'google_places' ); ?>><?php _e( 'Google', 'wpbr' ); ?></option>
				<option value="facebook"<?php selected( $instance['platform'], 'facebook' ); ?>><?php _e( 'Facebook', 'wpbr' ); ?></option>
				<option value="yelp"<?php selected( $instance['platform'], 'yelp' ); ?>><?php _e( 'Yelp', 'wpbr' ); ?></option>
				<option value="yp"<?php selected( $instance['platform'], 'yp' ); ?>><?php _e( 'YP', 'wpbr' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'business_id' ); ?>">
				<?php _e( 'Business ID:', 'wpbr' ); ?>
			</label>
			<input type="text" id="<?php echo $this->get_field_id( 'business_id' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'business_id' ); ?>" value="<?php echo esc_attr( $business_id ); ?>">
		</p>
<?php
	}

	/**
	 * Updates a particular instance of a widget.
	 *
	 * {@inheritdoc}
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 *
	 * @return array Settings to save or bool false to cancel saving.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                = $old_instance;
		$instance['business_id'] = strip_tags( $new_instance['business_id'] );
		$instance['platform']    = strip_tags( $new_instance['platform'] );

		return $instance;
	}
}
