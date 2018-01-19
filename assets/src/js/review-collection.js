import Review from './review';

class ReviewCollection {
	constructor( element, format, maxColumns, theme ) {
		this.root       = element;
		this.format     = format;
		this.maxColumns = maxColumns;
		this.theme      = theme;
	}

	init() {
		this.list    = document.createElement( 'ul' );
		this.items   = new Set();
		this.reviews = new Set();

		this.updatePresentation();
		this.root.appendChild( this.list );

		this.renderPlaceholderReviews();
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
		this.clearReviews();
		this.addReviews( reviewsData );
		this.renderReviews();
	}

	addReviews( reviewsData ) {
		for ( const reviewData of reviewsData ) {
			const reviewObj = new Review( reviewData );
			this.reviews.add( reviewObj );
		}
	}

	clearReviews() {
		this.items.clear();
		this.reviews.clear();
		this.list.innerHTML = '';
	}

	renderReviews() {
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
		let reviewData = new Object();

		reviewData.platform  = '';
		reviewData.reviewer  = 'FirstName LastName';
		reviewData.image     = 'placeholder';
		reviewData.rating    = 5;
		reviewData.timestamp = '2 weeks ago';
		reviewData.content   = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda beatae in laborum laudantium neque omnis optio quasi qui sit voluptatum!';

		for ( let index = 0; 12 > index; index++ ) {
			reviewsData.push( reviewData );
		}

		this.replaceReviews( reviewsData );
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
}

export default ReviewCollection;
