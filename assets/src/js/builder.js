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
		this.registerInspectorEventHandlers();
		this.inspector = new Inspector ( document.getElementById( 'wpbr-builder-inspector' ) );
		this.inspector.init();
	}

	initReviewCollection() {
		this.reviewCollection = new ReviewCollection(
			document.querySelector( '.js-wpbr-wrap' ),
			this.inspector.fields.get( 'format' ).value,
			this.inspector.fields.get( 'max_columns' ).value,
			this.inspector.fields.get( 'theme' ).value,
		);
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
			this.reviewCollection.format = controlValue;
			this.reviewCollection.updatePresentation();

			if ( 'review_gallery' === controlValue ) {
				// this.inspector.fields.get( 'max_columns' ).show();
			} else {
				// this.inspector.fields.get( 'max_columns' ).hide();
			}

			break;

		case 'max_columns':
			this.reviewCollection.maxColumns = controlValue;
			this.reviewCollection.updatePresentation();
			break;

		case 'theme':
			this.reviewCollection.theme = controlValue;
			this.reviewCollection.updatePresentation();
			this.updateTheme( controlValue );
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

	updateTheme( theme ) {
		if ( 'seamless-dark' === theme ) {
			this.background.classList.add( 'wpbr-theme--dark' );
		} else {
			this.background.classList.remove( 'wpbr-theme--dark' );
		}
	}
}

export default Builder;
