import Field from './field';
import GooglePlacesTextSearch from './google-places-text-search';

class ReviewsBuilder {
	constructor( selector ) {

		// Define the root element of the Reviews Builder.
		this.builder = document.querySelector( selector );

		// Define field wrappers.
		this.formatField     = document.getElementById( 'wpbr-field-format' );
		this.maxColumnsField = document.getElementById( 'wpbr-field-max_columns' );
		this.themeField      = document.getElementById( 'wpbr-field-theme' );

		// Define controls.
		this.controlPanel      = document.getElementById( 'wpbr-control-panel' );
		this.settingsControl   = document.getElementById( 'wpbr-control-settings' );
		this.saveControl       = document.getElementById( 'wpbr-control-save' );
		this.formatControl     = document.getElementById( 'wpbr-control-format' );
		this.maxColumnsControl = document.getElementById( 'wpbr-control-max_columns' );
		this.themeControl      = document.getElementById( 'wpbr-control-theme' );

		// Define handles used to identify review elements.
		this.wrapHandle    = 'js-wpbr-wrap';
		this.listHandle    = 'js-wpbr-list';
		this.itemHandle    = 'js-wpbr-item';
		this.reviewHandle  = 'js-wpbr-review';

		// Define review elements.
		this.wrap    = this.builder.querySelector( `.${this.wrapHandle}` );
		this.list    = this.builder.querySelector( `.${this.listHandle}` );
		this.items   = this.builder.querySelectorAll( `.${this.itemHandle}` );
		this.reviews = this.builder.querySelectorAll( `.${this.reviewHandle}` );

		// Define background element, which changes color in theme previews.
		this.backgroundElement = document.querySelector( '.wpbr-admin' );

		// const googlePlacesTextSearch = new GooglePlacesTextSearch( `${selector} .js-wpbr-section-business` );
		// googlePlacesTextSearch.init();
	}

	init() {
		this.settingsControl.addEventListener( 'click', event => {
			event.preventDefault();
			this.toggleSettings();
		});

		this.saveControl.addEventListener( 'click', event => {
			event.preventDefault();
			this.builder.querySelector( '.js-wpbr-builder-notice' ).classList.toggle( 'wpbr-u-hidden' );
		});

		this.formatControl.addEventListener( 'change', event => {
			event.preventDefault();
			this.format( event.currentTarget.value );
		});

		this.maxColumnsControl.addEventListener( 'input', event => {
			event.preventDefault();
			this.formatGallery( event.currentTarget.value );
		});

		this.themeControl.addEventListener( 'change', event => {
			event.preventDefault();
			this.applyTheme( event.currentTarget.value );
		});
	}

	toggleSettings() {
		this.controlPanel.classList.toggle( 'wpbr-u-hidden' );
	}

	format( type = 'reviews-gallery' ) {
		switch ( type ) {

		case 'reviews-gallery':
			this.formatGallery();
			break;

		case 'reviews-list':
			this.formatList();
			break;

		case 'reviews-carousel':
			this.formatCarousel();
			break;

		case 'business-badge':
			this.formatBadge();
			break;
		}
	}

	formatGallery( columns = 3 ) {
		this.list.classList = 'wpbr-gallery';
		this.items.forEach( item => {
			item.className = `wpbr-gallery__item wpbr-gallery__item--${columns} ${this.itemHandle}`;
		});
	}

	formatList() {
		this.list.classList = 'wpbr-stacked-list';
		this.items.forEach( item => {
			item.className = `wpbr-stacked-list__item ${this.itemHandle}`;
		});
	}

	formatCarousel() {

	}

	formatBadge() {

	}

	applyTheme( theme = 'card' ) {
		this.wrap.className = `wpbr-wrap wpbr-theme--${theme} js-wpbr-wrap`;

		if ( 'seamless-dark' === theme ) {
			this.backgroundElement.classList.add( 'wpbr-theme--dark' );
		} else {
			this.backgroundElement.classList.remove( 'wpbr-theme--dark' );
		}
	}
}

export default ReviewsBuilder;
