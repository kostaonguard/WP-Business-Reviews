import Inspector from './inspector';
import ReviewCollection from './review-collection';
import ReviewFetcher from './review-fetcher';
import toggleVisibility from './visibility-toggle';
import '../images/platform-google-places-160w.png';
import '../images/platform-facebook-160w.png';
import '../images/platform-yelp-160w.png';
import '../images/platform-yp-160w.png';

class Builder {
	constructor( selector ) {
		this.root = document.querySelector( selector );
	}

	init() {
		this.initToolbar();
		this.initInspector();
		this.initReviewCollection();
		this.initBackground();
	}

	initToolbar() {
		this.inspectorControl = document.getElementById( 'wpbr-control-inspector' );
		this.saveControl      = document.getElementById( 'wpbr-control-save' );
		this.registerToolbarEventHandlers();
	}

	initInspector() {
		this.inspector = new Inspector ( document.getElementById( 'wpbr-builder-inspector' ) );
		this.inspector.init();
		this.registerInspectorEventHandlers();
	}

	initReviewCollection() {
		this.reviewCollection = new ReviewCollection( document.querySelector( '.js-wpbr-wrap' ) );
		this.reviewCollection.init();
		this.registerReviewCollectionEventHandlers();
	}

	initReviewFetcher() {
		this.reviewFetcher = new ReviewFetcher( this.root );
		this.reviewFetcher.init();
	}

	initBackground() {
		this.background = document.querySelector( '.wpbr-admin' );
	}

	registerToolbarEventHandlers() {
		this.inspectorControl.addEventListener(
			'click',
			event => toggleVisibility( this.inspector.root )
		);

		this.saveControl.addEventListener( 'click', event => {
			event.preventDefault();
		});
	}

	registerInspectorEventHandlers() {
		this.root.addEventListener(
			'wpbrControlChange',
			event => this.reflectControlChange(
				event.detail.controlId,
				event.detail.controlValue
			)
		);

		this.root.addEventListener(
			'wpbrReviewSourcesReady',
			event => this.initReviewFetcher()
		);
	}

	registerReviewCollectionEventHandlers() {
		this.root.addEventListener(
			'wpbrGetReviewsEnd',
			event => this.reviewCollection.replaceReviews(
				event.detail.reviews
			)
		);
	}

	reflectControlChange( controlId, controlValue ) {
		switch ( controlId ) {
		case 'format' :
			this.format( controlValue );

			if ( 'review_gallery' === controlValue ) {
				this.inspector.fields.get( 'max_columns' ).show();
			} else {
				this.inspector.fields.get( 'max_columns' ).hide();
			}
			break;
		case 'max_columns':
			this.formatGallery( controlValue );
			break;
		case 'theme':
			this.applyTheme( controlValue );
			break;
		case 'review_image':
			for ( const review of this.reviewCollection.reviews ) {
				toggleVisibility( review.image );
			}
			break;
		case 'review_rating':
			for ( const review of this.reviewCollection.reviews ) {
				toggleVisibility( review.rating );
			}
			break;
		case 'review_timestamp':
			for ( const review of this.reviewCollection.reviews ) {
				toggleVisibility( review.timestamp );
			}
			break;
		case 'review_content':
			for ( const review of this.reviewCollection.reviews ) {
				toggleVisibility( review.content );
			}
			break;
		}
	}

	format( type ) {
		switch ( type ) {

		case 'review_gallery':
			this.formatGallery( this.inspector.fields.get( 'max_columns' ).value );
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
		this.reviewCollection.list.classList = 'wpbr-review-gallery';

		for ( const item of this.reviewCollection.items ) {
			item.className = `wpbr-review-gallery__item wpbr-review-gallery__item--${columns} js-wpbr-item`;
		}
	}

	formatList() {
		this.reviewCollection.list.classList = 'wpbr-stacked-list';
		this.reviewCollection.items.forEach( item => {
			item.className = 'wpbr-stacked-list__item js-wpbr-item';
		});
	}

	formatCarousel() {

	}

	formatBadge() {

	}

	applyTheme( theme = 'card' ) {
		this.reviewCollection.root.className = `wpbr-wrap wpbr-theme--${theme} js-wpbr-wrap`;

		if ( 'seamless-dark' === theme ) {
			this.backgroundElement.classList.add( 'wpbr-theme--dark' );
		} else {
			this.backgroundElement.classList.remove( 'wpbr-theme--dark' );
		}
	}
}

export default Builder;
