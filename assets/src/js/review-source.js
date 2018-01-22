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
			</div>
		`;
	}

	renderImage() {
		return `<img class="wpbr-review-source__image wpbr-review-source__image--cover" src="${this.image}">`;
	}

	renderAddress() {
		return `<span class="wpbr-review-source__address">${this.formattedAddress}</span>`;
	}
}

export default ReviewSource;
