import * as stars from './stars';
import truncate from 'lodash.truncate';

class Review {
	constructor( reviewData ) {
		this.platform      = reviewData.platform;
		this.reviewer      = reviewData.reviewer;
		this.reviewerImage = reviewData.reviewer_image;
		this.rating        = reviewData.rating;
		this.timestamp     = reviewData.timestamp;
		this.content       = reviewData.content;
	}

	render( reviewData ) {
		return `
			<div class="wpbr-review">
				<div class="wpbr-review__header">
					${this.reviewerImage ? this.renderReviewerImage( this.reviewerImage ) : ''}
					<div class="wpbr-review__details">
						<h3 class="wpbr-review__name js-wpbr-review-name">${this.reviewer}</h3>
						${0 < this.rating ? stars.generateStars( this.rating, this.platform ) : ''}
						${this.timestamp ? this.renderTimestamp( this.timestamp ) : ''}
					</div>
				</div>
				${this.content ? this.renderContent( this.content ) : ''}
			</div>
		`;
	}

	renderReviewerImage( imageUrl ) {
		return `<div class="wpbr-review__image"><img src="${imageUrl}"></div>`;
	}

	renderTimestamp( timestamp ) {
		return `<span class="wpbr-review__timestamp">${timestamp}</span>`;
	}

	renderContent( content ) {
		const arrayOfStrings = content.split( '\n' );
		const paragraphs = `${arrayOfStrings.map( string => `<p>${string}</p>` ).join( '' )}`;

		return `<div class="wpbr-review__content">${paragraphs}</div>`;
	}
}

export default Review;
