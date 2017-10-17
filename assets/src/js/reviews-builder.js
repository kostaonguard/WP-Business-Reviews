import Field from './field';
import GooglePlacesTextSearch from './google-places-text-search';

class ReviewsBuilder {
	constructor( selector ) {
		this.container = document.querySelector( selector );
		this.reviews = this.container.querySelectorAll( '.js-wpbr-review' );
		this.formatControl = this.container.querySelector( '.js-wpbr-field-format .js-wpbr-control' );
		console.log( 'this.reviews: ', this.reviews );

		const googlePlacesTextSearch = new GooglePlacesTextSearch( `${selector} .js-wpbr-section-business` );
		googlePlacesTextSearch.init();

		const field = new Field( 'format' );
		console.log( 'field: ', field );
		console.log( field.getValue() );
	}

	init() {

	}


}

export default ReviewsBuilder;
