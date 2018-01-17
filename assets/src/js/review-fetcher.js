import Emitter from 'tiny-emitter';
import axios from 'axios';
import queryString from 'query-string';

class ReviewFetcher {
	constructor( element ) {
		this.root    = element;
		this.emitter = new Emitter();
		this.controls = this.root.querySelectorAll( '.js-wpbr-review-fetcher-button' );
	}

	init() {
		this.registerControlEventHandlers();
	}

	registerControlEventHandlers() {
		this.controls.forEach( ( control ) => {
			control.addEventListener( 'click', ( event ) => {
				const platform       = event.currentTarget.getAttribute( 'data-wpbr-platform' );
				const reviewSourceId = event.currentTarget.getAttribute( 'data-wpbr-review-source-id' );

				this.fetch( platform, reviewSourceId );
			});
		});
	}

	fetch( platform, reviewSourceId ) {
		const response = axios.post(
			ajaxurl,
			queryString.stringify({
				action: 'wpbr_get_reviews',
				platform: platform,
				reviewSourceId: reviewSourceId
			})
		)
			.then( response => {
				if ( response.data && 0 < response.data.length ) {
					this.updateReviews( response.data );

					// Emit custom event that passes the request response.
					this.emitter.emit( 'wpbrAfterGetReviews', 'response.data' );
				} else {

					// TODO: No reviews exist, so display message.
				}
			})
			.catch( error => {

				// TODO: Handle error of failed request.
			});
	}

	updateReviews( reviews ) {
		console.log( 'updating reviews' );
		const reviewList    = document.querySelector( '.js-wpbr-list' );
		const reviewEls        = document.querySelectorAll( '.js-wpbr-review' );
		const reviewNameEls    = document.querySelectorAll( '.js-wpbr-review-name' );
		const reviewContentEls = document.querySelectorAll( '.js-wpbr-review-content' );
		const reviewImageEls = document.querySelectorAll( '.js-wpbr-review-image-el' );

		reviewList.classList.add( 'wpbr-review-gallery--populated' );

		reviews.forEach( ( review, index ) => {
			const el = document.createElement( 'img' );
			reviewNameEls[ index ].innerHTML = review.author_name;
			reviewContentEls[ index ].innerHTML = '<p>' + review.text + '</p>';
			reviewImageEls[ index ].src = review.profile_photo_url;
		});

		reviewEls[5].parentNode.removeChild( reviewEls[5]);
		reviewEls[6].parentNode.removeChild( reviewEls[6]);
		reviewEls[7].parentNode.removeChild( reviewEls[7]);
		reviewEls[8].parentNode.removeChild( reviewEls[8]);
		reviewEls[9].parentNode.removeChild( reviewEls[9]);
		reviewEls[10].parentNode.removeChild( reviewEls[10]);
		reviewEls[11].parentNode.removeChild( reviewEls[11]);
	}
}

export default ReviewFetcher;
