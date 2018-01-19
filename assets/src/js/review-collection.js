import Review from './review';

class ReviewCollection {
	constructor( element ) {
		this.root    = element;
		this.list    = this.root.querySelector( '.js-wpbr-list' );
		this.items   = this.root.querySelectorAll( '.js-wpbr-item' );
		this.reviews = new Set();
	}

	init() {
		const reviewEls = this.root.querySelectorAll( '.js-wpbr-review' );

		for ( const reviewEl of reviewEls ) {
			this.reviews.add( new Review( reviewEl ) );
		}
	}

	updateReviews( reviewsData ) {
		console.table( reviewsData );
		for ( const review of reviewsData ) {

			// TODO: Update review content.
		}
	}
}

export default ReviewCollection;
