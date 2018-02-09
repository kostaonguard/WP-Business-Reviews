import Review from './review';

class ReviewCollection {
	constructor( reviews = [], settings = []) {
		this.reviews  = new Set( reviews );
		this.settings = settings;
		this.list = null;
		this.items = new Set();
	}

	init() {
		if ( 0 === this.reviews.size ) {
			this.setPlaceholderReviews();
		}
	}

	render( context ) {
		this.list = document.createElement( 'ul' );

		// Add wrapper and list classes according to settings.
		const themeClassName  = this.getThemeClassName();
		const formatClassName = this.getFormatClassName();

		this.list.className  = `${themeClassName} ${formatClassName}`;

		// Render each review within a list item.
		for ( const review of this.reviews ) {
			const item = document.createElement( 'li' );

			// Pass settings to render review inside list item.
			review.render(
				item,
				this.settings.max_characters,
				this.settings.line_breaks
			);

			// Add item to set so it can be accessed later.
			this.items.add( item );

			// Append to list item to list.
			this.list.appendChild( item );
		}

		this.updatePresentation();

		context.appendChild( this.list );
	}

	updatePresentation() {
		const themeClassName  = this.getThemeClassName();
		const formatClassName = this.getFormatClassName();
		const itemClassName   = this.getItemClassName();

		this.list.className  = `${themeClassName} ${formatClassName}`;

		for ( const item of this.items ) {
			item.className = itemClassName;
		}
	}

	updateReviews() {
		const reviewsIterator = this.reviews.values();

		for ( const item of this.items ) {
			const review = reviewsIterator.next();
			review.value.render(
				item,
				this.settings.max_characters,
				this.settings.line_breaks
			);
		}
	}

	setPlaceholderReviews() {
		const platform       = '';
		const reviewSourceId = '';
		const reviews        = new Set();
		const components     = {
			reviewer: 'FirstName LastName',
			reviewer_image: 'placeholder',
			rating: 5,
			timestamp: '2 weeks ago',
			content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempus, dui eu posuere viverra, orci tortor congue urna, non fringilla enim tellus sed quam. Maecenas vel mattis erat. Maecenas tincidunt neque a orci dapibus faucibus. Curabitur nulla ex, scelerisque vel congue in.'
		};

		for ( let index = 0; 12 > index; index++ ) {
			reviews.add( new Review( platform, reviewSourceId, components ) );
		}

		this.setReviews( reviews );
	}

	getThemeClassName() {
		let className = '';

		switch ( this.settings.theme ) {
		case 'card':
			className = 'wpbr-theme--card';
			break;
		case 'dark':
			className = 'wpbr-theme--dark';
			break;
		}

		return className;
	}

	getFormatClassName() {
		let className;

		switch ( this.settings.format ) {
		case 'review_gallery':
			className = 'wpbr-review-gallery';
			break;
		case 'review_list':
			className = 'wpbr-stacked-list';
			break;
		}

		return className;
	}

	getItemClassName() {
		let className;

		switch ( this.settings.format ) {
		case 'review_gallery':
			className = `wpbr-review-gallery__item wpbr-review-gallery__item--${this.settings.max_columns}`;
			break;
		case 'review_list':
			className = 'wpbr-stacked-list__item';
			break;
		}

		return className;
	}

	setReviews( reviews ) {
		this.reviews = reviews;
	}

	reset() {
		this.reviews.clear();
		this.items.clear();
		this.list.parentNode.removeChild( this.list );
	}
}

export default ReviewCollection;
