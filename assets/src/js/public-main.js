import Review from './review';
import ReviewCollection from './review-collection';

const collectionWraps = document.querySelectorAll( '.js-wpbr-collection-wrap' );

for ( const wrap of collectionWraps ) {
	const collectionId   = wrap.dataset.wpbrCollectionId;
	const collectionData = window[`wpbrReviewCollection${collectionId}`];

	if ( 'object' === typeof collectionData ) {
		const reviews  = new Set();
		const settings = collectionData.settings;

		for ( const reviewData of collectionData.reviews ) {
			reviews.add(
				new Review(
					reviewData.platform,
					reviewData.review_source_id,
					reviewData.components
				)
			);
		}

		const reviewCollection = new ReviewCollection( reviews, settings );

		reviewCollection.init();
		reviewCollection.render( wrap );
	}
}
