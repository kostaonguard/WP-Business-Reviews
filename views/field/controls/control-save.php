<?php
wp_nonce_field( 'wpbr_settings_save', 'wpbr_settings_nonce' );
submit_button(
	__( 'Save Changes', 'wpbr' ),
	'primary',
	$this->id,
	false
);
?>
