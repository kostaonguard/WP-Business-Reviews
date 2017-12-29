import SettingsTabs from './settings-tabs';
import Builder from './builder';
import '../css/admin-main.scss';
import '../images/wpbr-logo-white-wordmark.png';
import '../images/wpbr-menu-icon-white.png';
import '../images/wpbr-icon-color.png';

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_settings' ) ) {
	const settingsTabs = new SettingsTabs( '.js-wpbr-settings' );
	settingsTabs.init();
}

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_builder' ) ) {
	const builder = new Builder( '.js-wpbr-builder' );
	builder.init();
}
