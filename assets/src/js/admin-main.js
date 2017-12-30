import SettingsTabs from './settings-tabs';
import FacebookPagesField from './facebook-pages-field';
import Builder from './builder';
import '../css/admin-main.scss';
import '../images/wpbr-logo-white-wordmark.png';
import '../images/wpbr-menu-icon-white.png';
import '../images/wpbr-icon-color.png';

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_settings' ) ) {
	const settingsTabs       = new SettingsTabs( '.js-wpbr-settings' );
	const facebookPagesField = new FacebookPagesField( 'facebook_pages' );

	settingsTabs.init();
	facebookPagesField.init();
}

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_builder' ) ) {
	const builder = new Builder( '.js-wpbr-builder' );
	builder.init();
}
