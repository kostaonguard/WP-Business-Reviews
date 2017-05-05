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
//	$google_business = new WPBR_Google_Places_Business( GOOGLE_PLACES_ID, 'google_places' );
//	echo '<pre>'; print_r( $google_business ); echo '</pre>';
	?>

	<h2>Facebook</h2>

	<?php
//	$facebook_business = new WPBR_Facebook_Business( FACEBOOK_PAGE_ID, 'facebook' );
//	echo '<pre>'; print_r( $facebook_business ); echo '</pre>';
	?>

	<h2>Yelp</h2>
	<?php
	$yelp_business = new WPBR_Yelp_Business( YELP_BUSINESS_ID, 'yelp' );
	echo '<pre>'; print_r( $yelp_business ); echo '</pre>';
	?>


	<h2>YP</h2>

	<?php
//	$yp_business = new WPBR_YP_Business( YP_LISTING_ID, 'yp' );
//	echo '<pre>'; print_r( $yp_business ); echo '</pre>';
	?>

</div>
