import Review from './review';

class Reviews {
	constructor( element ) {
		this.root    = element;
		this.list    = this.root.querySelector( '.js-wpbr-list' );
		this.items   = this.root.querySelectorAll( '.js-wpbr-item' );
		this.reviews = new Set();
	}

	initReviews() {
		const reviewEls = this.root.querySelectorAll( '.js-wpbr-review' );

		for ( const reviewEl of reviewEls ) {
			this.reviews.add( new Review( reviewEl ) );
		}
	}
}

export default Reviews;
