<?php
/**
 * Defines the Reviews_Builder class
 *
 * @package WP_Business_Reviews\Includes\
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes;

use WP_Business_Reviews\Includes\Config;
use WP_Business_Reviews\Includes\Field\Field_Repository;
use WP_Business_Reviews\Includes\Field\Field_Parser;

/**
 * Provides the interface for building review sets.
 *
 * @since 0.1.0
 */
class Reviews_Builder {
	/**
	 * Config object containing section and field definitions.
	 *
	 * @since 0.1.0
	 * @var   Config
	 */
	private $config;

	/**
	 * Repository that holds field objects.
	 *
	 * @since 0.1.0
	 * @var   Field_Repository
	 */
	private $field_repository;

	/**
	 * Instantiates a Reviews_Builder object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config       Path to config or Config object.
	 * @param Field_Parser  $field_parser Parser to extract field definitions from config.
	 */
	public function __construct( $config, Field_Parser $field_parser ) {
		$this->config       = is_string( $config ) ? new Config( $config ): $config;
		$this->field_parser = $field_parser;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'init' ) );
		add_action( 'wpbr_review_page_reviews_builder', array( $this, 'render' ) );
	}

	/**
	 * Initializes the object for use.
	 *
	 * @since 0.1.0
	 */
	public function init() {
		// Parse the config to create field objects.
		$this->field_repository = new Field_Repository( $this->field_parser->parse_config( $this->config ) );
	}

	/**
	 * Renders the reviews builder.
	 *
	 * @since  0.1.0
	 */
	public function render() {
		$view_object = new View( WPBR_PLUGIN_DIR . 'views/reviews-builder/reviews-builder-main.php' );
		$view_object->render(
			array(
				'config'           => $this->config,
				'field_repository' => $this->field_repository
			)
		);
	}
}
