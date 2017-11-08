<?php
/**
 * Defines the Admin_Page class
 *
 * @package WP_Business_Reviews\Includes\Admin
 * @since   1.0.0
 */

namespace WP_Business_Reviews\Includes\Admin;

/**
 * Creates an admin page for the plugin.
 *
 * @since 1.0.0
 * @see Admin_Menu
 */
class Admin_Page {
	/**
	 * Instantiates a Submenu_Page object.
	 *
	 * @param string   $parent_slug The slug name for the parent menu (or the file name of a standard
	 *                              WordPress admin page).
	 * @param string   $page_title  The text to be displayed in the title tags of the page when the menu
	 *                              is selected.
	 * @param string   $menu_title  The text to be used for the menu.
	 * @param string   $capability  The capability required for this menu to be displayed to the user.
	 * @param string   $menu_slug   The slug name to refer to this menu by. Should be unique for this menu
	 *                              and only include lowercase alphanumeric, dashes, and underscores characters
	 *                              to be compatible with sanitize_key().
	 * @param callable $function    The function to be called to output the content for this page.
	 */
	public function __construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function = '' ) {
		$this->parent_slug = $parent_slug;
		$this->page_title  = $page_title;
		$this->menu_title  = $menu_title;
		$this->capability  = $capability;
		$this->menu_slug   = $menu_slug;
	}

	public function register() {
		add_submenu_page(
			$this->parent_slug,
			$this->page_title,
			$this->menu_title,
			$this->capability,
			$this->menu_slug,
			array( $this, 'render_page' )
		);
	}

	/**
	 * Renders a given view.
	 *
	 * @since 1.0.0
	 *
	 * @param string|View $view View to render. Can be a path to a view file
	 *                          or an instance of a View object.
	 */
	public function render_view( $view ) {
		$view_object = is_string( $view ) ? new View( $view ) : $view;
		$view_object->render();
	}

	/**
	 * Renders the admin page.
	 *
	 * @since 1.0.0
	 *
	 * @param string|View $view View to render. Can be a path to a view file
	 *                          or an instance of a View object.
	 */
	public function render_page( $view = '' ) {
		// TODO: Add hook before admin page view.
		if ( ! empty( $view ) ) {
			$this->render_view( $view );
		}
		// TODO: Add hook after admin page view.
	}
}
