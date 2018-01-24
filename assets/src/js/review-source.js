import * as stars from './stars';

class ReviewSource {
	constructor( data ) {
		this.platform         = data.platform;
		this.reviewSourceId   = data.review_source_id;
		this.name             = data.name;
		this.rating           = data.rating;
		this.icon             = data.icon;
		this.image            = data.image;
		this.formattedAddress = data.formatted_address;
		this.isFetchable      = false;
	}

	render() {
		return `
			<div class="wpbr-review-source">
				${this.image ? this.renderImage() : ''}
				<span class="wpbr-review-source__name">${this.name}</span><br>
				<span class="wpbr-review-source__rating wpbr-review-source__rating--${this.platform}">
					${0 < this.rating ? this.rating + stars.generateStars( this.rating, this.platform )  : 'Not yet rated.'}
				</span><br>
				${this.formattedAddress ? this.renderAddress() : ''}
				${this.isFetchable ? this.renderFetchButton() : ''}
			</div>
		`;
	}

	renderImage() {
		return `<img class="wpbr-review-source__image wpbr-review-source__image--cover" src="${this.image}">`;
	}

	renderAddress() {
		return `<span class="wpbr-review-source__address">${this.formattedAddress}</span>`;
	}

	renderFetchButton() {

		// TODO: Translate 'Get Reviews' button text.
		return `
			<button
				class="wpbr-review-source__button button button-primary js-wpbr-review-fetcher-button"
				type="button"
				data-wpbr-platform="${this.platform}"
				data-wpbr-review-source-id="${this.reviewSourceId}"
			>
				Get Reviews
			</button>
		`;
	}
}

export default ReviewSource;
