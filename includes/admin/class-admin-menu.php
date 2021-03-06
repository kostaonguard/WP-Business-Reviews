<?php
/**
 * Defines the Admin_Menu class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Admin;

use WP_Business_Reviews\Includes\Config;

/**
 * Creates the menu of admin pages for the plugin.
 *
 * @since 0.1.0
 */
class Admin_Menu {
	/**
	 * Array of admin page objects.
	 *
	 * @since 0.1.0
	 * @access private
	 * @var array
	 */
	private $pages;

	/**
	 * Instantiates an Admin_Menu object.
	 *
	 * @since 0.1.0
	 *
	 * @param string|Config $config Path to config or Config object.
	 */
	public function __construct( $config ) {
		$this->config = is_string( $config ) ? new Config( $config ) : $config;
		$this->pages  = $this->process_config( $this->config );
	}

	/**
	 * Registers functionality with WordPress.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_action( 'admin_menu', array( $this, 'add_pages' ) );
	}

	/**
	 * Converts config to array of page objects.
	 *
	 * @since  0.1.0
	 *
	 * @param Config $config Reviews Builder config.
	 * @return array Array of admin page objects.
	 */
	private function process_config( Config $config ) {
		if ( empty( $config ) ) {
			return array();
		}

		$pages = array();

		foreach ( $config as $page ) {
			if ( ! isset(
				$page['page_parent'],
				$page['page_title'],
				$page['menu_title'],
				$page['capability'],
				$page['menu_slug']
			) ) {
				// Skip if required keys are not set.
				continue;
			}

			// Create new admin page based on the config item.
			$page_object = new Admin_Page(
				$page['page_parent'],
				$page['page_title'],
				$page['menu_title'],
				$page['capability'],
				$page['menu_slug']
			);

			// Add admin page object to pages array.
			$pages[ $page['menu_slug'] ] = $page_object;
		}

		return $pages;
	}

	/**
	 * Add one or more admin pages.
	 *
	 * @since 0.1.0
	 */
	public function add_pages() {
		foreach ( $this->pages as $page ) {
			$page->register();
			$page->add_page();
		}
	}
}
