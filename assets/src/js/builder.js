import Inspector from './inspector';
import Review from './review';
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
		this.initReviewCollection();
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

	initReviewCollection() {
		this.wrap             = document.querySelector( '.js-wpbr-wrap' );
		this.reviewCollection = new ReviewCollection();

		this.reviewCollection.settings = {
			theme: this.inspector.fields.get( 'theme' ).value,
			format: this.inspector.fields.get( 'format' ).value,
			max_columns: this.inspector.fields.get( 'max_columns' ).value,
			max_characters: this.inspector.fields.get( 'max_characters' ).value,
			line_breaks: this.inspector.fields.get( 'line_breaks' ).value,
			review_components: this.inspector.fields.get( 'review_components' ).value
		};

		this.reviewCollection.init();
		this.reviewCollection.render( this.wrap );
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

		case 'theme':
			this.reviewCollection.settings.theme = controlValue;
			this.reviewCollection.updatePresentation();
			this.updateTheme( controlValue );
			break;

		case 'format' :
			this.reviewCollection.settings.format = controlValue;
			this.reviewCollection.updatePresentation();

			if ( 'review_gallery' === controlValue ) {
				this.inspector.fields.get( 'max_columns' ).show();
			} else {
				this.inspector.fields.get( 'max_columns' ).hide();
			}

			break;

		case 'max_columns':
			this.reviewCollection.settings.max_columns = controlValue;
			this.reviewCollection.updatePresentation();
			break;

		case 'max_characters':
			this.reviewCollection.settings.max_characters = controlValue;
			this.reviewCollection.updateReviews();
			break;

		case 'line_breaks':
			this.reviewCollection.settings.line_breaks = controlValue;
			this.reviewCollection.updateReviews();
			break;

		case 'review_image':
			this.root.classList.toggle( 'wpbr-u-builder-no-image' );
			break;

		case 'review_rating':
			this.root.classList.toggle( 'wpbr-u-builder-no-rating' );
			break;

		case 'review_timestamp':
			this.root.classList.toggle( 'wpbr-u-builder-no-timestamp' );
			break;

		case 'review_content':
			this.root.classList.toggle( 'wpbr-u-builder-no-content' );
			break;

		}
	}

	updateTheme( theme ) {
		if ( 'dark' === theme ) {
			this.background.classList.add( 'wpbr-theme--dark' );
		} else {
			this.background.classList.remove( 'wpbr-theme--dark' );
		}
	}

	populateReviewSource( reviewSourceData ) {
		this.reviewSourceControl.value = JSON.stringify( reviewSourceData );
	}

	populateReviews( reviewsData ) {
		const reviews = new Set();

		for ( const reviewData of reviewsData ) {
			reviews.add(
				new Review(
					reviewData.platform,
					reviewData.review_source_id,
					reviewData.components
				)
			);
		}

		this.reviewCollection.reset();
		this.reviewCollection.setReviews( reviews );
		this.reviewCollection.render( this.wrap );
		this.reviewsControl.value = JSON.stringify( reviewsData );
	}
}

export default Builder;
