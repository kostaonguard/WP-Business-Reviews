import Field from './field';
import GooglePlacesTextSearch from './google-places-text-search';
import '../images/platform-google-places-160w.png';
import '../images/platform-facebook-160w.png';
import '../images/platform-yelp-160w.png';
import '../images/platform-yp-160w.png';

class Builder {
	constructor( selector ) {

		// Define the root element of the Reviews Builder.
		this.root      = document.querySelector( selector );
		this.inspector = document.getElementById( 'wpbr-builder-inspector' );

		// Define field wrappers.
		// this.formatField     = document.getElementById( 'wpbr-field-format' );
		// this.formatField     = new Field( 'format' );
		// console.log( this.formatField.value );
		this.maxColumnsField = document.getElementById( 'wpbr-field-max_columns' );
		this.themeField      = document.getElementById( 'wpbr-field-theme' );

		// Define controls.
		this.inspectorControl       = document.getElementById( 'wpbr-control-inspector' );
		this.saveControl            = document.getElementById( 'wpbr-control-save' );
		this.formatControl          = document.getElementById( 'wpbr-control-format' );
		this.maxColumnsControl      = document.getElementById( 'wpbr-control-max_columns' );
		this.themeControl           = document.getElementById( 'wpbr-control-theme' );
		this.reviewImageControl     = document.getElementById( 'wpbr-control-review_image' );
		this.reviewRatingControl    = document.getElementById( 'wpbr-control-rating' );
		this.reviewTimestampControl = document.getElementById( 'wpbr-control-timestamp' );

		// Define review elements.
		this.wrap             = this.root.querySelector( '.js-wpbr-wrap' );
		this.list             = this.root.querySelector( '.js-wpbr-list' );
		this.items            = this.root.querySelectorAll( '.js-wpbr-item' );
		this.reviews          = this.root.querySelectorAll( '.js-wpbr-review' );
		this.reviewImages     = this.root.querySelectorAll( '.js-wpbr-review-image' );
		this.reviewRatings    = this.root.querySelectorAll( '.js-wpbr-review-rating' );
		this.reviewTimestamps = this.root.querySelectorAll( '.js-wpbr-review-timestamp' );


		// Define background element, which changes color in theme previews.
		this.backgroundElement = document.querySelector( '.wpbr-admin' );
	}

	init() {
		this.inspectorControl.addEventListener( 'click', event => {
			event.preventDefault();
			this.toggleVisibility( this.inspector );
		});

		this.saveControl.addEventListener( 'click', event => {
			event.preventDefault();
		});

		this.formatControl.addEventListener( 'change', event => {
			event.preventDefault();
			this.format( event.currentTarget.value );
		});

		this.maxColumnsControl.addEventListener( 'change', event => {
			event.preventDefault();
			this.formatGallery( event.currentTarget.value );
		});

		this.themeControl.addEventListener( 'change', event => {
			event.preventDefault();
			this.applyTheme( event.currentTarget.value );
		});

		this.reviewImageControl.addEventListener( 'change', event => {
			event.preventDefault();

			if ( event.currentTarget.checked ) {
				this.showMultiple( Array.from( this.reviewImages ) );
			} else {
				this.hideMultiple( Array.from( this.reviewImages ) );
			}
		});

		this.reviewRatingControl.addEventListener( 'change', event => {
			event.preventDefault();

			if ( event.currentTarget.checked ) {
				this.showMultiple( Array.from( this.reviewRatings ) );
			} else {
				this.hideMultiple( Array.from( this.reviewRatings ) );
			}
		});

		this.reviewTimestampControl.addEventListener( 'change', event => {
			event.preventDefault();

			if ( event.currentTarget.checked ) {
				this.showMultiple( Array.from( this.reviewTimestamps ) );
			} else {
				this.hideMultiple( Array.from( this.reviewTimestamps ) );
			}
		});
	}

	toggleVisibility( element, condition ) {
		element.classList.toggle( 'wpbr-u-hidden' );
	}

	format( type = 'review-gallery' ) {
		switch ( type ) {

		case 'review-gallery':
			this.formatGallery();
			break;

		case 'review-list':
			this.formatList();
			break;

		case 'review-carousel':
			this.formatCarousel();
			break;

		case 'business-badge':
			this.formatBadge();
			break;
		}
	}

	formatGallery( columns = 3 ) {
		this.list.classList = 'wpbr-review-gallery';
		this.items.forEach( item => {
			item.className = `wpbr-review-gallery__item wpbr-review-gallery__item--${columns} js-wpbr-item`;
		});
	}

	formatList() {
		this.list.classList = 'wpbr-stacked-list';
		this.items.forEach( item => {
			item.className = 'wpbr-stacked-list__item js-wpbr-item';
		});
	}

	formatCarousel() {

	}

	formatBadge() {

	}

	applyTheme( theme = 'card' ) {
		this.wrap.className = 'wpbr-wrap wpbr-theme--${theme} js-wpbr-wrap';

		if ( 'seamless-dark' === theme ) {
			this.backgroundElement.classList.add( 'wpbr-theme--dark' );
		} else {
			this.backgroundElement.classList.remove( 'wpbr-theme--dark' );
		}
	}

	hideMultiple( elements ) {
		elements.map( element => this.hide( element ) );
	}

	showMultiple( elements ) {
		elements.map( element => this.show( element ) );
	}

	hide( element ) {
		element.classList.add( 'wpbr-u-hidden' );
	}

	show( element ) {
		element.classList.remove( 'wpbr-u-hidden' );
	}
}

export default Builder;
