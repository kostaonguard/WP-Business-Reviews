import axios from 'axios';
import queryString from 'query-string';

class ReviewFetcher {
	constructor( element ) {
		this.root     = element;
		this.controls = this.root.querySelectorAll( '.js-wpbr-review-fetcher-button' );
	}

	init() {
		this.registerControlEventHandlers();
	}

	registerControlEventHandlers() {
		for ( const control of this.controls ) {
			control.addEventListener( 'click', ( event ) => {
				const platform       = event.currentTarget.getAttribute( 'data-wpbr-platform' );
				const reviewSourceId = event.currentTarget.getAttribute( 'data-wpbr-review-source-id' );

				this.fetch( platform, reviewSourceId );
			});
		}
	}

	fetch( platform, reviewSourceId ) {
		const getReviewsStartEvent = new CustomEvent(
			'wpbrGetReviewsStart',
			{ bubbles: true }
		);

		this.root.dispatchEvent( getReviewsStartEvent );

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
					const getReviewsEndEvent = new CustomEvent(
						'wpbrGetReviewsEnd',
						{
							bubbles: true,
							detail: { reviews: response.data }
						}
					);
					this.root.dispatchEvent( getReviewsEndEvent );
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
