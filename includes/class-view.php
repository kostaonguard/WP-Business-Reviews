<?php
/**
 * Example Code: Settings Page - Better Implementation v1.
 *
 * This code is part of the article "Using A Config To Write Reusable Code"
 * as published on https://www.alainschlesser.com/.
 *
 * @see       https://www.alainschlesser.com/config-files-for-reusable-code/
 *
 * @package   AlainSchlesser\BetterSettings1
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   GPL-2.0+
 * @link      https://www.alainschlesser.com/
 * @copyright 2016 Alain Schlesser
 */

namespace WP_Business_Reviews\Includes;

/**
 * Class View.
 *
 * Accepts a URI of a PHP file and renders its content on request.
 *
 * @package AlainSchlesser\BetterSettings1
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
class View {
	/**
	 * URI of the PHP view to render.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var string
	 */
	protected $uri;

	/**
	 * Associative array with context variables.
	 *
	 * @since 1.0.0
	 * @access protected
	 * @var array
	 */
	protected $context = array();

	/**
	 * Instantiate a View object.

	 * @param string $uri URI of the PHP view to render, relative to the plugin's
	 *                    root directory (e.g. views/view-name.php).
	 */
	public function __construct( $uri ) {
		$this->uri = $this->validate( $uri );
	}

	/**
	 * Render a given URI.
	 *
	 * @param array $context Optional. Associative array with context variables.
	 */
	public function render( array $context = array() ) {
		$this->context = $context;
		include $this->uri;
	}

	/**
	 * Render a partial view.
	 *
	 * @param string $uri URI of the PHP view to render.
	 * @param array  $context Optional. Associative array with context variables.
	 */
	public function render_partial( $uri, array $context = array() ) {
		if ( empty( $context ) ) {
			$context = $this->context;
		};

		$view = new static( $uri );

		$view->render( $context );
	}

	/**
	 * Validates the provided URL.
	 *
	 * @param string $uri View location relative to the plugin directory.
	 * @return string|boolean Valid URI or empty string if unreadable.
	 */
	protected function validate( $uri ) {
		$uri = WPBR_PLUGIN_DIR . $uri;

		if ( ! is_readable( $uri ) ) {
			return false;
		}

		return $uri;
	}
}
