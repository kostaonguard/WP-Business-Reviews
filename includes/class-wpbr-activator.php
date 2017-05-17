<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WPBR
 * @subpackage WPBR/includes
 * @author     WordImpress, LLC <info@wordimpress.com>
 */
class WPBR_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$post_types = new WPBR_Post_Types();
		$post_types->register_post_types();
		$post_types->register_taxonomies();
		$post_types->insert_terms();
		flush_rewrite_rules();

	}

}
