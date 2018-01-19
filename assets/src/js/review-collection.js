import Review from './review';

class ReviewCollection {
	constructor( element ) {
		this.root = element;
	}

	init() {
		this.list    = this.root.querySelector( '.js-wpbr-list' );
		this.reviews = new Set();
	}

	replaceReviews( reviewsData ) {
		this.clearReviews();
		this.addReviews( reviewsData );
		this.renderReviews();
	}

	addReviews( reviewsData ) {
		for ( const reviewData of reviewsData ) {
			const reviewObj = new Review( reviewData );
			this.reviews.add( reviewObj );
		}
	}

	clearReviews() {
		this.reviews.clear();
		this.list.innerHTML = '';
	}

	renderReviews() {
		const fragment = document.createDocumentFragment();

		for ( const review of this.reviews ) {
			const li     = document.createElement( 'li' );
			li.className = 'wpbr-review-gallery__item wpbr-review-gallery__item--2';
			li.innerHTML = review.render();
			fragment.appendChild( li );
		}

		this.list.appendChild( fragment );
	}
}

export default ReviewCollection;
