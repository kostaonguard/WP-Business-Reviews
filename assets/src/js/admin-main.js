import AdminTabs from './admin-tabs';
import ReviewsBuilder from './reviews-builder';
import '../css/admin-main.scss';
import '../images/wpbr-logo-white-wordmark.png';
import '../images/wpbr-menu-icon-white.png';

if ( document.querySelector( 'body' ).classList.contains( 'wpbr_review_page_wpbr_settings' ) ) {
	const adminTabs = new AdminTabs();
	adminTabs.init();
}

const reviewsBuilder = new ReviewsBuilder( '.js-wpbr-builder' );
