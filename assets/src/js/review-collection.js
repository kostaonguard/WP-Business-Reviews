import Review from './review';

class ReviewCollection {
	constructor( element, format, maxColumns, theme ) {
		this.root       = element;
		this.format     = format;
		this.maxColumns = maxColumns;
		this.theme      = theme;
		this.items      = new Set();
		this.reviews    = new Set();
	}

	init() {
		this.list = document.createElement( 'ul' );
		this.updatePresentation();
		this.renderPlaceholderReviews();
		this.root.appendChild( this.list );
	}

	replaceReviews( reviews ) {
		this.reset();
		this.reviews = reviews;
		this.renderItems();
	}

	addReviews( reviews ) {
		this.reviews.add( reviewObj );
	}

	renderItems() {
		const fragment  = document.createDocumentFragment();
		const itemClass = this.getItemClass();

		for ( const review of this.reviews ) {
			const li     = document.createElement( 'li' );
			li.className = itemClass;
			review.render( li );

			// Append to fragment for rendering purposes.
			fragment.appendChild( li );

			// Add to items for future formatting.
			this.items.add( li );
		}

		this.list.appendChild( fragment );
	}

	updateReviews() {
		const reviewsIterator = this.reviews.values();

		for ( const li of this.items ) {
			const review = reviewsIterator.next();

			li.innerHTML = review.value.render();
		}
	}

	renderPlaceholderReviews() {
		const platform    = '';
		const reviews = new Set();
		const components = {
			review_url: 'https://google.com',
			reviewer: 'FirstName LastName',
			reviewer_image: 'placeholder',
			rating: 5,
			timestamp: '2 weeks ago',
			review_content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempus, dui eu posuere viverra, orci tortor congue urna, non fringilla enim tellus sed quam. Maecenas vel mattis erat. Maecenas tincidunt neque a orci dapibus faucibus. Curabitur nulla ex, scelerisque vel congue in.'
		};

		for ( let index = 0; 12 > index; index++ ) {
			reviews.add( new Review( platform, components ) );
		}

		this.replaceReviews( reviews );
	}

	updatePresentation() {
		const wrapClass = this.getWrapClass();
		const listClass = this.getListClass();
		const itemClass = this.getItemClass();

		this.root.className = wrapClass;
		this.list.className = listClass;

		for ( const item of this.items ) {
			item.className = itemClass;
		}
	}

	getWrapClass() {
		let wrapClass;

		switch ( this.theme ) {

		case 'card':
			wrapClass = 'wpbr-wrap wpbr-theme--card';
			break;

		case 'seamless-dark':
			wrapClass = 'wpbr-wrap wpbr-theme--dark';
			break;
		default:
			wrapClass = 'wpbr-wrap';

		}

		return wrapClass;
	}

	getListClass() {
		let listClass;

		switch ( this.format ) {

		case 'review_gallery':
			listClass = 'wpbr-review-gallery';
			break;

		case 'review_list':
			listClass = 'wpbr-stacked-list';
			break;
		}

		return listClass;
	}

	getItemClass() {
		let itemClass;

		switch ( this.format ) {

		case 'review_gallery':
			itemClass = `wpbr-review-gallery__item wpbr-review-gallery__item--${this.maxColumns}`;
			break;

		case 'review_list':
			itemClass = 'wpbr-stacked-list__item';
			break;
		}

		return itemClass;
	}

	reset() {
		this.items.clear();
		this.reviews.clear();
		this.list.innerHTML = '';
	}
}

export default ReviewCollection;
