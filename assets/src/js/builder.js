import BasicField from './basic-field';
import ButtonField from './button-field';
import CheckboxesField from './checkboxes-field';
import PlatformSearch from './platform-search';
import '../images/platform-google-places-160w.png';
import '../images/platform-facebook-160w.png';
import '../images/platform-yelp-160w.png';
import '../images/platform-yp-160w.png';

class Builder {
	constructor( selector ) {

		// Define the root element of the Reviews Builder.
		this.root      = document.querySelector( selector );
		this.inspector = document.getElementById( 'wpbr-builder-inspector' );

		// Define fields.
		this.fields = new Map();

		// Define toolbar controls.
		this.inspectorControl       = document.getElementById( 'wpbr-control-inspector' );
		this.saveControl            = document.getElementById( 'wpbr-control-save' );

		// Define review elements.
		this.wrap             = this.root.querySelector( '.js-wpbr-wrap' );
		this.list             = this.root.querySelector( '.js-wpbr-list' );
		this.items            = this.root.querySelectorAll( '.js-wpbr-item' );
		this.reviews          = this.root.querySelectorAll( '.js-wpbr-review' );
		this.reviewImages     = this.root.querySelectorAll( '.js-wpbr-review-image' );
		this.reviewRatings    = this.root.querySelectorAll( '.js-wpbr-review-rating' );
		this.reviewTimestamps = this.root.querySelectorAll( '.js-wpbr-review-timestamp' );
		this.reviewContents   = this.root.querySelectorAll( '.js-wpbr-review-content' );

		// Define background element, which changes color in theme previews.
		this.backgroundElement = document.querySelector( '.wpbr-admin' );
	}

	init() {
		this.initFieldObjects();

		if ( this.fields.has( 'platform_search' ) ) {
			this.initPlatformSearch();
		}

		this.registerToolbarEventHandlers();
		this.registerFieldEventHandlers();
	}

	// TODO: Move this to FieldFactory class.
	initFieldObjects() {
		const fieldElements = this.root.querySelectorAll( '.js-wpbr-field' );

		fieldElements.forEach( ( fieldElement ) => {
			const fieldId   = fieldElement.dataset.wpbrFieldId;
			const fieldType = fieldElement.dataset.wpbrFieldType;
			let field;

			switch ( fieldType ) {
			case 'button' :
				field = new ButtonField( fieldElement );
				break;
			case 'checkboxes' :
				field = new CheckboxesField( fieldElement );
				break;
			default :
				field = new BasicField( fieldElement );
			}

			field.init();
			this.fields.set( fieldId, field );
		});
	}

	initPlatformSearch() {
		this.platformSearch = new PlatformSearch(
			this.fields.get( 'platform_search_platform' ),
			this.fields.get( 'platform_search_terms' ),
			this.fields.get( 'platform_search_location' ),
			this.fields.get( 'platform_search_button' )
		);
		this.platformSearch.init();
	}

	registerToolbarEventHandlers() {
		this.inspectorControl.addEventListener( 'click', event => {
			event.preventDefault();
			this.toggleVisibility( this.inspector );
		});

		this.saveControl.addEventListener( 'click', event => {
			event.preventDefault();
		});
	}

	registerFieldEventHandlers() {
		this.fields.forEach( ( field ) => {
			field.emitter.on( 'wpbrcontrolchange', ( controlId, controlValue ) => {
				this.updatePresentation( controlId, controlValue );
			});
		});
	}

	updatePresentation( type, value ) {
		switch ( type ) {
		case 'format' :
			this.format( value );

			if ( 'review_gallery' === value ) {
				this.fields.get( 'max_columns' ).show();
			} else {
				this.fields.get( 'max_columns' ).hide();
			}
			break;
		case 'max_columns':
			this.formatGallery( value );
			break;
		case 'theme':
			this.applyTheme( value );
			break;
		case 'review_image':
			this.setMultipleVisibility( Array.from( this.reviewImages ), value );
			break;
		case 'review_rating':
			this.setMultipleVisibility( Array.from( this.reviewRatings ), value );
			break;
		case 'review_timestamp':
			this.setMultipleVisibility( Array.from( this.reviewTimestamps ), value );
			break;
		case 'review_content':
			this.setMultipleVisibility( Array.from( this.reviewContents ), value );
			break;
		}
	}

	format( type ) {
		switch ( type ) {

		case 'review_gallery':
			this.formatGallery( this.fields.get( 'max_columns' ).value );
			break;

		case 'review_list':
			this.formatList();
			break;

		case 'review_carousel':
			this.formatCarousel();
			break;

		case 'business_badge':
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
		this.wrap.className = `wpbr-wrap wpbr-theme--${theme} js-wpbr-wrap`;

		if ( 'seamless-dark' === theme ) {
			this.backgroundElement.classList.add( 'wpbr-theme--dark' );
		} else {
			this.backgroundElement.classList.remove( 'wpbr-theme--dark' );
		}
	}

	setMultipleVisibility( elements, visibility ) {
		if ( visibility ) {
			elements.map( element => this.show( element ) );
		} else {
			elements.map( element => this.hide( element ) );
		}
	}

	toggleVisibility( element ) {
		element.classList.toggle( 'wpbr-u-hidden' );
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
