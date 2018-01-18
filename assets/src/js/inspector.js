import FieldFactory from './field-factory';
import PlatformSearchField from './platform-search-field';

class Inspector {
	constructor( element ) {
		this.root = element;
		this.fieldFactory = new FieldFactory();
		this.fields = new Map();
	}

	init() {
		this.initFields();
		this.initPlatformSearchField();
	}

	initFields( selector ) {
		const fieldEls = this.root.querySelectorAll( '.js-wpbr-field' );

		fieldEls.forEach( ( fieldEl ) => {
			const fieldId   = fieldEl.dataset.wpbrFieldId;
			const fieldType = fieldEl.dataset.wpbrFieldType;
			const field     = this.fieldFactory.createField( fieldEl, fieldType );

			if ( field ) {
				field.init();
				this.fields.set( fieldId, field );
			}
		});
	}

	initPlatformSearchField() {
		const fieldEl = document.getElementById( 'wpbr-field-platform_search' );
		const field   = new PlatformSearchField( fieldEl );

		field.init();
		this.fields.set( field.fieldId, field );
	}
}

export default Inspector;
