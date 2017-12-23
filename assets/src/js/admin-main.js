import Settings from './settings';
import Builder from './builder';
import '../css/admin-main.scss';
import '../images/wpbr-logo-white-wordmark.png';
import '../images/wpbr-menu-icon-white.png';
import '../images/wpbr-icon-color.png';

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_settings' ) ) {
	const settings = new Settings( '.js-wpbr-settings' );
	settings.init();
}

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_builder' ) ) {
	const reviewsBuilder = new Builder( '.js-wpbr-builder' );
	reviewsBuilder.init();
}
