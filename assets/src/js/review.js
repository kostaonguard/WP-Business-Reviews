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
		this.maxCharacters = data.maxCharacters || 280;
		this.lineBreaks    = data.lineBreaks || 'disabled';
		this.isTruncated   = data.is_truncated || false;
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
		let content     = this.content;
		let isTruncated = this.isTruncated;

		// Only truncate if original review is not already truncated via API.
		if ( ! this.isTruncated && 0 < this.maxCharacters ) {
			content = truncate(
				this.content,
				{
					'length': this.maxCharacters,
					'omission': '...',
					'separator': /[.?!,]? +/
				}
			);

			if ( content !== this.content ) {
				isTruncated = true;
			}
		}

		if ( 'enabled' === this.lineBreaks ) {
			let arrayOfStrings = content.split( '\n' );

			if ( isTruncated && this.reviewUrl ) {
				arrayOfStrings[arrayOfStrings.length - 1] += ` ${this.renderOmission()}`;
			}

			content = `
				${arrayOfStrings.map( string => `<p>${string}</p>` ).join( '' )}
			`;
		} else if ( isTruncated && this.reviewUrl ) {
			content = `<p>${content} ${this.renderOmission()}</p>`;
		} else {
			content = `<p>${content}</p>`;
		}

		return `<div class="wpbr-review__content">${content}</div>`;
	}

	renderOmission() {
		const classAtt = 'wpbr-review__omission';

		// TODO: Translate Read More in truncated excerpts.
		return `<a class="${classAtt}" href="${this.reviewUrl}" target="_blank" rel="noopener noreferrer">Read more</a>`;
	}
}

export default Review;
