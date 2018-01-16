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
					console.log( 'response received' );
					console.log( response.data );

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
}

export default ReviewFetcher;
