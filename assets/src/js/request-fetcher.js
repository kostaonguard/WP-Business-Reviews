import axios from 'axios';
import queryString from 'query-string';

class RequestFetcher {
	constructor( element ) {
		this.root = element;
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
				action: 'wpbr_get_source_and_reviews',
				platform: platform,
				reviewSourceId: reviewSourceId
			})
		)
			.then( response => {
				if ( response.data && 0 < response.data.reviews.length ) {

					const getReviewsEndEvent = new CustomEvent(
						'wpbrGetReviewsEnd',
						{
							bubbles: true,
							detail: {
								reviewSource: response.data.review_source,
								reviews: response.data.reviews
							}
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

export default RequestFetcher;
