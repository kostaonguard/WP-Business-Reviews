import * as stars from './stars';

class ReviewSource {
	constructor( data ) {
		this.platform          = data.platform;
		this.reviewSourceId  = data.review_source_id;
		this.name              = data.name;
		this.url               = data.url;
		this.rating            = data.rating;
		this.ratingCount      = data.rating_count;
		this.icon              = data.icon;
		this.image             = data.image;
		this.phone             = data.phone;
		this.formattedAddress = data.formatted_address;
		this.streetAddress    = data.street_address;
		this.city              = data.city;
		this.stateProvince    = data.state_province;
		this.postalCode       = data.postal_code;
		this.country           = data.country;
		this.latitude          = data.latitude;
		this.longitude         = data.longitude;
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
				class="wpbr-review-source__button button button-primary js-wpbr-fetch-control"
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
