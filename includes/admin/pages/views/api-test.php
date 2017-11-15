<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @package WP_Business_Reviews\Templates
 * @since   0.1.0
 */

use WP_Business_Reviews\Includes\Business;
use WP_Business_Reviews\Includes\Review;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wpbr-admin-page">

	<?php

	if ( ! empty( $_POST ) ) {

		$google_places_business_id = isset( $_POST[ 'google_places_business_id' ] ) ? $_POST['google_places_business_id'] : '';
		$facebook_business_id = isset( $_POST[ 'facebook_business_id' ] ) ? $_POST['facebook_business_id'] : '';
		$yelp_business_id = isset( $_POST[ 'yelp_business_id' ] ) ? $_POST['yelp_business_id'] : '';
		$yp_business_id = isset( $_POST[ 'yp_business_id' ] ) ? $_POST['yp_business_id'] : '';
		$wp_org_business_id = isset( $_POST[ 'wp_org_business_id' ] ) ? $_POST['wp_org_business_id'] : '';

	} else {

		$google_places_business_id = GOOGLE_PLACES_ID;
		$facebook_business_id      = FACEBOOK_PAGE_ID;
		$yelp_business_id          = YELP_BUSINESS_ID;
		$yp_business_id            = YP_LISTING_ID;
		$wp_org_business_id        = 'give';

	}
	?>

	<h1>WP Business Reviews Testing</h1>

	<h2>Google Places</h2>

	<a href="https://developers.google.com/places/place-id">Find a Google Places ID</a><br><br>

	<form method="post">
		<label for="google_places_business_id">Google Places ID:</label>
		<input type="text" id="google_places_business_id" name="google_places_business_id" value="<?php esc_attr_e( $google_places_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<h2>Facebook</h2>

	<a href="https://developers.facebook.com/tools/explorer/">Find a Facebook Business ID</a><br>
	<p>Note: You may need to update the Facebook Page Access Token since they expire quickly.</p>

	<form method="post">
		<label for="facebook_business_id">Facebook Business ID:</label>
		<input type="text" id="facebook_business_id" name="facebook_business_id" value="<?php esc_attr_e( $facebook_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<h2>Yelp</h2>

	<p>The Yelp Business ID is the last part of the URL following /biz/.</p>

	<form method="post">
		<label for="yelp_business_id">Yelp Business ID:</label>
		<input type="text" id="yelp_business_id" name="yelp_business_id" value="<?php esc_attr_e( $yelp_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<h2>YP</h2>

	<p>The YP Listing ID is the last part of the URL following ?lid=.</p>

	<form method="post">
		<label for="yp_business_id">YP Listing ID:</label>
		<input type="text" id="yp_business_id" name="yp_business_id" value="<?php esc_attr_e( $yp_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<h2>WordPress.org</h2>

	<p>The WordPress.org ID is the plugin slug.</p>

	<form method="post">
		<label for="wp_org_business_id">WordPress.org Plugin Slug:</label>
		<input type="text" id="wp_org_business_id" name="wp_org_business_id" value="<?php esc_attr_e( $wp_org_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<h2>Results</h2>

	<?php
	$platforms = array(
		'google_places',
		'facebook',
		'yelp',
		'yp',
		'wp_org',
	);

	foreach ( $platforms as $platform ) {
		if ( ! empty( $_POST[ "{$platform}_business_id" ] ) ) {
			$business = new Business\Business( ${$platform . "_business_id"}, $platform );
			$business->insert_post();
			echo '<pre>'; print_r( $business ); echo '</pre>';
			if ( 'wp_org' !== $platform ) {
				$reviews = new Review\Review_Series( ${$platform . "_business_id"}, $platform );
				$reviews->insert_posts();
				echo '<pre>'; print_r( $reviews ); echo '</pre>';
			}
		}
	}
	?>

</div>
