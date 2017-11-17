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
	 * @since 0.1.0
	 * @access protected
	 * @var string
	 */
	protected $uri;

	/**
	 * Associative array with context variables.
	 *
	 * @since 0.1.0
	 * @access protected
	 * @var array
	 */
	protected $context = array();

	/**
	 * Instantiates a View object.
	 *
	 * @param string $uri URI of the PHP view to render.
	 */
	public function __construct( $uri ) {
		$this->uri = $uri;
	}

	/**
	 * Renders the associated view.
	 *
	 * @param array $context Optional. Associative array with context variables.
	 * @param bool  $echo    Optional. Whether to echo the output immediately. Defaults to true.
	 * @return string HTML rendering of the view.
	 */
	public function render( $context = null, $echo = true ) {
		if ( ! $this->validate( $this->uri ) ) {
			return false;
		}

		// Set the context for the view.
		if ( ! empty( $context ) && is_array( $context ) ) {
			$this->assimilate_context( $context );
		}

		// Store the view's contents in output buffer.
		ob_start();
		include $this->uri;
		$output = ob_get_clean();

		if ( $echo ) {
			echo $output;
		} else {
			return $output;
		}
	}

	/**
	 * Renders a partial view.
	 *
	 * @param string $uri     URI of the PHP view to render.
	 * @param array  $context Optional. Associative array with context variables.
	 * @param bool   $echo    Optional. Whether to echo the output immediately. Defaults to true.
	 */
	public function render_partial( $uri, $context = null, $echo = true ) {
		if ( ! $this->validate( $this->uri ) ) {
			return false;
		}

		if ( null === $context ) {
			$context = $this->context;
		}

		$view = new static( $uri );
		$view->render( $context, $echo );
	}

	/**
	 * Validates the provided URL.
	 *
	 * @param string $uri View location relative to the plugin directory.
	 * @return string|boolean Valid URI or empty string if unreadable.
	 */
	protected function validate( $uri ) {
		if ( ! is_readable( $uri ) ) {
			return false;
		}

		return $uri;
	}

	/**
	 * Assimilate the context to make it available as properties.
	 *
	 * @since 0.1.0
	 *
	 * @param array $context Context to assimilate.
	 */
	protected function assimilate_context( array $context = array() ) {
		$this->context = $context;
		foreach ( $context as $key => $value ) {
			$this->$key = $value;
		}
	}
}
