import * as stars from './stars';

class PlatformSearchResults {
	constructor( element, platform ) {
		this.root = element;
	}

	populateResults( results ) {
		const fragment    = document.createDocumentFragment();
		const scrollable  = document.createElement( 'div' );
		const resultsList = document.createElement( 'ul' );

		scrollable.className  = 'wpbr-scrollable wpbr-scrollable--border';
		resultsList.className = 'wpbr-stacked-list wpbr-stacked-list--striped';

		for ( const result of results ) {
			const li = document.createElement( 'li' );
			li.className = 'wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom';
			li.innerHTML = this.generateResult( result );
			resultsList.appendChild( li );
		}

		scrollable.appendChild( resultsList );
		fragment.appendChild( scrollable );
		this.root.appendChild( fragment );

		const reviewSourcesReadyEvent = new CustomEvent(
			'wpbrReviewSourcesReady',
			{ bubbles: true }
		);
		this.root.dispatchEvent( reviewSourcesReadyEvent );
	}

	generateResult( result ) {
		const {
			image: image,
			icon: icon,
			name: name,
			platform: platform,
			formatted_address: address,
			rating: rating,
			review_source_id: id
		} = result;

		return `
			<div class="wpbr-review-source">
				${image ? `<img class="wpbr-review-source__image wpbr-review-source__image--cover" src="${image}">` : ''}
				<span class="wpbr-review-source__name">${name}</span><br>
				<span class="wpbr-review-source__rating wpbr-review-source__rating--${platform}">
					${0 < rating ? rating + stars.generateStars( rating, platform )  : 'Not yet rated.'}
				</span><br>
				<span class="wpbr-review-source__address">${address}</span><br>
				<button class="wpbr-review-source__button button button-primary js-wpbr-review-fetcher-button" data-wpbr-platform="${platform}" data-wpbr-review-source-id="${id}">Get Reviews</button>
			</div>
		`;
	}
}

export default PlatformSearchResults;
