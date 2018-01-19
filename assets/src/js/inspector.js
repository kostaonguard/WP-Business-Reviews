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
}

export default Inspector;
