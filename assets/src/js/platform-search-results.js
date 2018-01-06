class PlatformSearchResults {
	constructor( platform ) {
		this.platform = platform;

		// Set this.buttons.
	}

	init() {
		this.registerButtonEventHandlers();
	}

	registerButtonEventHandlers() {

		// this.buttons.forEach( ( button ) => {
		// 	button.on( 'click', () => {

		// 	});
		// });
	}

	populateResults( results ) {

		// Create scrollable container to hold results.
		this.root = document.createElement( 'div' );
		this.root.className = 'wpbr-scrollable wpbr-scrollable--border';

		// Create empty results list.
		this.resultsList = document.createElement( 'ul' );
		this.resultsList.className = 'wpbr-stacked-list wpbr-stacked-list--striped';

		// Append empty list to results container.
		this.root.appendChild( this.resultsList );

		// Append results to bottom of container.
		this.termsField.root.parentNode.appendChild( this.root );

		// TODO: Sanitize places markup before displaying.
		const listItemsMarkup = `
			${results.map( place => `
				<li class="wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom">
					<div class="wpbr-media">
						<div class="wpbr-media__figure wpbr-media__figure--icon">
							<img src="${place.icon}"><br>
						</div>
						<div class="wpbr-media__body">
							<div class="wpbr-business">
								<a class="wpbr-business__name" href="https://www.google.com/maps/place/?q=place_id:${place.place_id}" target="_blank" rel="noopener noreferrer">${place.name}</a><br>
								${isNaN( place.rating ) ? '' : `<span class="wpbr-business__rating">${parseFloat( place.rating ).toFixed( 1 )} <span class="wpbr-stars wpbr-stars--google">★★★★★</span></span><br>` }
								<span class="wpbr-business__address">${place.formatted_address}</span><br>
								<button class="button button-primary js-wpbr-get-reviews-button">Get Reviews</button>
							</div>
						</div>
					</div>
				</li>
			` ).join( '' )}
		`;

		// Update and display results list.
		this.resultsList.innerHTML = listItemsMarkup;
	}
}

export default PlatformSearchResults;
