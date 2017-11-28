<?php
wp_nonce_field(
	'wp_business_reviews_save_settings',
	'wp_business_reviews_settings_nonce'
);
submit_button();
?>
