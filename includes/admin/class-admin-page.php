<?php
/**
 * Defines the Admin_Page class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   0.1.0
 */

namespace WP_Business_Reviews\Includes\Admin;

/**
 * Creates an admin page for the plugin.
 *
 * @since 0.1.0
 * @see Admin_Menu
 */
class Admin_Page {
	// TODO: Document properties.

	/**
	 * Instantiates a Submenu_Page object.
	 *
	 * @param string $parent_slug The slug name for the parent menu (or the file name of a standard
	 *                            WordPress admin page).
	 * @param string $page_title  The text to be displayed in the title tags of the page when the menu
	 *                            is selected.
	 * @param string $menu_title  The text to be used for the menu.
	 * @param string $capability  The capability required for this menu to be displayed to the user.
	 * @param string $menu_slug   The slug name to refer to this menu by. Should be unique for this menu
	 *                            and only include lowercase alphanumeric, dashes, and underscores characters
	 *                            to be compatible with sanitize_key().
	 */
	public function __construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug ) {
		$this->parent_slug = $parent_slug;
		$this->page_title  = $page_title;
		$this->menu_title  = $menu_title;
		$this->capability  = $capability;
		$this->menu_slug   = $menu_slug;
	}

	/**
	 * Registers functionality with WordPress hooks.
	 *
	 * @since 0.1.0
	 */
	public function register() {
		add_submenu_page(
			$this->parent_slug,
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug
			// TODO: Add default callable to ensure the page renders.
		);

		add_filter( 'admin_body_class', array( $this, 'add_admin_body_class' ) );// Move to Admin_Page->register().
	}

	/**
	 * Adds admin body class to all admin pages created by the plugin.
	 *
	 * @since 0.1.0
	 *
	 * @param  string $classes Space-separated list of CSS classes.
	 * @return string Filtered body classes.
	 */
	public function add_admin_body_class( $classes ) {
		if ( isset( $_GET['post_type'] ) && 'wpbr_review' === $_GET['post_type'] ) {
			// Leave space on both sides so other plugins do not conflict.
			$classes .= ' wpbr-admin ';
		}

		return $classes;
	}
}
