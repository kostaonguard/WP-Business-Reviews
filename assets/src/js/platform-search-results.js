class PlatformSearchResults {
	constructor( element, platform ) {
		this.root = element;
		this.platform = platform;
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
			listItem.appendChild( this.createReviewSource( result ) );
			resultsList.appendChild( listItem );
		});

		// Here the results are added to the page.
		this.root.appendChild( scrollable );
	}

	createReviewSource( result ) {
		const el     = document.createElement( 'div' );

		el.className = 'wpbr-review-source';

		if ( result.image )  {
			el.appendChild( this.createCoverImage( result.image, result.name ) );
		}

		el.appendChild( this.createName( result.name, result.url ) );
		el.appendChild( document.createElement( 'br' ) );

		if ( parseFloat( result.rating ) ) {
			el.appendChild( this.createRating( result.rating, this.platform ) );
		} else {
			el.appendChild( this.createRatingFallback( result.rating ) );
		}

		el.appendChild( document.createElement( 'br' ) );
		el.appendChild( this.createAddress( result.formatted_address ) );
		el.appendChild( document.createElement( 'br' ) );
		el.appendChild(	this.createReviewsButton( this.platform, result.platform_id ) );

		return el;
	}

	createIcon( icon ) {
		const el = document.createElement( 'img' );

		el.className = 'wpbr-review-source__image';
		el.src = image;
		el.alt = alt;

		return el;
	}

	createCoverImage( image, alt ) {
		const el = document.createElement( 'img' );

		el.className = 'wpbr-review-source__image wpbr-review-source__image--cover';
		el.src = image;
		el.alt = alt;

		return el;
	}

	createName( name, url ) {
		const el     = document.createElement( 'span' );

		el.className = 'wpbr-review-source__name';
		el.innerText = name;

		return el;
	}

	createRating( rating, platform ) {
		const el     = document.createElement( 'span' );

		platform = platform.replace( /_/, '-' );
		el.className = `wpbr-review-source__rating wpbr-review-source__rating--${platform}`;
		el.innerText = rating + ' ';
		el.appendChild( this.createStars( rating, platform ) );

		return el;
	}

	createRatingFallback() {
		const el     = document.createElement( 'span' );

		el.className = 'wpbr-review-source__rating';

		// TODO: Translate 'Not yet rated.'
		el.innerText = 'Not yet rated.';

		return el;
	}

	createStars( rating, platform ) {
		const el     = document.createElement( 'span' );

		el.className = `wpbr-stars wpbr-stars--${platform}`;
		el.innerText = '★★★★★';

		return el;
	}

	createAddress( address ) {
		const el     = document.createElement( 'span' );

		el.className = 'wpbr-review-source__address';
		el.innerText = address;

		return el;
	}

	createReviewsButton( platform, platformId ) {
		const el     = document.createElement( 'button' );
		el.className = 'wpbr-review-source__button button button-primary js-wpbr-review-fetcher-button';
		el.setAttribute( 'data-wpbr-platform', platform );
		el.setAttribute( 'data-wpbr-platform-id', platformId );

		//TODO: Translate 'Get Reviews'.
		el.innerText = 'Get Reviews';

		return el;
	}
}

export default PlatformSearchResults;
