/**
 * Defines the Review class.
 *
 * @link https://wpbusinessreviews.com
 *
 * @since 0.1.0
 */

import * as stars from './stars';
import truncate from 'lodash.truncate';

/** Class representing a review. */
class Review {

	/**
	 * Instantiates a Review object.
	 *
	 * @since 0.1.0
	 *
	 * @param {array} data Review data in JSON format.
	 */
	constructor( data ) {
		this.platform      = data.platform;
		this.reviewUrl     = data.review_url;
		this.reviewer      = data.reviewer;
		this.reviewerImage = data.reviewer_image;
		this.rating        = data.rating;
		this.timestamp     = data.timestamp;
		this.content       = data.content;
	}

	/**
	 * Renders the review.
	 *
	 * @since 0.1.0
	 *
	 * @returns string Review markup.
	 */
	render() {
		return `
			<div class="wpbr-review">
				<div class="wpbr-review__header">
					${this.reviewerImage ? this.renderReviewerImage() : ''}
					<div class="wpbr-review__details">
						<h3 class="wpbr-review__name js-wpbr-review-name">${this.reviewer}</h3>
						${0 < this.rating ? stars.generateStars( this.rating, this.platform ) : ''}
						${this.timestamp ? this.renderTimestamp() : ''}
					</div>
				</div>
				${this.content ? this.renderContent() : ''}
			</div>
		`;
	}

	/**
	 * Renders the reviewer image.
	 *
	 * If the value of the image property is `placeholder`, then a placeholder
	 * div is rendered. Otherwise an image element is rendered.
	 *
	 * @since 0.1.0
	 *
	 * @returns string Review image markup.
	 */
	renderReviewerImage() {
		if ( 'placeholder' === this.reviewerImage ) {
			return '<div class="wpbr-review__image wpbr-review__image--placeholder"></div>';
		} else {
			return `<div class="wpbr-review__image"><img src="${this.reviewerImage}"></div>`;
		}
	}

	/**
	 * Renders the review timestamp.
	 *
	 * @since 0.1.0
	 *
	 * @returns string Review timestamp markup.
	 */
	renderTimestamp() {
		return `<span class="wpbr-review__timestamp">${this.timestamp}</span>`;
	}

	/**
	 * Renders the review content.
	 *
	 * If the content string contains lines breaks, the string will be parsed
	 * and rendered as multiple paragraphs.
	 *
	 * @since 0.1.0
	 *
	 * @returns string Review content markup.
	 */
	renderContent() {
		const arrayOfStrings = this.content.split( '\n' );
		const paragraphs = `${arrayOfStrings.map( string => `<p>${string}</p>` ).join( '' )}`;

		return `<div class="wpbr-review__content">${paragraphs}</div>`;
	}
}

export default Review;
