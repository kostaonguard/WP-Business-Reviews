class GooglePlacesTextSearch {
	constructor( selector ) {
		this.container = document.querySelector( selector );

		// Define platform field elements.
		this.platformField = this.container.querySelector( '.js-wpbr-field-platform' );
		this.platformLabel = this.platformField.querySelector( '.js-wpbr-label' );
		this.platformControl = this.platformField.querySelector( '.js-wpbr-control' );

		// Define search field elements.
		this.searchField = this.container.querySelector( '.js-wpbr-field-search' );
		this.searchControl = this.searchField.querySelector( '.js-wpbr-control' );
		this.searchInput = this.searchField.querySelector( '.js-wpbr-search-input' );
		this.searchButton = this.searchField.querySelector( '.js-wpbr-search-button' );
		this.searchDescription = this.searchField.querySelector( '.js-wpbr-description' );
	}

	init() {
		this.initSearchButton();
	}

	initSearchButton() {
		this.searchButton.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			this.search( this.searchInput.value );
		});
	}

	search( query ) {

		// If query is empty, clear results and bail early.
		if ( '' == query ) {
			this.clearResults();
			return;
		}

		const service = new google.maps.places.PlacesService( document.createElement( 'div' ) );
		const request = {
			query: query
		};

		service.textSearch( request, ( results, status ) => {
			this.updateResults( results, status );
		});
	}

	initResults() {

		// Create scrollable container to hold results.
		this.results = document.createElement( 'div' );
		this.results.className = 'wpbr-builder__results wpbr-scrollable wpbr-scrollable--border';

		// Create empty results list.
		this.resultsList = document.createElement( 'ul' );
		this.resultsList.className = 'wpbr-stacked-list wpbr-stacked-list--striped';

		// Append empty list to results container.
		this.results.appendChild( this.resultsList );

		// Append results to bottom of container.
		this.searchField.appendChild( this.results );
	}

	updateResults( results, status ) {
		if ( status == google.maps.places.PlacesServiceStatus.OK ) {

			if ( 1 > results.length ) {

				// Bail early if no results.
				return;
			} else if ( undefined === this.results ) {

				// Initialize results if they do not exist.
				this.initResults();
			} else {

				// Clear results if they do exist.
				this.clearResults();
			}

			// Disable platform control while search is active.
			this.togglePlatformDisabled();

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
			this.results.classList.remove( 'wpbr-u-hidden' );

			// Create new reset button or display existing button.
			if ( undefined === this.resetButton ) {
				this.initResetButton();
			} else {
				this.resetButton.classList.remove( 'wpbr-u-hidden' );
			}
		}

	}

	initResetButton() {
		this.resetButton = document.createElement( 'button' );
		this.resetButton.className = 'button';
		this.resetButton.innerHTML = 'Reset Business Options';

		// Append reset button to bottom of container.
		this.searchField.appendChild( this.resetButton );

		this.resetButton.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			this.reset();
		});
	}

	clearSearch() {
		this.searchInput.value = '';
	}

	clearResults() {
		this.results.classList.add( 'wpbr-u-hidden' );
		this.resetButton.classList.add( 'wpbr-u-hidden' );
		this.resultsList.innerHTML = '';
	}

	togglePlatformDisabled() {
		if ( this.platformControl.hasAttribute( 'disabled' ) ) {
			this.platformControl.removeAttribute( 'disabled' );
		} else {
			this.platformControl.setAttribute( 'disabled', '' );
		}
	}

	reset() {
		this.clearSearch();
		this.clearResults();
		this.togglePlatformDisabled();
	}
}

export default GooglePlacesTextSearch;
