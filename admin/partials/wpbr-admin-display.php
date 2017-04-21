<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://wordimpress.com
 * @since      1.0.0
 *
 * @package    WPBR
 * @subpackage WPBR/admin/partials
 */
?>

<div class="wrap">

	<h1>WP Business Reviews Testing</h1>

	<p>Check out these normalized API responses from four different platforms!</p>

	<h2>Google Places</h2>

	<?php
	$google_places_response = WPBR_Response_Factory::create( 'google_places', GOOGLE_PLACES_ID );
	echo '<pre>'; print_r( $google_places_response ); echo '</pre>';
	?>

	<h2>Facebook</h2>

	<?php
//	$facebook_response = WPBR_Response_Factory::create( 'facebook', FACEBOOK_PAGE_ID );
//	print_r( $facebook_response, true );
	?>

	<h2>Yelp</h2>

	<h2>YP</h2>

</div>
