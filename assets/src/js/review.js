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
	 * @param {string} platform   Platform ID.
	 * @param {Object}  components Review components.
	 */
	constructor( platform, components ) {
		this.platform    = platform;
		this.components  = components;
		this.isTruncated = false;
	}

	/**
	 * Renders the review.
	 *
	 * @since 0.1.0
	 *
	 * @param {Element|DocumentFragment} context       Where the markup is rendered.
	 * @param {number}                   maxCharacters Max characters. 0 is unlimited.
	 * @param {string}                   lineBreaks    Whether line breaks are enabled.
	 * @returns {string} Review markup.
	 */
	render( context, maxCharacters = 280, lineBreaks = 'disabled' ) {
		const platform = this.platform;
		const c        = this.components;
		let html       = '';

		html = `
			<div class="wpbr-review">
				<div class="wpbr-review__header">
					${c.reviewer_image ? this.renderReviewerImage() : ''}
					<div class="wpbr-review__details">
						<h3 class="wpbr-review__name js-wpbr-review-name">${c.reviewer}</h3>
						${0 < c.rating ? stars.generateStars( c.rating, platform ) : ''}
						${c.timestamp ? this.renderTimestamp() : ''}
					</div>
				</div>
				${c.review_content ? this.renderContent( maxCharacters, lineBreaks ) : ''}
			</div>
		`;

		context.innerHTML = html;
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
		const reviewerImage = this.components.reviewer_image;

		if ( 'placeholder' === reviewerImage ) {
			return '<div class="wpbr-review__image wpbr-review__image--placeholder"></div>';
		} else {
			return `<div class="wpbr-review__image"><img src="${reviewerImage}"></div>`;
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
		const platform  = this.platform;
		const timestamp = this.components.timestamp;

		return `<span class="wpbr-review__timestamp">${timestamp} via ${platform}</span>`;
	}

	/**
	 * Renders the review content.
	 *
	 * If the content string contains lines breaks, the string will be parsed
	 * and rendered as multiple paragraphs.
	 *
	 * @since 0.1.0
	 *
	 * @param {number} maxCharacters Max characters. 0 is unlimited.
	 * @param {string} lineBreaks    Whether line breaks are enabled.
	 * @returns string Review content markup.
	 */
	renderContent( maxCharacters = 0, lineBreaks = 'disabled' ) {
		const reviewUrl = this.components.review_url;
		let content     = this.components.review_content;

		// Only truncate if original review is not already truncated.
		if ( ! this.isTruncated && 0 < maxCharacters ) {
			content = truncate(
				content,
				{
					'length': maxCharacters,
					'omission': '...',
					'separator': /[.?!,]? +/
				}
			);

			if ( content !== this.components.review_content ) {
				this.isTruncated = true;
			}
		}

		if ( 'enabled' === lineBreaks ) {
			let arrayOfStrings = content.split( '\n' );

			if ( this.isTruncated && reviewUrl ) {
				arrayOfStrings[arrayOfStrings.length - 1] += ` ${this.renderOmission()}`;
			}

			// Set content equal to multiple paragraphs with possible omission.
			content = `
				${arrayOfStrings.map( string => `<p>${string}</p>` ).join( '' )}
			`;
		} else if ( this.isTruncated && reviewUrl ) {

			// Set truncated content equal to single paragraph with omission.
			content = `<p>${content} ${this.renderOmission()}</p>`;
		} else {

			// Set full content equal to single paragraph.
			content = `<p>${content}</p>`;
		}

		return `<div class="wpbr-review__content">${content}</div>`;
	}

	renderOmission() {
		const reviewUrl = this.components.review_url;
		const className = 'wpbr-review__omission';

		// TODO: Translate Read More in truncated excerpts.
		return `<a class="${className}" href="${reviewUrl}" target="_blank" rel="noopener noreferrer">Read more</a>`;
	}
}

export default Review;
