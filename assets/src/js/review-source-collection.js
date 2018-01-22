import ReviewSource from './review-source';

class ReviewSourceCollection {
	constructor( element ) {
		this.root          = element;
		this.items         = new Set();
		this.reviewSources = new Set();
	}

	init() {
		this.scrollable           = document.createElement( 'div' );
		this.list                 = document.createElement( 'ul' );
		this.scrollable.className = 'wpbr-scrollable wpbr-scrollable--border';
		this.list.className       = 'wpbr-stacked-list wpbr-stacked-list--striped';

		this.scrollable.appendChild( this.list );
		this.root.appendChild( this.scrollable );
	}

	replaceReviewSources( reviewSourcesData ) {
		this.clearReviewSources();
		this.addReviewSources( reviewSourcesData );
		this.renderItems();
	}

	addReviewSources( reviewSourcesData ) {
		for ( const data of reviewSourcesData ) {
			const reviewSource = new ReviewSource( data );
			this.reviewSources.add( reviewSource );
		}
	}

	clearReviewSources() {
		this.items.clear();
		this.reviewSources.clear();
		this.list.innerHTML = '';
	}

	renderItems() {
		const fragment = document.createDocumentFragment();

		for ( const reviewSource of this.reviewSources ) {
			const li     = document.createElement( 'li' );
			li.className = 'wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom';
			li.innerHTML = reviewSource.render();
			li.innerHTML += this.renderGetReviewsButton(
				reviewSource.platform,
				reviewSource.reviewSourceId
			);
			fragment.appendChild( li );
			this.items.add( li );
		}

		this.list.appendChild( fragment );

		const reviewSourcesReadyEvent = new CustomEvent(
			'wpbrReviewSourcesReady',
			{ bubbles: true }
		);
		this.root.dispatchEvent( reviewSourcesReadyEvent );
	}

	renderGetReviewsButton( platform, reviewSourceId ) {

		// TODO: Translate "Get Reviews" button text.
		return `
			<button
				class="wpbr-review-source__button button button-primary js-wpbr-review-fetcher-button"
				data-wpbr-platform="${platform}"
				data-wpbr-review-source-id="${reviewSourceId}"
			>
				Get Reviews
			</button>
		`;
	}
}

export default ReviewSourceCollection;
