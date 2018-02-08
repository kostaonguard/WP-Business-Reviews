import Review from './review';
import ReviewCollection from './review-collection';

if ( wpBusinessReviewsCollection ) {
	const collectionData = wpBusinessReviewsCollection;
	const reviews        = new Set();
	const settings       = collectionData.settings;

	for ( const reviewData of collectionData.reviews ) {
		reviews.add( new Review( reviewData.platform, reviewData.components ) );
	}

	const reviewCollection = new ReviewCollection( reviews, settings );

	reviewCollection.init();
	reviewCollection.render( document.querySelector( '.js-wpbr-wrap' ) );
}
