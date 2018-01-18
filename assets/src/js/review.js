import truncate from 'lodash.truncate';

class Review {
	constructor( element ) {
		this.root  = element;
		this.image     = this.root.querySelector( '.js-wpbr-review-image' );
		this.rating    = this.root.querySelector( '.js-wpbr-review-rating' );
		this.timestamp = this.root.querySelector( '.js-wpbr-review-timestamp' );
		this.content   = this.root.querySelector( '.js-wpbr-review-content' );
	}
}

export default Review;
