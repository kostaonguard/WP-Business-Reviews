<?php
/**
 * Defines the Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\Reviews_Builder
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Reviews_Builder;

/**
 * Creates the admin banner for the plugin.
 *
 * @since 1.0.0
 */
class Reviews_Builder {
	/**
	 * Reviews Builder config containing sections and fields.
	 *
	 * @since  1.0.0
	 * @var    Config
	 * @access private
	 */
	private $config;

	public function __construct( Config $config ) {
		$this->config = $config;
	}

	/**
	 * Gets field attributes.
	 *
	 * @return array $$config
	 */
	public function get_config() {
		return $this->config;
	}

	/**
	 * Render a given view.
	 *
	 * @since 1.0.0
	 *
	 * @param string|View $view    View to render. Can be a path to a view file
	 *                             or an instance of a View object.
	 * @param array|null  $context Optional. Context variables for use in view.
	 */
	public function render_view( $view ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;
		$view_object->render( $this->get_config() );
	}
}
