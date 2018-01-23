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

	replaceReviews( reviewsData ) {
		this.reset();
		this.addReviews( reviewsData );
		this.renderItems();
	}

	addReviews( reviewsData ) {
		for ( const data of reviewsData ) {
			const reviewObj = new Review( data );
			this.reviews.add( reviewObj );
		}
	}

	renderItems() {
		const fragment  = document.createDocumentFragment();
		const itemClass = this.getItemClass();

		for ( const review of this.reviews ) {
			const li     = document.createElement( 'li' );
			li.className = itemClass;
			li.innerHTML = review.render();

			// Append to fragment for rendering purposes.
			fragment.appendChild( li );

			// Add to items for future formatting.
			this.items.add( li );
		}

		this.list.appendChild( fragment );
	}

	renderPlaceholderReviews() {
		let reviewsData = [];
		let data = new Object();

		data.platform  = '';
		data.reviewer  = 'FirstName LastName';
		data.image     = 'placeholder';
		data.rating    = 5;
		data.timestamp = '2 weeks ago';
		data.content   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda beatae in laborum laudantium neque omnis optio quasi qui sit voluptatum!';

		for ( let index = 0; 12 > index; index++ ) {
			reviewsData.push( data );
		}

		this.addReviews( reviewsData );
		this.renderItems( reviewsData );
	}

	getWrapClass() {
		let wrapClass;

		switch ( this.theme ) {

		case 'card':
			wrapClass = 'wpbr-wrap wpbr-theme--card';
			break;

		case 'seamless-dark':
			wrapClass = 'wpbr-stacked-list wpbr-theme--dark';
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
