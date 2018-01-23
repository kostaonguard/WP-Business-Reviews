import SettingsTabs from './settings-tabs';
import FacebookPagesField from './facebook-pages-field';
import Builder from './builder';
import '../css/admin-main.scss';
import '../images/wpbr-logo-white-wordmark.png';
import '../images/wpbr-menu-icon-white.png';
import '../images/wpbr-icon-color.png';

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_settings' ) ) {
	const settingsTabsEl  = document.querySelector( '.js-wpbr-settings' );
	const facebookPagesEl = document.getElementById( 'wpbr-field-facebook_pages' );

	if ( settingsTabsEl ) {
		const settingsTabsField = new SettingsTabs( '.js-wpbr-settings' );
		settingsTabsField.init();
	}

	if ( facebookPagesEl ) {
		const facebookPagesField = new FacebookPagesField(
			facebookPagesEl
		);
		facebookPagesField.init();
	}
}

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_builder' ) ) {
	const builder = new Builder( '.js-wpbr-builder' );
	builder.init();
}
