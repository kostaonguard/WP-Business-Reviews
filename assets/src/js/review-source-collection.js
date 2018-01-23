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
			reviewSource.isFetchable = true;
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
		const reviewSourcesReadyEvent = new CustomEvent(
			'wpbrReviewSourcesReady',
			{ bubbles: true }
		);

		for ( const reviewSource of this.reviewSources ) {
			const li     = document.createElement( 'li' );
			li.className = 'wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom';
			li.innerHTML = reviewSource.render();
			fragment.appendChild( li );
			this.items.add( li );
		}

		this.list.appendChild( fragment );
		this.root.dispatchEvent( reviewSourcesReadyEvent );
	}

	destroy() {
		this.root.removeChild( this.scrollable );

		return null;
	}
}

export default ReviewSourceCollection;
