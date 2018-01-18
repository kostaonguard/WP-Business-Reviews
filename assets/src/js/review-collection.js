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
		const event = new CustomEvent( 'wpbrReviews', {
			bubbles: true,
			detail: {
				hazcheeseburger: true
			}
		});

		for ( const reviewEl of reviewEls ) {
			this.reviews.add( new Review( reviewEl ) );
		}

		console.log( event );
		this.root.dispatchEvent( event );
	}
}

export default ReviewCollection;
