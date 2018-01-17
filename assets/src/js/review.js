import truncate from 'lodash.truncate';

class Review {
	constructor( element ) {
		this.root  = element;
		this.reviewImage     = this.root.querySelector( '.js-wpbr-review-image' );
		this.reviewRating    = this.root.querySelector( '.js-wpbr-review-rating' );
		this.reviewTimestamp = this.root.querySelector( '.js-wpbr-review-timestamp' );
		this.reviewContent   = this.root.querySelector( '.js-wpbr-review-content' );
	}

	hide( element ) {
		element.classList.add( 'wpbr-u-hidden' );
	}

	show( element ) {
		element.classList.remove( 'wpbr-u-hidden' );
	}
}

export default Review;
