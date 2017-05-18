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

	<?php
	$google_places_business_id = '';
	$facebook_business_id      = '';
	$yelp_business_id          = '';
	$yp_business_id            = '';

	if ( ! empty( $_POST ) ) {

		$google_places_business_id = isset( $_POST[ 'google_places_business_id' ] ) ? $_POST['google_places_business_id'] : '';
		$facebook_business_id = isset( $_POST[ 'facebook_business_id' ] ) ? $_POST['facebook_business_id'] : '';
		$yelp_business_id = isset( $_POST[ 'yelp_business_id' ] ) ? $_POST['yelp_business_id'] : '';
		$yp_business_id = isset( $_POST[ 'yp_business_id' ] ) ? $_POST['yp_business_id'] : '';

	}
	?>

	<h1>WP Business Reviews Testing</h1>

	<h2>Google Places</h2>

	<a href="https://developers.google.com/places/place-id">Find a Google Places ID</a><br><br>

	<form method="post" action="/wp-admin/options-general.php?page=wpbr">
		<label for="google_places_business_id">Google Places ID:</label>
		<input type="text" id="google_places_business_id" name="google_places_business_id" value="<?php esc_attr_e( $google_places_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<?php
	if ( ! empty( $google_places_business_id ) ) {

		$google_places_business = new WPBR_Google_Places_Business( $_POST[ 'google_places_business_id' ], 'google_places' );
		echo '<pre>'; print_r( $google_places_business ); echo '</pre>';
//		$google_places_reviews = new WPBR_Google_Places_Reviews( $_POST[ 'google_places_business_id' ], 'google_places' );

	}
	?>

	<h2>Facebook</h2>

	<a href="https://developers.facebook.com/tools/explorer/">Find a Facebook Business ID</a><br>
	<p>Note: You may need to update the Facebook Page Access Token since they expire quickly.</p>

	<form method="post" action="/wp-admin/options-general.php?page=wpbr">
		<label for="facebook_business_id">Facebook Business ID:</label>
		<input type="text" id="facebook_business_id" name="facebook_business_id" value="<?php esc_attr_e( $facebook_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<?php
	if ( ! empty( $facebook_business_id ) ) {

		$facebook_business = new WPBR_Facebook_Business( $_POST[ 'facebook_business_id' ], 'facebook' );
		echo '<pre>'; print_r( $facebook_business ); echo '</pre>';

	}
	?>

	<h2>Yelp</h2>

	<p>The Yelp Business ID is the last part of the URL following /biz/.</p>

	<form method="post" action="/wp-admin/options-general.php?page=wpbr">
		<label for="yelp_business_id">Yelp Business ID:</label>
		<input type="text" id="yelp_business_id" name="yelp_business_id" value="<?php esc_attr_e( $yelp_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<?php
	if ( ! empty( $yelp_business_id ) ) {

		$yelp_business = new WPBR_Yelp_Business( $_POST[ 'yelp_business_id' ], 'yelp' );
		echo '<pre>'; print_r( $yelp_business ); echo '</pre>';

	}
	?>

	<h2>YP</h2>

	<p>The YP Listing ID is the last part of the URL following ?lid=.</p>

	<form method="post" action="/wp-admin/options-general.php?page=wpbr">
		<label for="yp_business_id">YP Listing ID:</label>
		<input type="text" id="yp_business_id" name="yp_business_id" value="<?php esc_attr_e( $yp_business_id ); ?>">
		<button type="submit">Submit</button>
	</form>

	<?php
	if ( ! empty( $yp_business_id ) ) {

		$yp_business = new WPBR_YP_Business( $_POST[ 'yp_business_id' ], 'yp' );
		echo '<pre>'; print_r( $yp_business ); echo '</pre>';

	}
	?>

</div>
