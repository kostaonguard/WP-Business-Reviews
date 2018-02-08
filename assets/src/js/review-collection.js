import Review from './review';

class ReviewCollection {
	constructor( reviews = array(), settings = array() ) {
		this.reviews  = new Set( reviews );
		this.settings = settings;
	}

	init() {
		if ( 0 === this.reviews.size ) {
			this.setPlaceholderReviews();
		}
	}

	replaceReviews( reviews ) {
		this.reset();
		this.reviews = reviews;
		this.renderItems();
	}

	addReviews( reviews ) {
		this.reviews.add( reviewObj );
	}

	render( context ) {
		const listEl    = document.createElement( 'ul' );
		const itemClass = this.getItemClass();

		// Add wrapper and list classes according to settings.
		context.className = this.getWrapClass();
		listEl.className  = this.getListClass();

		// Render each review within a list item.
		for ( const review of this.reviews ) {
			const listItemEl     = document.createElement( 'li' );
			listItemEl.className = itemClass;

			// Pass settings to render review inside list item.
			review.render( listItemEl );

			// Append to list item to list.
			listEl.appendChild( listItemEl );
		}

		context.appendChild( listEl );
	}

	setPlaceholderReviews() {
		const platform   = '';
		const reviews    = new Set();
		const components = {
			reviewer: 'FirstName LastName',
			reviewer_image: 'placeholder',
			rating: 5,
			timestamp: '2 weeks ago',
			review_content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer tempus, dui eu posuere viverra, orci tortor congue urna, non fringilla enim tellus sed quam. Maecenas vel mattis erat. Maecenas tincidunt neque a orci dapibus faucibus. Curabitur nulla ex, scelerisque vel congue in.'
		};

		for ( let index = 0; 12 > index; index++ ) {
			reviews.add( new Review( platform, components ) );
		}

		this.setReviews( reviews );
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

		switch ( this.settings.format ) {

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

		switch ( this.settings.format ) {

		case 'review_gallery':
			itemClass = `wpbr-review-gallery__item wpbr-review-gallery__item--${this.maxColumns}`;
			break;

		case 'review_list':
			itemClass = 'wpbr-stacked-list__item';
			break;
		}

		return itemClass;
	}

	setReviews( reviews ) {
		this.reviews = reviews;
	}

	reset() {
		this.reviews.clear();
		this.list.innerHTML = '';
	}
}

export default ReviewCollection;
