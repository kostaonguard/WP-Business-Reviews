import Inspector from './inspector';
import ReviewCollection from './review-collection';
import RequestFetcher from './request-fetcher';
import '../images/platform-google-places-160w.png';
import '../images/platform-facebook-160w.png';
import '../images/platform-yelp-160w.png';
import '../images/platform-yp-160w.png';

class Builder {
	constructor( element ) {
		this.root = element;
	}

	init() {
		this.actionControl       = this.root.querySelector( '.js-wpbr-action' );
		this.reviewSourceControl = this.root.querySelector( '.js-wpbr-review-source-control' );
		this.reviewsControl      = this.root.querySelector( '.js-wpbr-reviews-control' );
		this.background          = document.querySelector( '.wpbr-admin' );

		this.initToolbar();
		this.initInspector();
		this.initReviews();
	}

	initToolbar() {
		this.inspectorControl = document.getElementById( 'wpbr-control-inspector' );
		this.registerToolbarEventHandlers();
	}

	initInspector() {
		this.registerInspectorEventHandlers();
		this.inspector = new Inspector ( document.getElementById( 'wpbr-builder-inspector' ) );
		this.inspector.init();
	}

	initReviews() {
		this.reviewCollection = new ReviewCollection(
			document.querySelector( '.js-wpbr-wrap' ),
			this.inspector.fields.get( 'format' ).value,
			this.inspector.fields.get( 'max_columns' ).value,
			this.inspector.fields.get( 'theme' ).value,
		);
		this.reviewCollection.init();
		this.registerReviewEventHandlers();
	}

	initRequestFetcher() {
		this.requestFetcher = new RequestFetcher( this.root );
		this.registerFetchEventHandlers();
	}

	registerToolbarEventHandlers() {
		this.inspectorControl.addEventListener(
			'click',
			event => this.inspector.toggleVisibility()
		);
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
			event => this.initRequestFetcher()
		);
	}

	registerReviewEventHandlers() {
		this.root.addEventListener(
			'wpbrGetReviewsEnd',
			event => {
				this.populateReviewSource( event.detail.reviewSource );
				this.populateReviews( event.detail.reviews );
			}
		);
	}

	registerFetchEventHandlers() {
		this.fetchControls = this.root.querySelectorAll( '.js-wpbr-fetch-control' );

		for ( const control of this.fetchControls ) {
			control.addEventListener( 'click', ( event ) => {
				const platform       = event.currentTarget.getAttribute( 'data-wpbr-platform' );
				const reviewSourceId = event.currentTarget.getAttribute( 'data-wpbr-review-source-id' );

				this.requestFetcher.fetch( platform, reviewSourceId );
			});
		}
	}

	reflectControlChange( controlId, controlValue ) {
		switch ( controlId ) {

		case 'format' :
			this.reviewCollection.format = controlValue;
			this.reviewCollection.updatePresentation();

			if ( 'review_gallery' === controlValue ) {
				this.inspector.fields.get( 'max_columns' ).show();
			} else {
				this.inspector.fields.get( 'max_columns' ).hide();
			}

			break;

		case 'max_columns':
			this.reviewCollection.maxColumns = controlValue;
			this.reviewCollection.updatePresentation();
			break;

		case 'max_characters':
			for ( const review of this.reviewCollection.reviews ) {
				review.maxCharacters = controlValue;
			}
			this.reviewCollection.updateReviews();
			break;

		case 'line_breaks':
			console.log('line breaks changed');

			for ( const review of this.reviewCollection.reviews ) {
				review.lineBreaks = controlValue;
			}
			this.reviewCollection.updateReviews();
			break;

		case 'theme':
			this.reviewCollection.theme = controlValue;
			this.reviewCollection.updatePresentation();
			this.updateTheme( controlValue );
			break;

		case 'review_image':
			this.reviewCollection.root.classList.toggle( 'wpbr-u-builder-no-image' );
			break;

		case 'review_rating':
			this.reviewCollection.root.classList.toggle( 'wpbr-u-builder-no-rating' );
			break;

		case 'review_timestamp':
			this.reviewCollection.root.classList.toggle( 'wpbr-u-builder-no-timestamp' );
			break;

		case 'review_content':
			this.reviewCollection.root.classList.toggle( 'wpbr-u-builder-no-content' );
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

	populateReviewSource( reviewSourceArray ) {
		this.reviewSourceControl.value = JSON.stringify(reviewSourceArray);
	}

	populateReviews( reviewsArray ) {
		this.reviewsControl.value = JSON.stringify(reviewsArray);
		this.reviewCollection.replaceReviews( reviewsArray );
	}
}

export default Builder;
