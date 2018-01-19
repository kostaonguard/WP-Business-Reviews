import * as stars from './stars';
import truncate from 'lodash.truncate';

class Review {
	constructor( data ) {
		this.platform  = data.platform;
		this.reviewer  = data.reviewer;
		this.image     = data.image;
		this.rating    = data.rating;
		this.timestamp = data.timestamp;
		this.content   = data.content;
	}

	render() {
		return `
			<div class="wpbr-review">
				<div class="wpbr-review__header">
					${this.image ? this.renderImage() : ''}
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

	renderImage() {
		if ( 'placeholder' === this.image ) {
			return '<div class="wpbr-review__image wpbr-review__image--placeholder"></div>';
		} else {
			return `<div class="wpbr-review__image"><img src="${this.image}"></div>`;
		}
	}

	renderTimestamp() {
		return `<span class="wpbr-review__timestamp">${this.timestamp}</span>`;
	}

	renderContent() {
		const arrayOfStrings = this.content.split( '\n' );
		const paragraphs = `${arrayOfStrings.map( string => `<p>${string}</p>` ).join( '' )}`;

		return `<div class="wpbr-review__content">${paragraphs}</div>`;
	}
}

export default Review;
