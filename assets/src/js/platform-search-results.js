class PlatformSearchResults {
	constructor( element, platform ) {
		this.root = element;
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
		this.scrollable = document.createElement( 'div' );
		this.scrollable.className = 'wpbr-scrollable wpbr-scrollable--border';

		// Create empty results list.
		this.resultsList = document.createElement( 'ul' );
		this.resultsList.className = 'wpbr-stacked-list wpbr-stacked-list--striped';

		// Append empty results list to scrollable container.
		this.scrollable.appendChild( this.resultsList );

		// TODO: Translate strings in search results.
		const listItemsMarkup = `
			${results.map( reviewSource => `
				<li class="wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom">
					<div class="wpbr-media">
						<div class="wpbr-media__figure wpbr-media__figure--icon js-wpbr-icon">
							<img src="${reviewSource.icon}"><br>
						</div>
						<div class="wpbr-media__body">
							<div class="wpbr-business">
								<a class="wpbr-business__name" href="${reviewSource.url}" target="_blank" rel="noopener noreferrer">${reviewSource.name}</a><br>
								<span class="wpbr-business__rating">${parseFloat( reviewSource.rating ).toFixed( 1 )} <span class="wpbr-stars wpbr-stars--google">★★★★★</span></span>
								<span class="wpbr-business__address">${reviewSource.formatted_address}</span><br>
								<button class="button button-primary js-wpbr-get-reviews-button">Get Reviews</button>
							</div>
						</div>
					</div>
				</li>
			` ).join( '' ) }
		`;

		// Update and display results list.
		this.resultsList.innerHTML = listItemsMarkup;

		// Append scrollable to bottom of root.
		this.root.appendChild( this.scrollable );
	}
}

export default PlatformSearchResults;
