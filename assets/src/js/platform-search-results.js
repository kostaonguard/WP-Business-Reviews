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
		const scrollable = document.createElement( 'div' );
		scrollable.className = 'wpbr-scrollable wpbr-scrollable--border';

		// Create empty results list.
		const resultsList = document.createElement( 'ul' );
		resultsList.className = 'wpbr-stacked-list wpbr-stacked-list--striped';

		// Append empty results list to scrollable container.
		scrollable.appendChild( resultsList );

		// Create list items.
		results.forEach( result => {
			const listItem = document.createElement( 'li' );
			listItem.className = 'wpbr-stacked-list__item wpbr-stacked-list__item--border-bottom';
			listItem.appendChild( this.createReviewSourceElement( result ) );
			resultsList.appendChild( listItem );
		});

		// Here the results are added to the page.
		this.root.appendChild( scrollable );
	}

	createReviewSourceElement( result ) {
		const el     = document.createElement( 'div' );
		el.className = 'wpbr-review-source';

		if ( result.image )  {
			el.appendChild( this.createImageElement( result.image, result.name ) );
		}

		el.appendChild( this.createNameElement( result.name, result.url ) );
		el.appendChild( document.createElement( 'br' ) );

		if ( parseFloat( result.rating ) ) {
			el.appendChild( this.createRatingElement( result.rating, this.platform ) );
		} else {
			el.appendChild( this.createRatingFallbackElement( result.rating ) );
		}

		el.appendChild( document.createElement( 'br' ) );
		el.appendChild( this.createAddressElement( result.formatted_address ) );
		el.appendChild( document.createElement( 'br' ) );
		el.appendChild(	this.createGetReviewsButton( this.platform ) );

		return el;
	}

	createIconElement( icon ) {
		const el = document.createElement( 'img' );
		el.className = 'wpbr-review-source__image wpbr-review-source__image--cover';
		el.src = image;
		el.alt = alt;

		return el;
	}

	createImageElement( image, alt ) {
		const el = document.createElement( 'img' );
		el.className = 'wpbr-review-source__image wpbr-review-source__image--cover';
		el.src = image;
		el.alt = alt;

		return el;
	}

	createNameElement( name, url ) {
		const el     = document.createElement( 'span' );
		el.className = 'wpbr-review-source__name';
		el.innerText = name;

		return el;
	}

	createRatingElement( rating, platform ) {
		const el     = document.createElement( 'span' );
		platform = platform.replace( /_/, '-' );
		el.className = `wpbr-review-source__rating wpbr-review-source__rating--${platform}`;
		el.innerText = rating + ' ';
		el.appendChild( this.createStars( rating, platform ) );

		return el;
	}

	createRatingFallbackElement() {
		const el     = document.createElement( 'span' );
		el.className = 'wpbr-review-source__rating';

		// Translate 'Not yet rated.'
		el.innerText = 'Not yet rated.';

		return el;
	}

	createStars( rating, platform ) {
		const el     = document.createElement( 'span' );
		el.className = `wpbr-stars wpbr-stars--${platform}`;
		el.innerText = '★★★★★';

		return el;
	}

	createAddressElement( address ) {
		const el     = document.createElement( 'span' );
		el.className = 'wpbr-review-source__address';
		el.innerText = address;

		return el;
	}

	createGetReviewsButton( platformId ) {
		const el     = document.createElement( 'button' );
		el.className = 'button button-primary js-wpbr-get-reviews-button';
		el.setAttribute( 'data-wpbr-platform-id', platformId );

		//TODO: Translate 'Get Reviews'.
		el.innerText = 'Get Reviews';

		return el;
	}
}

export default PlatformSearchResults;
